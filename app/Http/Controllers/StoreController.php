<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
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
    
    public function index(){
        echo 'hello';
    }
}
