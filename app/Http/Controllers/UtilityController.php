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
use Input;
use Excel;
use Illuminate\Support\Facades\Auth;
class UtilityController extends Controller
{
 
    public function __construct()
    {
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
        $data = Render::where("updated_at",$file)->with('Items')->get()->toArray();
        $ct =   Auth::id();
        $center = Warehouse::where("id",$ct)->get()->toArray()[0];
       // if()
        //echo date("d-m-y",strtotime($file));die;
        Excel::create($file, function($excel) use ($file,$data,$center) {

            // Set the title
            $excel->setTitle('GRN_'.$file);
            // Chain the setters
            $excel->setCreator('Roster')
                  ->setCompany('Kumon');
            // Call them separately
            $excel->setDescription('GRN of ');
            
            $excel->sheet($file, function($sheet) use ($file,$data,$center){

                $sheet->loadView('grn',["data"=>$data,'center'=>$center,'date'=>$file]);

            });

        })->export('xlsx');
    }
}