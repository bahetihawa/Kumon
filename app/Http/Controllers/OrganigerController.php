<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Category;
use App\Item;
use DB;
use Input;
use Excel;
class OrganigerController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
        $this->middleware(function($request,$next){
            if(Auth::user() && Auth::user()->role !=1){
                Auth::logout();
                    return redirect()->to('/');
            }else{
                 return $next($request);
            }
        });
    }
    public function index()
    { 	$category = Category::where(["parent"=>0])->get();
            return view('category',["category"=>$category,"left_title"=>"Categories"]);
    }
    
    protected function create(Request $request)
    {
        $this->validate($request,[
            "category"=>"required",
        ]);
		if($request['model'] == "Category"):
                   // Category::create($request->input());
                    return redirect()->route('catagory')->with(["message"=>'Added successfully']);
                endif;
                if($request['model'] == "Items"):
                    $this->geetItemCategory($request->input('category'));
                    dd($request->input('category'));
                  //  Item::create($request->input());
                    return redirect()->route('organiger.Items')->with(["message"=>'Added successfully']);
                endif;
    }
    
    public function deleteEntry($model,$id)
    { 	
        $entry = DB::table($model)->where('id',$id);
	$entry->delete();
        return redirect()->back()->with(["message"=>'Deleted successfully']);
                
    }
    public function getvalue(Request $request)
    { 	
	if($request['mod'] == "catagory")
            $location = Category::where('parent',$request->input('data'))->get();
        return view('include.locationlist',["location"=>$location,'mod'=>$request['mod']]);
    }
    
    public function trees($pid = 0,$l = 0) {
	 $category = Category::where(['parent'=>$pid])->get();
            foreach($category as $xs){
		echo "<option value='".$xs->id."' id='i".$xs->id."'>";
		$i= $l;
		while($i > 0){
                    echo "|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;";
                    $i--;
		}
		echo "|-----".$xs->category."</option>";
		$l++;
		$pid = $xs->id;
		self::trees($pid,$l);
		$l--;
            }
	}
        public function tree($pid = 0,$l = 0) {
            echo "<option value='0' disabled>Root</option>";
            self::trees();
        }
    public function levels(){
        echo "hello";
    }
    
    public function items(Request $request){
        if (Input::has('search'))
        {
            $cnd = trim(Input::get('search'));
            $category = Item::where('code','like', '%'.$cnd.'%' )->orWhere('item','like', '%'.$cnd.'%')->paginate(10);
        }else{
           $category = Item::paginate(10);
        }
        
        $ct = Category::pluck("category","id")->toArray();
        $item = 0;
        if ($request->is('*/Items')) {
            $item = 1;
        }
            return view('items',["category"=>$category,"left_title"=>"Items","item" =>$item,"ct"=>$ct]);
    }

    public function addItemList(Request $request){
        $cat = ["CI"=>12,"NCI"=>4,'WKS'=>1,"Ci"=>12,"Nci"=>4,'Wks'=>1,"ci"=>12,"nci"=>4,'wks'=>1];
        if($request->isMethod('post')){
            
        
        if ($request->hasFile('file')) {
            $data = $this->upload($request);
         if($data == "error"){
            return redirect()->back()->with(["message"=>'Record Already Exists.']);
         }//dd($data);
         if(!empty($data)){
             foreach ($data as $key => $value) {
                if(is_numeric($value['sr_no'])){
                    Item::firstOrCreate(
                        ['code' => $value['item_code']], ['item' => $value['description'],'category'=>$cat[$value['cat']]]
                    );
                }
             }
         }
        }else{
            redirect()->back()->with(["message"=>'Record Already Exists or No File Selected.']);
        }
        }
        return view("addItemList");
    }
    public function upload($request){
        extract(Input::All());
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $destinationPath = 'uploads';
        if(file_exists($destinationPath."/".$fileName)){
            $err = "error";
            return $err;
        }else{
            $file->move($destinationPath,$fileName);
             $this->fileName = $destinationPath."/".$fileName;
            config(['excel.import.startRow' => $start]);
            $data = Excel::selectSheetsByIndex($sheet)->load($destinationPath."/".$fileName, function($reader) {
                  // $reader->noHeading();
               // foreach ($reader->toArray() as $row) {
                 //                           $bb[] = $row;
                   //                     }
            //echo '<pre>';print_r($bb );echo '</pre>';  die();
            })->toArray();
            unlink($destinationPath."/".$fileName);
         return $data;
        }
    }

    public function geetItemCategoryData($id = null,$category=[]){
        if($id > 0){
            if($cat = Category::find($id)){
                //array_push($category,$id);
                $category[] =$id;
                $this->geetItemCategoryData($cat->parent,$category);
            }
        }
        //echo count($category);
        return $category;die;
    }

    public function geetItemCategory($id = null){
        
        $cat = $this->geetItemCategoryData($id);
        echo count($cat);
    }
}
