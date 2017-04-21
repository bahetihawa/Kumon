<?php

namespace App\Http\Controllers;
use App\Country;
use App\Province;
use App\District;
use App\Center;
use App\Warehouse;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
class SetupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(function($request,$next){
            if(Auth::user() && Auth::user()->role !=1){
                Auth::logout();
                    return redirect()->to('/');
            }else{
                 return $next($request);
            }
        });
    }
	
	protected function validator(Request $request)
    {
        return Validator::make($request, [
		'country' => 'required|max:255',
                'phone' => 'required|max:12',
        ]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 	$country = Country::all();
        return view('location',["country"=>$country]);
    }
	
    protected function create(Request $request)
    {
		if($request['model'] == "Country"):
			Country::create([
			'country' => $request['country'],
			]);
		elseif($request['model'] == "Province"):
			Province::create([
			'province' => $request['country'],
			'country_code'=> $request['country_code'],
			]);
		elseif($request['model'] == "District"):
			District::create([
			'district' => $request['country'],
			'province_code'=> $request['province_code'],
			]);
		endif;
		return redirect()->route('location');
    }
	public function states(Request $request)
    { 	
		if($request['mod'] == "Province")
		$location = Province::where('country_code',$request['data'])->get();
		if($request['mod'] == "District")
		$location = District::where('province_code',$request['data'])->get();
        return view('include.locationlist',["location"=>$location,'mod'=>$request['mod']]);
    }
	
	public function deleteEntry($model,$id)
    { 	
		if($model == "Country"):
			$entry = Country::where('id',$id)->first();
			$entry->delete();
			$entry1 = Province::where('country_code',$id);
			$entry1->delete();
                        return redirect()->route('location')->with(["message"=>'Deleted successfully']);
		elseif($model == "Province"):
			$entry = Province::where('id',$id)->first();
			$entry->delete();
			$entry1 = District::where('province_code',$id);
			$entry1->delete();
                        return redirect()->route('location')->with(["message"=>'Deleted successfully']);
		elseif($model == "District"):
			$entry1 = District::where('id',$id);
			$entry1->delete();
                        return redirect()->route('location')->with(["message"=>'Deleted successfully']);
		endif;
                if($model == "Centers"):
                        $entry1 = Center::where('id',$id);
			$entry1->delete();
                        return redirect()->route('center')->with(["message"=>'Deleted successfully']);
                endif;
                if($model == "Warehouses"):
                        $entry1 = Warehouse::where('id',$id);
			$entry1->delete();
                        return redirect()->route('warehouse')->with(["message"=>'Deleted successfully']);
                endif;
                if($model == "Users"):
                        $entry1 = User::where('id',$id);
			$entry1->delete();
                     return redirect()->to('users/accounts');
                endif;
    }
    public function centers()
    { 	$center = Center::with("District")->paginate(10);
        $country = Country::all();
        $province = Province::all();
        $dist = District::all();
        return view('centers',["center"=>  $center,"country"=>$country,"province"=>$province,"district"=>$dist,"left_title"=>"Centers"]);
    }
    
    public function Warehouse()
    { 	$center = Warehouse::with("District")->paginate(10);
        $country = Country::all();
        $province = Province::all();
        $dist = District::all();
        return view('centers',["center"=>  $center,"country"=>$country,"province"=>$province,"district"=>$dist,"left_title"=>"Warehouses"]);
    }
	
	public function getCenter(Request $request)
    { 	
		if($request->input('mod') == "Centers")
		$getCenter = Center::where('id',$request['data'])->first();
                if($request->input('mod') == "Warehouses")
		$getCenter = Warehouse::where('id',$request['data'])->first();
                if($request->input('mod') == "Users"){
                    $getCenter1 = $user = User::where("id",$request['data'])->first();
                    $getCenter["id"] =$getCenter1->id;
                    $getCenter["name"] =$getCenter1->name;
                    $getCenter["role"] = config('app.centerType.'.$getCenter1->role) ;
                    if($getCenter1->role == 2)
                    $getCenter["frenchise"] =$getCenter1->center->centerName;
                    if($getCenter1->role == 3)
                    $getCenter["frenchise"] =$getCenter1->warehouse->centerName;
                }
		echo json_encode($getCenter);
    }
	public function addForm(Request $request)
    { 	 $data = $request->input();$mode = $data["model"];
		unset($data["_token"]);unset($data["submit"]);unset($data["model"]);
                //Center::where('id', $request->input('id'))->update($data);
                if($mode =="Centers")  :
                    $feature = new Center();
                elseif($mode =="Warehouses"): 
                     $feature = new Warehouse();
                endif;
                $feature->unguard();
                $feature->fill($data);
                $feature->exists = $request->input('id');
                $feature->reguard();
                $feature->save();
		return (($mode =="Centers") ? redirect()->route('center'): redirect()->route('warehouse'));
    }
}
