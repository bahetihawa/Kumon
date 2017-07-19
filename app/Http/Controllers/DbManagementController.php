<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Input;
use File;
class DbManagementController extends Controller
{
            

    public function __construct()
    {
       $this->middleware(function($request,$next){
            if(Auth::user() && Auth::user()->role !=1){
                Auth::logout();
                    return redirect()->to('/home');
            }else{
                 return $next($request);
            }
        });
    }

    private function loadDatabase(){
    		 $this->host 		=		env('DB_HOST', 'localhost');
             $this->database 	=		env('DB_DATABASE', 'forge');
             $this->username 	=		env('DB_USERNAME', 'forge');
             $this->password 	=		env('DB_PASSWORD', '');
    }


    public function backup(){
    		$this->loadDatabase();
    		$name 		=		'data_backup/'.date("Y_m_d_H_i_s").'.sql';	
        	system('mysqldump --user='.$this->username.' --password='. $this->password .' --host='.$this->host.' '. $this->database.' > '.$name,$output);
        	return redirect()->back()->with('message', 'Database Backed Up');
    }

    public function restore(Request $request){
    	if ($request->isMethod('post')) {

    		$restorePoint 	=	Input::get('restorePoint');
    		$restoreTime	=	File::lastModified($restorePoint);
    		$uploads = File::allFiles('uploads');
    		foreach ($uploads as $upload)
			{
			  $time = File::lastModified($upload->getPathName());
			  if($time >= $restoreTime ){
			  	File::delete($upload);
			  }
			}

    		$this->loadDatabase();
    		
    		if(file_exists($restorePoint)){
    			system('mysql --user='.$this->username.' --password='. $this->password .' --host='.$this->host.' '. $this->database.' < '.$restorePoint,$output);
    			$message = 'Backup Restored Successfully !';
    		}else{
    			$message = 'No Backup Found !';
    		}
    		return redirect()->back()->with('message', $message);
		}

		$files = File::allFiles('data_backup');
		foreach ($files as $file)
		{
		$file_info = pathinfo($file);
		  $data[$file->getPathName()]=$file_info['filename'];
		 arsort($data);
		}
    		return view('restore',['restorePoints'=>$data]);
    }
}
