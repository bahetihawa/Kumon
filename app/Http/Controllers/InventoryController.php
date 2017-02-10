<?php

namespace App\Http\Controllers;
use Input;
use Illuminate\Http\Request;
use Auth;
use App\Stoks;
use App\Warehouse;
use DB;
use App\Orders;
use App\Item;
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
                $q->where('code','like', '%'.$cnd.'%' )->orWhere('item','like', '%'.$cnd.'%');})->paginate(10);
            }else{
                $data = Stoks::where("warehouse",$author)->paginate(10);
            }
        else:
            if (Input::has('search'))
            {
                $cnd = trim(Input::get('search'));
                $data = DB::table('items')
                    ->rightJoin('stoks','items.id','=','stoks.specify')
                    ->select(DB::raw('items.item'),DB::raw('items.code'), DB::raw('sum(count) as count'))
                    ->where('code','like', '%'.$cnd.'%' )
                    ->orWhere('item','like', '%'.$cnd.'%')
                    ->groupBy(DB::raw('specify') )
                    ->paginate(10);
            }else{
                    $data = DB::table('items')
                    ->rightJoin('stoks','items.id','=','stoks.specify')
                    ->select(DB::raw('items.item'),DB::raw('items.code'), DB::raw('sum(count) as count'))
                    ->groupBy(DB::raw('specify') )
                    ->paginate(10);
            }
        endif;
        $w = Warehouse::all();
        return view("stock",["left_title"=>"warehouse",'data'=>  $data,"include"=>"tableAvailble",'warehouse'=>$w]);
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
