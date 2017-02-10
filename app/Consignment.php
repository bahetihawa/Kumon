<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Consignment extends Model
{
        use Notifiable;

     protected $fillable = [
        'warehouse','item', "category",'freight',"quantity",'ammount_myr','exchange_rate', 'ammount_inr',"total",
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
