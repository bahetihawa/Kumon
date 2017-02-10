<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class province extends Model
{
    use Notifiable;
	
    /**
     * The attributes that are mass assignable.
		*
     * @var array
     */
    protected $fillable = [
	'province','country_code'
    ];
	
    /**
     * The attributes that should be hidden for arrays.
		*
     * @var array
     */
    protected $hidden = [
	'remember_token',
    ];
    
   
    
}
