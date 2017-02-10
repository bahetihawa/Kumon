<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class district extends Model
{
    use Notifiable;
	
    /**
     * The attributes that are mass assignable.
		*
     * @var array
     */
    protected $fillable = [
		'district','province_code',
    ];
	
    /**
     * The attributes that should be hidden for arrays.
		*
     * @var array
     */
    protected $hidden = [
	'remember_token',
    ];
    
    public function center(){
        return $this->hasMany("center");
    }
}
