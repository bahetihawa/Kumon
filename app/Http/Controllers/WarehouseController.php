<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Consignment;
use App\Orders;
use Input;
use File;
use Excel;
use Validator;
use DB;
use App\Category;
use App\Item;
use App\Stoks;

/*
 *  Helping quotes for phpexcel 
 *  $fileName = $file->getClientOriginalName(); // getClient follod by property
 * $destinationPath = 'uploads';
 * $contents = File::get( $destinationPath.'/'. $fileName);
 *  config(['excel.import.startRow' => 6]);
 * $rows = Excel::selectSheetsByIndex(0)->load(Input::file('file'), function($reader) {
 *   $reader->noHeading();
 *  })->get();
 * 
 * 
 */
class WarehouseController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
        $this->middleware(function($request,$next){
            if(Auth::user() && Auth::user()->role !=3){
                Auth::logout();
                    return redirect()->to('/');
            }else{
                 return $next($request);
            }
        });
    }
    
    public function stock(Request $request){
        $author = Auth::id();
        $cond = ["warehouse"=>$author];
        $cnd = [1 ];
        if (Input::has('search'))
        {
            $cnd = trim(Input::get('search'));
            $data = Stoks::where($cond)->with("Items")->whereHas('Items', function($q) use ($cnd){
            $q->where('code','like', '%'.$cnd.'%' )->orWhere('item','like', '%'.$cnd.'%');})->paginate(10);
        }else{
           $data = Stoks::where($cond)->paginate(10);
        }
        
        
        return view("warehouse.stock",["left_title"=>"warehouse",'data'=>  $data,"include"=>"tableAvailble"]);
    }
    public function stockCenter(){
       $dd = Item::all()->toArray();
       $ds = array();
        foreach($dd as $d){
            $key = str_slug(strtolower($d["code"]),'-');
            $ds[$key] = $d["id"];
        }
        return $ds;
    }
    
    public function consignments(){
        $author = Auth::id();
        $data = Orders::where('warehouse',$author)->orderBy('id', 'desc')->paginate(10);
        return view("warehouse.stock",["left_title"=>"warehouse",'data'=>  $data,"include"=>"tableConsignment","input"=>"consignment"]);
    }
    public function transfer(){
        return "transfer";
    }
    public function render(Request $request){
        $author = Auth::id();
        $rules = array(
            'file' => 'required',
            'start' => 'required',
            'sheet' => 'required',
        );
     //   dd($request);
        if($request->isMethod('post')){
            $validator = Validator::make(Input::all(), $rules);
             // process the form
            if ($validator->fails()) 
            {  echo "fai";
                return redirect()->back()->withErrors($validator);
            }
        }
        if ($request->hasFile('file')) {
            $data = $this->upload($request);
        }
         if(!empty($data)){
             echo "hello";
         }
        
        $data = Orders::where('warehouse',$author)->orderBy('id', 'desc')->paginate(10);
        return view("warehouse.stock",["left_title"=>"warehouse",'data'=>  $data,"include"=>"tableConsignment","input"=>"render"]);
    }
    
    public function create(Request $request){
        $author = Auth::id();
        $rules = array(
            'file' => 'required',
            'freight' => 'required',
            'start' => 'required',
            'sheet' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
            // process the form
        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator);
        }
        $CatCollection = $this->CatCollection();
        $itemCollection = $this->itemCollection();//dd($itemCollection);
       if ($request->hasFile('file')) {
           extract(Input::All());
           $file = $request->file('file');
           $fileName = $file->getClientOriginalName();
           $destinationPath = 'uploads';
           if(file_exists($destinationPath."/".$fileName)){
                return redirect()->back()->with(["message"=>'Record Already Exists.']);
           }else{
           $file->move($destinationPath,$fileName);
           
            config(['excel.import.startRow' => $start]);
             $data = Excel::selectSheetsByIndex($sheet)->load($destinationPath."/".$fileName, function($reader) {
              // $reader->noHeading();
           })->toArray();//dd($data);
           $x = Orders::Create(["file"=>$fileName]);
           if(!empty($data)){
               foreach ($data as $key => $value) {
                $itemCode = str_slug($value["item_code"]);
                   if(!array_key_exists($itemCode,$itemCollection)){
                       $this->createNewItem($value);
                   }
               }
               $this->loadStacks();
               //Stoks::where("warehouse",0)->update(["warehouse"=>$author]);
               $itemCollection = $this->itemCollection();
		foreach ($data as $key => $value) {
                    $order = trim($value['order_no']);
                   if($order != ""):
                       $this->order = $order;
                    $insert[] = ['orderNo' => $x->id, 
                        'warehouse'=>$author, 
                        'item' => $itemCollection[str_slug($value["item_code"],'-')],
                        "category" =>$CatCollection[strtolower($value["subject"])],
                        'freight' =>0,
                        "quantity"=>$value["order_quantity"],
                        'ammount_myr'=>$value["amount_myr"],
                        'exchange_rate'=>$value["exchange_rate"],
                        'ammount_inr'=>$value["amount_in_inr"],
                        "created_at"=>date("Y-m-d H:i:s"),
                        ];
                   endif;
		}

		if(!empty($insert)){
                    
                    
                    $sum = array_column($insert, "ammount_inr");
                    $sum = array_sum($sum);
                    $ratio = $freight/$sum;
                    $insert1 =$insert;
                    $insert = $this->freightDivision($insert1,$ratio);
                    if(Consignment::insert($insert)):
                        $y = Orders::where("id",$x->id)->update([
                            "warehouse"=>$author,
                            "orderNo"=>$this->order,
                            "orderDate"=>date("Y-m-d H:i:s"),
                            "freight"=>$freight,
                            "others"=>$other,
                            "cnf"=>$cnf,
                            "custom"=>$custom,
                            "amount"=>$sum,
                            "sum"=>$freight+$sum+$cnf+$custom+$other,
                        ]); 
                        
                    endif;
                    if(!isset($y)){
                        Oders::destroy($x->id);
                        Consignment::where('orderNo', $x->id)->delete();
                        unlink($destinationPath."/".$fileName);
                    }
		}

            }
             return redirect()->back()->with(["message"=>'Record Added successfully']);
          }
        }
       
    }
    public function CatCollection(){
         $dd = Category::all()->toArray();
        foreach($dd as $d){
            $ds[strtolower($d["category"])] = $d["id"];
        }
        return $ds;
    } 
    public function itemCollection(){
         $dd = Item::all()->toArray();
         $ds = array();
        foreach($dd as $d){
            $key = str_slug(strtolower($d["code"]),'-');
            $ds[$key] = $d["id"];
        }
        return $ds;
    }
    public function createNewItem(array $array){
        $CatCollection = $this->CatCollection();
        $name = $array["item_name"];
        $od = $array["order_no"];
        $code = $array["item_code"];
        $subject = strtolower($array["subject"]);
        $subject_code = $array["subject_code"];
        if(isset($subject) && isset($name) && isset($od)):
            $data["item"] = $name;
            $data["code"] = $code;
            $data["category"] = $CatCollection[$subject];
        endif;
        if(isset($data))
        Item::Create($data);
        
    } 
    public function loadStacks(){
       $author = Auth::id();
       $data = array();
       $roles = Stoks::where("warehouse",$author)->pluck('specify')->toArray();
       $id = Item::whereNotIn("id",$roles)->get();
       foreach($id as $v){
            $data[] = ["category"=>$v->category,
                        "unit_price"=>0,
                        "count"=>0,
                        "specify"=>$v->id,
                        "warehouse"=>$author,
                ];
       }
       Stoks::insert($data);
    }
    
    public function freightDivision(array $array,$ratio){
        $d = [];
        foreach($array as $v):
            $v["freight"] = $ratio*$v["ammount_inr"];
            $v["total"] = (1+$ratio)*$v["ammount_inr"];
            $d[] = $v;
        endforeach;
        return $d;
    }
    
    public function upload($request){
        extract(Input::All());
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $destinationPath = 'uploads';
        if(file_exists($destinationPath."/".$fileName)){
            return redirect()->back()->with(["message"=>'Record Already Exists.']);
        }else{
            $file->move($destinationPath,$fileName);

            config(['excel.import.startRow' => $start]);
            $data = Excel::selectSheetsByIndex($sheet)->load($destinationPath."/".$fileName, function($reader) {
                  // $reader->noHeading();
            })->toArray();
         return $data;
        }
    }
    
    public function addCharges(Request $request){
        dd(Input::all());
    }
}
