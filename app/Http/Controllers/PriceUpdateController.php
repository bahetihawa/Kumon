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
use Illuminate\Pagination\LengthAwarePaginator;//Paginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
class PriceUpdateController extends Controller
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
    
    public function newPrice(){
        $wks = Category::where('category',"wks")->pluck('id');
       $parent = $wks[0];
       $cat = Category::where('parent',$parent)->get()->toArray();
      foreach($cat as $cats){
          $sCat = Category::where('parent',$cats['id'])->get()->toArray();
          foreach ($sCat as $level){
            $iLevel[] = $cats['category']." wks ".$level["category"];
          }
      }
    }
}