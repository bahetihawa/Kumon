<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StoksLog extends Model
{
   use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "warehouse","category","sub_cat","specify","count","created_at","ipdated_at",
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
        return $this->belongsTo("App\Item","specify");
    }
}
