<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
     protected $fillable = [
		'code','item','level','category','sub-cat','s-sub-cat',"quantity",'sub_cat','sSub_cat'
    ];
     
    protected $hidden = [
	//
    ];
    public  function category(){
        return $this->belongsTo('App\Category','category');
    }
}
