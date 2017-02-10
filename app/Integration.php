<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class integration extends Model
{
    protected $fillable = [
		'warehouse','center',
    ];
	
    protected $hidden = [
	'remember_token',
    ];
    
    public function center(){
        return $this->belongsTo("App\Center","center");
    }
    public function warehouse(){
        return $this->belongsTo("App\Warehouse","warehouse");
    }
}
