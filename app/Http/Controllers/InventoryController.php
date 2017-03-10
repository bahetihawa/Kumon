<?php

namespace App\Http\Controllers;
use Input;
use Illuminate\Http\Request;
use Auth;
use App\Stoks;
use App\Warehouse;
use DB;
use App\Orders;
use App\Category;
use App\Item;
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
        return view("stock",["left_title"=>"Orders",'data'=>  $data,"include"=>"tableConsignment",'warehouse'=>$w]);
    }
    public function stockCenter(){
        return "stockCenter";
    }
    public function stockWarehouses($author = null){
        if(Warehouse::where("id",$author)->exists() ==false ){
            if($author != 0)
            return back()->with(["message"=>"undefined action"]);
        }
        if($author != 0) :
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
        $wareName = Warehouse::where("id",$author)->pluck("centerName")->first();
        return view("stock",["left_title"=>"warehouse",'data'=>  $data,"include"=>"tableAvailble",'warehouse'=>$w,"wareName"=>$wareName]);
    }
    public function wks($author = null){
        if(Warehouse::where("id",$author)->exists() ==false ){
            if($author != 0)
            return back()->with(["message"=>"undefined action"]);
        }
        if($author != 0) :
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
        $wareName = Warehouse::where("id",$author)->pluck("centerName")->first();
        return view("stock",["left_title"=>"warehouse",'data'=>  $data,"include"=>"tableAvailble",'warehouse'=>$w,"wareName"=>$wareName]);
    }
    public function wksLevel($author = null){
        if(Warehouse::where("id",$author)->exists() ==false ){
            if($author != 0)
            return back()->with(["message"=>"undefined action"]);
        }
        $wks = Category::where('category',"wks")->pluck('id');
       $parent = $wks[0];
       $cat = Category::where('parent',$parent)->get()->toArray();
        foreach($cat as $cats){
            $sCat = Category::where('parent',$cats['id'])->get()->toArray();
            foreach ($sCat as $level){
              $iLevel[] = $cats['category']." wks ".$level["category"];
            }
        }
        foreach($iLevel as $lv):
            if (Input::has('search'))
            {
                $lv = trim(Input::get('search'));
            }
        if($author != 0) :
            
                 $data[$lv] = Stoks::where(["warehouse"=>$author,'category'=>1])->with("Item")->whereHas('Items', function($q) use ($lv){
                $q->where('item','like', $lv.'%');})->sum('count');
            
        else:
            $data[$lv] = Stoks::where(['category'=>1])->with("Item")->whereHas('Items', function($q) use ($lv){
                $q->where('item','like', $lv.'%');})->sum('count');
            
        endif;
        endforeach;
         $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $perPage = 10;
        $currentPageSearchResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        $units= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        $w = Warehouse::all();
        $wareName = Warehouse::where("id",$author)->pluck("centerName")->first();//dd($wareName);
        return view("stock",["left_title"=>"warehouse",'data'=>  $units,"include"=>"tableLevelStock",'warehouse'=>$w,"wareName"=>$wareName]);
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
