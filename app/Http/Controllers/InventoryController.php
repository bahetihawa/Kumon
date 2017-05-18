<?php

namespace App\Http\Controllers;
use Input;
use Illuminate\Http\Request;
use Auth;
use App\Stoks;
use App\Warehouse;
use DB;
use App\User;
use App\Orders;
use App\Category;
use App\Item;
use App\Transfer;
use App\Render;
use Illuminate\Pagination\LengthAwarePaginator;//Paginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
class InventoryController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(function($request,$next){
            if(Auth::user() && Auth::user()->role !=1){
                Auth::logout();
                    return redirect()->to('/home');
            }else{
                 return $next($request);
            }
        });
    }
    public function orders($store){
       if(Warehouse::where("id",$store)->exists() ==false ){
            if($store != 0)
            return back()->with(["message"=>"undefined action"]);
        }
       if($store !=0){
        $data = Orders::where('warehouse',$store)->orderBy('id', 'desc')->paginate(10);
       }else{
            $data = Orders::orderBy('id', 'desc')->paginate(10);
       }
        $w = Warehouse::all();  
        $store != 0 ? $w1 = Warehouse::where('id',$store)->pluck('centerName')->toArray()[0] : $w1 ="All Warehouses";//dd($store);
        return view("stock",["left_title"=>"Orders",'data'=>  $data,"include"=>"tableConsignment",'warehouse'=>$w,'wareName'=>$w1]);
    }

    public function stockCenter(){
        return "stockCenter";
    }


    public function stockWarehouses($wc = null){
        
        if($wc != 0){
            $auth = User::where("frenchise",$wc)->pluck("id")->toArray();
            $author = $auth['0'];
        }
        if(Warehouse::where("id",$wc)->exists() ==false ){
            if($wc != 0)
            return back()->with(["message"=>"undefined action"]);
        }
        if($wc != 0) :
            if (Input::has('search'))
            {
                $cnd = trim(Input::get('search'));
                $data = Stoks::where("warehouse",$author)->with("Items")->whereHas('Items', function($q) use ($cnd){
                $q->where('category','!=',1)->where('code','like', '%'.$cnd.'%' )->orWhere('item','like', '%'.$cnd.'%');})->paginate(10);
            }else{
                $data = Stoks::where("warehouse",$author)->where('category','!=',1)->paginate(10);
            }
        else:
            if (Input::has('search'))
            {
                $cnd = trim(Input::get('search'));
                $data = DB::table('items')
                    ->rightJoin('stoks','items.id','=','stoks.specify')
                    ->select(DB::raw('items.item'),DB::raw('items.code'), DB::raw('sum(count) as count'))
                    ->where('items.category','!=',1)
                    ->where('code','like', '%'.$cnd.'%' )
                    ->orWhere('item','like', '%'.$cnd.'%')
                    ->groupBy(DB::raw('specify') )
                    ->paginate(10);
            }else{
                    $data = DB::table('items')
                    ->rightJoin('stoks','items.id','=','stoks.specify')
                    ->select(DB::raw('items.item'),DB::raw('items.code'), DB::raw('sum(count) as count'))
                    ->where('items.category','!=',1)
                    ->groupBy(DB::raw('specify') )
                    ->paginate(10);
            }
        endif;
        $w = Warehouse::all();
        $wareName = Warehouse::where("id",$wc)->pluck("centerName")->first();//echo $author;
        return view("stock",["left_title"=>"warehouse",'data'=>  $data,"include"=>"tableAvailble",'warehouse'=>$w,"wareName"=>$wareName]);
    }
    public function wks($wc = null){
       
        if($wc != 0){
            $auth = User::where("frenchise",$wc)->pluck("id")->toArray();
            $author = $auth['0'];
        }
        if(Warehouse::where("id",$wc)->exists() ==false ){
            if($wc != 0)
            return back()->with(["message"=>"undefined action"]);
        }
        if($wc != 0) :
            if (Input::has('search'))
            {
                $cnd = trim(Input::get('search'));
                $data = Stoks::where("warehouse",$author)->with("Items")->whereHas('Items', function($q) use ($cnd){
                $q->where('category',1)->where('code','like', '%'.$cnd.'%' )->orWhere('item','like', '%'.$cnd.'%');})->paginate(10);
            }else{
                $data = Stoks::where("warehouse",$author)->where('category',1)->paginate(10);
            }
        else:
            if (Input::has('search'))
            {
                $cnd = trim(Input::get('search'));
                $data = DB::table('items')
                    ->rightJoin('stoks','items.id','=','stoks.specify')
                    ->select(DB::raw('items.item'),DB::raw('items.code'), DB::raw('sum(count) as count'))
                    ->where('items.category',1)
                    ->where('code','like', '%'.$cnd.'%' )
                    ->orWhere('item','like', '%'.$cnd.'%')
                    ->groupBy(DB::raw('specify') )
                    ->paginate(10);
            }else{
                    $data = DB::table('items')
                    ->rightJoin('stoks','items.id','=','stoks.specify')
                    ->select(DB::raw('items.item'),DB::raw('items.code'), DB::raw('sum(count) as count'))
                    ->where('items.category',1)
                    ->groupBy(DB::raw('specify') )
                    ->paginate(10);
            }
        endif;
        $w = Warehouse::all();
        $wareName = Warehouse::where("id",$wc)->pluck("centerName")->first();
        return view("stock",["left_title"=>"warehouse",'data'=>  $data,"include"=>"tableAvailble",'warehouse'=>$w,"wareName"=>$wareName]);
    }
    public function wksLevel($wc = null){
        
        if($wc != 0){
            $auth = User::where("frenchise",$wc)->pluck("id")->toArray();
            $author = $auth['0'];
        }
        if(Warehouse::where("id",$wc)->exists() ==false ){
            if($wc != 0)
            return back()->with(["message"=>"undefined action"]);
        }
        $wks = Category::where('category',"wks")->pluck('id');
       $parent = $wks[0];
       $cat = Category::where('parent',$parent)->get()->toArray();

        $iLevel = (new UtilityController)->get_level_group();
        if (Input::has('search'))
        {
                $cnd = trim(Input::get('search'));
                $iLevel = (new UtilityController)->searchCond($cnd);
        }
        foreach($iLevel as $kv=>$lv):
            
            
        if($wc != 0) :
            
                 $data[$kv] = Stoks::where(["warehouse"=>$author,'category'=>1])->with("Item")->whereHas('Items', function($q) use ($lv,){
                $q->where('sSub_cat',$lv);})->sum('count');
                 $prc[$kv] = Stoks::where(["warehouse"=>$author,'category'=>1])->with("Items")->whereHas('Items', function($q) use ($lv){
                $q->where('sSub_cat',$lv);})->pluck('unit_price')->first();
                $data1 = Render::where(["warehouse"=>$author])->with("Items")->whereHas('Items', function($q) use ($lv){
                $q->where('sSub_cat',$lv);});
                $qt = $data1->sum('quantity');
                $data_cnt[$kv] = $qt;

                $data2 = Transfer::where(["warehouseTo"=>$author])->with("Items")->whereHas('Items', function($q2) use ($lv){
                $q2->where('sSub_cat',$lv);});
                $qt2 = $data2->sum('quantity');
                $data_tr[$kv] = $qt2;
            
        else:
            $data[$lv] = Stoks::where(['category'=>1])->with("Item")->whereHas('Items', function($q) use ($lv){
                $q->where('sSub_cat',$lv);})->sum('count');
                 $prc[$kv] = Stoks::where(['category'=>1])->with("Items")->whereHas('Items', function($q) use ($lv){
                $q->where('sSub_cat',$lv);})->pluck('unit_price')->first();
                $data1 = Render::with("Items")->whereHas('Items', function($q) use ($lv){
                $q->where('sSub_cat',$lv);});
                $qt = $data1->sum('quantity');
                $data_cnt[$kv] = $qt;

             $data12 = Render::with("Items")->whereHas('Items', function($q2) use ($lv){
                $q2->where('sSub_cat',$lv);});
                $qt2 = $data12->sum('quantity');
                $data_tr[$kv] = $qt2;
            
        endif;
        endforeach;
         $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $perPage = 10;
        $currentPageSearchResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        $units= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        $w = Warehouse::all();
        $wareName = Warehouse::where("id",$wc)->pluck("centerName")->first();//dd($wareName);
        return view("stock",["left_title"=>"warehouse",'data'=>  $units,'unit_price'=>$prc,"include"=>"tableLevelStock",'warehouse'=>$w,"wareName"=>$wareName,'countCenter'=>$data_cnt,'byTransfer'=>$data_tr]);
    }
    public function create(){
        return "create";
    }
    public function transfer(){
        return "transfer";
    }
    public function render(){
        return "render";
    }
}
