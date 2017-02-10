<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class category extends Model
{
    use Notifiable;
	
    /**
     * The attributes that are mass assignable.
		*
     * @var array
     */
    protected $fillable = [
		'category','parent',
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
