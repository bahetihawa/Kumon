<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class CenterController extends Controller
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
    
    public function index(){
        return view("center");
    }
}
