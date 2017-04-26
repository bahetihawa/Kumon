<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Country;
use App\Province;
use App\District;
use App\Center;
use App\Warehouse;
use App\Item;
use App\Orders;
use App\Render;
use App\Transfer;
use Input;
use Excel;
use App\Stoks;
use App\Consignment;
use App\Integration;
use App\user;
use Illuminate\Support\Facades\Auth;
class UtilityController extends Controller
{
 
    public function __construct()
    {
         ini_set('max_execution_time', 300);
        $this->middleware('auth');
        /*$this->middleware(function($request,$next){
            if(Auth::user() && Auth::user()->role !=1){
                Auth::logout();
                    return redirect()->to('/');
            }else{
                 return $next($request);
            }
        });*/
    }
    public function index()
    {     if(Auth::check()){
              return redirect()->route('home');
         }
             return view('welcome');
         
    }
    public function rename(Request $request)
    {   $res = "Update Fails";
        if($request->input("model") == "Category"):
            if(Category::where("id",$request->input('id'))->update(["category"=>$request->input("newName")])):
                $res = "Success";
            endif;
        elseif($request->input("model") == "Country"):
            if(Country::where("id",$request->input('id'))->update(["country"=>$request->input("newName")])):
                $res = "Success";
            endif;
        elseif($request->input("model") == "Province"):
            if(Province::where("id",$request->input('id'))->update(["province"=>$request->input("newName")])):
                $res = "Success";
            endif;
        elseif($request->input("model") == "District"):
            if(District::where("id",$request->input('id'))->update(["district"=>$request->input("newName")])):
                $res = "Update Success";
            endif;
        elseif($request->input("model") == "Item"):
            if(Item::where("id",$request->input('id'))->update(["item"=>$request->input("newName"),"code"=>$request->input("newCode")])):
                $res = "Update Success";
            endif;
        endif;
        
        echo $res;
    }
    public function registerCenter(Request $request){
        if($request->input("data") == 2)
        $cent = Center::all();
        if($request->input("data") == 3)
        $cent = Warehouse::all();
        return view('include.locationlist',["location"=>$cent,'mod'=>"regCenter"]);
    }
    public function download($file){
        $filename1 = Orders::where("id",$file)->pluck("file")->first();
        $filename = "uploads/".$filename1;
        if(!file_exists($filename)){
            return back()->with(["message"=>"Record Id: ".$file." : Requested file moved or deleted"]);
        }
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename= ".$filename1);
        header("Content-Transfer-Encoding: binary");    
        readfile($filename);
        return back();
    }
    
    public function getGrn($file){
        $order = Orders::where('id',$file)->pluck('orderNo')[0];
        $data = Consignment::where("orderNo",$file)->with('Items')->get()->toArray();
        $ct =   Auth::id();
        $center = Warehouse::where("id",$ct)->get()->toArray()[0];
       $code = $this->getCodeRef("GRN",$center['centerCode'],  time());
        
        $center['country'] = Country::where('id',$center['country'])->pluck('country')[0];
        $center['province'] = Province::where('id',$center['province'])->pluck('province')[0];
        $center['district'] = District::where('id',$center['district'])->pluck('district')[0];
       //dd($center);
        Excel::create('GRN_'.$code, function($excel) use ($file,$data,$center,$code,$order) {

            // Set the title
            $excel->setTitle('GRN_'.$file);
            // Chain the setters
            $excel->setCreator('Roster')
                  ->setCompany('Kumon');
            // Call them separately
            $excel->setDescription('GRN of ');
            
            $excel->sheet($file, function($sheet) use ($file,$data,$center,$code,$order){

                $sheet->loadView('grn',["data"=>$data,'center'=>$center,'date'=>$file,'grnRef'=>$code,'invoice'=>$order]);

            });

        })->export('xlsx');
    }
    public function getDn($file){
       // $order = Orders::where('updated_at',$file)->pluck('orderNo')[0];
        $data = Render::where("updated_at",$file)->with('Items')->get()->toArray();
        $ct =   Auth::id();
        $center = Warehouse::where("id",$ct)->get()->toArray()[0];
       $code = $this->getCodeRef("DN",$center['centerCode'],$file);
        $prc = Stoks::where('warehouse',$ct)->pluck('unit_price','specify')->toArray();
        $center['country'] = Country::where('id',$center['country'])->pluck('country')[0];
        $center['province'] = Province::where('id',$center['province'])->pluck('province')[0];
        $center['district'] = District::where('id',$center['district'])->pluck('district')[0];
       //dd($center);
        Excel::create('DN_'.$code, function($excel) use ($file,$data,$center,$code,$prc) {

            // Set the title
            $excel->setTitle('DN_'.$file);
            // Chain the setters
            $excel->setCreator('Roster')
                  ->setCompany('Kumon');
            // Call them separately
            $excel->setDescription('GRN of ');
            
            $excel->sheet($file, function($sheet) use ($file,$data,$center,$code,$prc){

                $sheet->loadView('dn',["data"=>$data,'center'=>$center,'date'=>$file,'grnRef'=>$code,'price'=>$prc]);

            });

        })->export('xlsx');
    }
    public function getCodeRef($text,$center,$time){
        $month =  $date = date('m', $time);
        $year = date('y', $time);
        if($month > 3){
            $code = $month-3;
            $ses = $year."-".($year+1);
        }else{
            $code = $month+9;
            $ses = ($year-1)."-".$year;
        }
        return $text."/".$center."/".$ses."/".str_pad($code, 3, '0', STR_PAD_LEFT);
    }
    public function getCent(){
        $id = Input::get('id');
        $cnt = Center::join('integrations','integrations.center','=','centers.id')->where('integrations.warehouse',$id)->pluck("centerName","centers.id")->toArray();
//print_r($it);die;
        return view("warehouse.option",['data'=>$cnt]);
    }
    
    public function getTn($file){
       // $order = Orders::where('updated_at',$file)->pluck('orderNo')[0];
        $data = Transfer::where("updated_at",$file)->with('Items')->get()->toArray();
        $ct =   Auth::id();
        $center = Warehouse::where("id",$ct)->get()->toArray()[0];
       $code = $this->getCodeRef("DN",$center['centerCode'],$file);
        $prc = Stoks::where('warehouse',$ct)->pluck('unit_price','specify')->toArray();
        $center['country'] = Country::where('id',$center['country'])->pluck('country')[0];
        $center['province'] = Province::where('id',$center['province'])->pluck('province')[0];
        $center['district'] = District::where('id',$center['district'])->pluck('district')[0];
       //dd($center);
        Excel::create('TN_'.$code, function($excel) use ($file,$data,$center,$code,$prc) {

            // Set the title
            $excel->setTitle('TN_'.$file);
            // Chain the setters
            $excel->setCreator('Roster')
                  ->setCompany('Kumon');
            // Call them separately
            $excel->setDescription('GRN of ');
            
            $excel->sheet($file, function($sheet) use ($file,$data,$center,$code,$prc){

                $sheet->loadView('tn',["data"=>$data,'center'=>$center,'date'=>$file,'grnRef'=>$code,'price'=>$prc]);

            });

        })->export('xlsx');
    }

    public function stockStatus()
    {
       $data = $this->opening(Auth::id());
       extract($data);
        Excel::create('OpeningStock_'.date("m-Y"), function($excel) use ($wdata,$cent,$headings,$were,$css) {

            // Set the title
            $excel->setTitle('OpeningStock_'.date("m-Y"));
            // Chain the setters
            $excel->setCreator('Roster')
                  ->setCompany('Kumon');
            // Call them separately
            $excel->setDescription('date("m-Y")');
            
            $excel->sheet($were, function($sheet) use ($wdata,$cent,$headings,$were,$css){
                $sheet->setFreeze('D8');
               // $sheet->setAutoSize(false);
                $sheet->loadView('stackDown',['wdata'=>$wdata,'cent'=>$cent,'header'=>$headings,'ware'=>$were,'css'=>$css]);

            });

        })->export('xlsx');

        
    }


    public function level_get(){
         $wks = Category::where('category',"wks")->pluck('id');
       $parent = $wks[0];
       $cat = Category::where('parent',$parent)->get()->toArray();
      foreach($cat as $cats){
          $sCat = Category::where('parent',$cats['id'])->get()->toArray();
          foreach ($sCat as $level){
            $iLevel[] = $cats['category']." WKS ".$level["category"];
            
          }
      }
      
      return $iLevel;
    }

    public function opening($auth){
        $author = $auth;$totVal = 0;$css = [];
        $wh = User::find($auth)->frenchise;
        $were = Warehouse::find($wh)->centerCode;//dd($were);
        $cent = Center::with('integration')->whereHas("integration",function($x) use($wh){
            $x->where('warehouse',$wh);
        })->pluck('concern','id')->toArray();
         $cent1 = Center::with('integration')->whereHas("integration",function($x) use($wh){
            $x->where('warehouse',$wh);
        })->pluck('centerName','concern')->toArray();
        //dd($cent);
        $head = ["Sr"=>'',"Item Code"=>"","Item Name"=>'',"Qyt at Wh. ".$were=>''];
        $heading = array_merge($head,$cent1);
        $tot = ["Total qty in ".$were." centres"=>"","Total qty in ".$were=>'','Weighted Avarege Cost'=>"WAC",'Value in Centers'=>'','Total Stok Value'=>''];
        $headings = array_merge($heading,$tot);
        $whData = Stoks::where(["warehouse"=>$author,'category'=>1])->with("items")->get()->toArray();
        foreach ($whData as $key => $value) {
            $k = $value['items']['item'];
            $wdata[$k] = ['code'=>$value['items']['code'],'item'=>$value['items']['item'],"qt"=>$value['count']];
            foreach ($cent as $key1 => $value1) {
                 $wdata[$k][$value1] = "";
            }
            $wdata[$k]['tot_cent'] = 0;
            $wdata[$k]['tot_wh'] = $value['count'];
            $wdata[$k]['wac'] = $value['unit_price'];
            $wdata[$k]['val_cent'] = 0;
            $wdata[$k]['stack_val'] = $value['count']*$value['unit_price'];
        }
        //dd($wdata);
        $iLevel = $this->level_get();
        foreach ($iLevel as $key => $lv) {
            $lvs = explode(" ", $lv);
            $data = Stoks::where(["warehouse"=>$author])->with("Items")->whereHas('Items', function($q) use ($lvs,$lv){
                $q->where('item','like', '%'.$lvs[0].'%')->where('item','like', '%'.$lvs[1]." ".$lvs[2].'%')->where('item','like', '%'.$lvs[2].'%');})->sum('count');

           $wdata[$lv."000"] = ['code'=>$lv."000",'item'=>$lv,"qt"=>$data];
           $prc = Stoks::where(["warehouse"=>$author])->with("Items")->whereHas('Items', function($q) use ($lvs,$lv){
                $q->where('item','like', '%'.$lvs[0].'%')->where('item','like', '%'.$lvs[1]." ".$lvs[2].'%')->where('item','like', '%'.$lvs[2].'%');})->first()->unit_price;
           $totCent = 0;
           foreach ($cent as $key1 => $value1) {

                $data1 = Render::where(["warehouse"=>$author,'target'=>$key1])->with("Items")->whereHas('Items', function($q) use ($lv,$lvs){
                $q->where('item','like', '%'.$lvs[0].'%')->where('item','like', '%'.$lvs[1]." ".$lvs[2].'%')->where('item','like', '%'.$lvs[2].'%');});
                $qt = $data1->sum('quantity');
                //$data = $qt;

                $data2 = Transfer::where(["warehouseTo"=>$author,'target'=>$key1])->with("Items")->whereHas('Items', function($q2) use ($lv,$lvs){
                $q2->where('item','like', '%'.$lvs[0].'%')->where('item','like', '%'.$lvs[1]." ".$lvs[2].'%')->where('item','like', '%'.$lvs[2].'%');});
                $qt2 = $data2->sum('quantity');
               // $data_tr = $qt2;
                $qtx = $qt+$qt2;
                 $wdata[$lv."000"][$value1] = $qtx;
                 $totCent +=$qtx;
                 $totVal +=$qtx*$prc;
            }
            $wdata[$lv."000"]['tot_cent'] = $totCent;
            $wdata[$lv."000"]['tot_wh'] = $totCent+$data;
            $wdata[$lv."000"]['wac'] = $prc;
            $wdata[$lv."000"]['val_cent'] = $prc*$totCent;
            $wdata[$lv."000"]['stack_val'] = ($totCent+$data)*$prc;
            $css[] = $lv."000";
        }//dd($wdata);

        $whData1 = Stoks::where("warehouse",$author)->where('category','!=',1)->with("items")->get()->toArray();
        foreach ($whData1 as $key => $value) {
            $k = $value['items']['item'];
            $wdata1[$k] = ['code'=>$value['items']['code'],'item'=>$value['items']['item'],"qt"=>$value['count']];
            foreach ($cent as $key1 => $value1) {
                 $wdata1[$k][$value1] = "";
            }
            $wdata1[$k]['tot_cent'] = 0;
            $wdata1[$k]['tot_wh'] = $value['count'];
            $wdata1[$k]['wac'] = $value['unit_price'];
            $wdata1[$k]['val_cent'] = 0;
            $wdata1[$k]['stack_val'] = $value['count']*$value['unit_price'];
            $css[] = $k;
        }
        
        ksort($wdata);//dd($wdata1);
        $da = array_merge($wdata1,$wdata);
        $wdata = $da;
        $sumWh = Stoks::where("warehouse",$author)->sum('count');//dd($sumWh);
         $sumWhPrc = Stoks::where("warehouse",$author)->selectRaw('SUM(count * unit_price) as total')->pluck('total')->toArray()[0];
        $sumR = Render::where("warehouse",$author)->with("Items")->whereHas('Items', function($q2){
                $q2->where('category',1);})->sum('quantity');
        $sumT = Transfer::where("warehouseTo",$author)->with("Items")->whereHas('Items', function($q21) {
                $q21->where('category',1);})->sum('quantity');
        $sumC = $sumR+$sumT;//dd($sumC);
       // foreach ($whData as $key => $value) {
            $k = "Total";
            $wdata[$k] = ['code'=>"",'item'=>"Total","qt"=>$sumWh];
            foreach ($cent as $key1 => $value1) {
                 $wdata[$k][$value1] = "";
            }
            $wdata[$k]['tot_cent'] = $sumC;
            $wdata[$k]['tot_wh'] = $sumWh+$sumC;
            $wdata[$k]['wac'] = "";
            $wdata[$k]['val_cent'] = $totVal;
            $wdata[$k]['stack_val'] = $sumWhPrc+$totVal;
            $css[] = $k;
            return ['wdata'=>$wdata,'cent'=>$cent,'headings'=>$headings,'were'=>$were,'css'=>$css];
    }

    public function stockStatusAll()
    {
        $wh = User::where('role',3)->pluck('id')->toArray();//dd($wh);
       foreach ($wh as $key => $value) {
           $data[$value] = $this->opening($value);
       }
       
      // dd($data);
        Excel::create('OpeningStock_'.date("m-Y"), function($excel) use ($data) {

            // Set the title
            $excel->setTitle('OpeningStockAllWareHouse_'.date("m-Y"));
            // Chain the setters
            $excel->setCreator('Roster')
                  ->setCompany('Kumon');
            // Call them separately
            $excel->setDescription('date("m-Y")');
            foreach ($data as $k => $v) {
                extract($v);
            
                $excel->sheet($were, function($sheet) use ($wdata,$cent,$headings,$were,$css){
                    $sheet->setFreeze('D8');
                    $sheet->loadView('stackDown',['wdata'=>$wdata,'cent'=>$cent,'header'=>$headings,'ware'=>$were,'css'=>$css]);

                });
            }

        })->export('xlsx');

        
    }

    public function uploadStacks(Request $request){
        ini_set('max_execution_time', 300);

       
        if ($request->isMethod('post'))
        {
            extract(Input::All());
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $destinationPath = 'uploads';
             @unlink($destinationPath."/".$fileName);
            if(file_exists($destinationPath."/".$fileName)){
                $err = "error";
                return $err;
            }else{
                $file->move($destinationPath,$fileName);
                 $this->fileName = $destinationPath."/".$fileName;
                //config(['excel.import.startRow' => 1]);
                $data = Excel::selectSheetsByIndex(0)->load($destinationPath."/".$fileName, function($reader) {
                      
                })->toArray();
             //  dd($data);
                foreach ($data as $key => $value) {
                  $dat = Item::where('items.code',$value['code'])->pluck('id')->toArray();
                  foreach ($value as $key1 => $value1) {
                      Stoks::where(["warehouse"=>$key1])->whereIn('specify',$dat)->update(["unit_price"=>$value['wac'],'count'=>$value1]);
                  }
                }
               // dd($dat);
             //return $data;
            }
        }
        return view('uploadStack');
        

    }

    public function stockCenter(Request $request){
        ini_set('max_execution_time', 300);

       
        if ($request->isMethod('post'))
        {
            extract(Input::All());
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $destinationPath = 'uploads';
             unlink($destinationPath."/".$fileName);
            if(file_exists($destinationPath."/".$fileName)){
                $err = "error";
                return $err;
            }else{
                $file->move($destinationPath,$fileName);
                 $this->fileName = $destinationPath."/".$fileName;
                //config(['excel.import.startRow' => 1]);
                $data = Excel::selectSheetsByIndex(0)->load($destinationPath."/".$fileName, function($reader) {
                      // $reader->noHeading();
                  /* foreach ($reader->toArray() as $row) {
                                             $bb[] = $row;
                                             $dd($row);
                        }
                    echo '<pre>';print_r($bb );echo '</pre>';  die();*/
                })->toArray();
               $time = time();
               $date = date("Y-m-d");
                foreach ($data as $key => $value) {
                  $dat = Item::where('items.code',$value['code'])->pluck('id')->toArray();
                  foreach ($value as $key1 => $value1) {
    
                      $cent1 = Center::where("concern",'like','%'.$key1.'%')->pluck("id")->toArray();
                      if(!empty($cent1)){
                        $it = Integration::where('center',$cent1[0])->pluck('warehouse')->toArray();
                         $ware = User::where('frenchise',$it[0])->pluck('id')->toArray()[0];

                         $insert[] = [
                                        'item'=>$dat[0],
                                        'quantity'=>(int)$value1,
                                        'target'=>$cent1[0],
                                        'targetType'=>1,
                                        'warehouse'=>$ware,
                                        'created_at'=>$date,
                                        'updated_at'=>$time,
                                        'filename'=>""
                                    ];
                      }
                    
                  } //dd($ware);
            }
        }  
        Render::insert($insert); 
      }
                      
        //dd($insert);
        return view('uploadStack');
    }

    public function downloadRender($file){
        $filename1 = Render::where("updated_at",$file)->pluck("filename")->first();
        $filename = "uploads/".$filename1;
        if(!file_exists($filename)){
            return back()->with(["message"=>"Record Id: ".$file." : Requested file moved or deleted"]);
        }
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename= ".$filename1);
        header("Content-Transfer-Encoding: binary");    
        readfile($filename);
        return back();
    }
    
    public function loadStacks(){
       $x = User::where('role',3)->pluck('id')->toArray();
       foreach($x as $vs):
            $author = $vs;
            $data = array();
            $roles = Stoks::where("warehouse",$author)->pluck('specify')->toArray();
            $id = Item::whereNotIn("id",$roles)->get();
            foreach($id as $v){
                 $data[] = ["category"=>$v->category,
                             "unit_price"=>0,
                             "count"=>0,
                             "specify"=>$v->id,
                             "warehouse"=>$author
                     ];
            }
        
       Stoks::insert($data);
       endforeach;
    }
    
    public function matchStacks(Request $request){
        ini_set('max_execution_time', 300);

       
        if ($request->isMethod('post'))
        {
            extract(Input::All());
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $destinationPath = 'uploads';
             @unlink($destinationPath."/".$fileName);
            if(file_exists($destinationPath."/".$fileName)){
                $err = "error";
                return $err;
            }else{
                $file->move($destinationPath,$fileName);
                 $this->fileName = $destinationPath."/".$fileName;
                //config(['excel.import.startRow' => 1]);
                $data = Excel::selectSheetsByIndex(0)->load($destinationPath."/".$fileName, function($reader) {
                      
                })->toArray();
             //  dd($data);
                $dd = array();
                foreach ($data as $key => $value) {
                  $dat = Item::where('items.code',$value['code'])->pluck('id')->toArray();
                  if($dat[0]==''){
                      $dd[]=$value['code'];
                  }
                }
                dd($dd);
             //return $data;
            }
        }
        return view('uploadStack');
        

    }
}