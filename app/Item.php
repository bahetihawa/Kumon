<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
     protected $fillable = [
		'code','item','level','category','sub-cat','s-sub-cat',"quantity"
    ];
     
    protected $hidden = [
	//
    ];
    public  function category(){
        return $this->belongsTo('App\Category','category');
    }
}
