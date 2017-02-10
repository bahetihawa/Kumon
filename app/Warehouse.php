<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Warehouse extends Model
{
    use Notifiable;
	
    /**
     * The attributes that are mass assignable.
		*
     * @var array
     */
    protected $fillable = [
		'centerName','centerCode','concern','address','country','province','district','email','phone',
    ];
	
    /**
     * The attributes that should be hidden for arrays.
		*
     * @var array
     */
    protected $hidden = [
	'remember_token',
    ];
    
    public function district(){
        return $this->belongsTo("App\District","district");
    }
    public function country(){
        return $this->belongsTo("App\Country","country");
    }
    public function integration(){
        return $this->hasMany("integration");
    }
}
