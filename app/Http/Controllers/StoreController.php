<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
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
use App\Http\Controllers\UtilityController;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    public function index(){
        extract(Input::all());
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
        $iLevel = (new UtilityController)->level_get();
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
}
