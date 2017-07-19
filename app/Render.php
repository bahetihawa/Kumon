<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Render extends Model
{
     use Notifiable;
     
     protected $fillable = [
        'item','quantity','target','targetType' ,'warehouse','created_at','updated_at','filename'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
    public function items(){
        return $this->belongsTo("App\Item","item");
    }
}
