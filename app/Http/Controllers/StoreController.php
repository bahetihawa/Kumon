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
use App\StoksLog;
use App\Consignment;
use App\Integration;
use App\user;
use App\Http\Controllers\UtilityController;

class StoreController extends Controller
{
    private $stkLogId = array();
     private $css = array();
     private $totVal =0; 
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    public function index(){
        extract(Input::all());
        $period = $year."-".str_pad($month,2,0,STR_PAD_LEFT)."-".cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $period .= " 23:59:59";
        $this->period = $period;
       $data = array();
        $fileName = 'opening_report_'.$month.'_'.$year;
        $filenameE = 'opening_report_'.$month.'_'.$year.'.xlsx';
        $filePathName = 'exports/'. $filenameE;

        
        
        //if(!file_exists($filePathName)){
            $this->gererateReport($fileName);
       // }
        Excel::load($filePathName)->export('xlsx');
        return redirect()->back()->with(["message"=>'Success.']);
    }

    
    protected function gererateReport($fileName){
        $wh = User::where('role',3)->pluck('id')->toArray();//dd($wh);
       foreach ($wh as $key => $value) {
           $data[$value] = $this->opening($value);
       }
       
      // dd($data);
        Excel::create($fileName, function($excel) use ($data) {

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
                    $sheet->setFreeze('D7');
                    $sheet->loadView('stackDown',['wdata'=>$wdata,'cent'=>$cent,'header'=>$headings,'ware'=>$were,'css'=>$css]);

                });
            }

        })->save('xlsx','exports');
    }
    
    public function opening($auth){
        $author = $auth;
        $this->stkLogId = array();
        $this->css = array();
        $this->totVal =0;
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
       // $whData = Stoks::where(["warehouse"=>$author,'category'=>1])->with("items")->get()->toArray();
        $whData = $this->stkLogData($author,1);
        $wdata = $this->exlFarmate($whData,$cent,0);
        
        $wdata0 = $this->commulativeStack($author,$cent);
        $d1 = array_merge($wdata0,$wdata);

        ksort($d1);
        
        $whData1 = $this->stkLogData($author,0);
        $wdata1 = $this->exlFarmate($whData1,$cent,1);
        
        //dd($wdata1);
        $da = array_merge($wdata1,$d1);
        $daa = $this->finalStack($author,$cent);
        $wdata =  array_merge($da,$daa);
       
            return ['wdata'=>$wdata,'cent'=>$cent,'headings'=>$headings,'were'=>$were,'css'=>$this->css];
    }

    private function stkLogData($author,$wksTrue){
        //$this->stkLogId = array();
        if($wksTrue == 0):
            $itemsWks = Item::where('category','!=',1)->pluck('id')->toArray();
        else:
             $itemsWks = Item::where('category',1)->pluck('id')->toArray();
        endif;
        foreach($itemsWks as $its):
        $data = StoksLog::where(["warehouse"=>$author,'specify'=>$its])
                                                                    ->where('created_at','<',$this->period)
                                                                     ->orderBy('id','desc')
                                                                     ->limit(1)
                                                                    ->with("items")
                                                                   ->get()->toArray();
                 if(!empty($data)) {
                     $whData[] =  $data[0];
                     
                    $this->stkLogId[]= $data[0]['id'];
                    
                 }
        endforeach;
        //$this->stkLogId = $stkLogId;
        return $whData;
    }

    private function exlFarmate($whData,$cent,$css){
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
            if($css !=0){
                $this->css[] = $k;
            }
        }
        return $wdata;
    }
    private function commulativeStack($author,$cent){
        $totVal = 0;$stkId = $this->stkLogId;//dd($stkId);
        $iLevel = (new UtilityController)->level_get();
        foreach ($iLevel as $key => $lv) {
            $lvs = explode(" ", $lv);
            $data = StoksLog::where(["warehouse"=>$author,'category'=>1])
                        ->where('created_at','<',$this->period)
                        ->whereIn('id',$stkId)
                        ->with("Items")->whereHas('Items', function($q) use ($lvs,$lv){
                                $q->where('item','like', '%'.$lvs[0].'%')
                                    ->where('item','like', '%'.$lvs[1]." ".$lvs[2].'%')
                                    ->where('item','like', '%'.$lvs[2].'%');})
                        ->sum('count');

           $wdata[$lv."000"] = ['code'=>$lv."000",'item'=>$lv,"qt"=>$data];

           $prc = StoksLog::where(["warehouse"=>$author,'category'=>1])
                            ->where('created_at','<',$this->period)->where('unit_price','!=',0)
                            ->orderBy('id','desc')
                            ->limit(1)
                            ->with("Items")->whereHas('Items', function($q) use ($lvs,$lv){
                                $q->where('item','like', '%'.$lvs[0].'%')
                                    ->where('item','like', '%'.$lvs[1]." ".$lvs[2].'%')
                                    ->where('item','like', '%'.$lvs[2].'%');})
                ->first()->unit_price;
           $this->totCent = 0;
           foreach ($cent as $key1 => $value1) {

                $data1 = Render::where(["warehouse"=>$author,'target'=>$key1])
                                ->where('created_at','<',$this->period)
                                ->with("Items")->whereHas('Items', function($q) use ($lv,$lvs){
                                    $q->where('item','like', '%'.$lvs[0].'%')
                                        ->where('item','like', '%'.$lvs[1]." ".$lvs[2].'%')
                                        ->where('item','like', '%'.$lvs[2].'%')
                                        ->where('items.category',1);});
             $qt = $data1->sum('quantity');
                //$data = $qt;

                $data2 = Transfer::where(["warehouseTo"=>$author,'target'=>$key1])
                                ->where('created_at','<',$this->period)
                                ->with("Items")->whereHas('Items', function($q2) use ($lv,$lvs){
                                    $q2->where('item','like', '%'.$lvs[0].'%')
                                        ->where('item','like', '%'.$lvs[1]." ".$lvs[2].'%')
                                        ->where('item','like', '%'.$lvs[2].'%')
                                        ->where('items.category',1);});
                $qt2 = $data2->sum('quantity');
               // $data_tr = $qt2;
                $qtx = $qt+$qt2;
                 $wdata[$lv."000"][$value1] = $qtx;
                $this->totCent = $this->totCent+$qtx;
                 $totVal +=$qtx*$prc;
            }
            $wdata[$lv."000"]['tot_cent'] =$this->totCent;
            $wdata[$lv."000"]['tot_wh'] = $this->totCent+$data;
            $wdata[$lv."000"]['wac'] = $prc;
            $wdata[$lv."000"]['val_cent'] = $prc*$this->totCent;
            $wdata[$lv."000"]['stack_val'] = ($this->totCent+$data)*$prc;
            $this->css[] = $lv."000";
        }
        $this->totVal = $this->totVal+$totVal;
        return $wdata;
    }
    private function finalStack($author,$cent){
        $sumWh = StoksLog::where("warehouse",$author)
                        ->where('created_at','<',$this->period)
                        ->whereIn('id',$this->stkLogId)
                        ->sum('count');//dd($sumWh);
         $sumWhPrc = StoksLog::where("warehouse",$author)->whereIn('id',$this->stkLogId)->selectRaw('SUM(count * unit_price) as total')->pluck('total')->toArray()[0];
        $sumR = Render::where("warehouse",$author) ->where('created_at','<',$this->period)->with("Items")->whereHas('Items', function($q2){
                $q2->where('category',1);})->sum('quantity');
        $sumT = Transfer::where("warehouseTo",$author) ->where('created_at','<',$this->period)->with("Items")->whereHas('Items', function($q21) {
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
            $wdata[$k]['val_cent'] = $this->totVal;
            $wdata[$k]['stack_val'] = $sumWhPrc+$this->totVal;
            $this->css[] = $k;

            return $wdata;
    }
}
