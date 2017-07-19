<?php

namespace App\Helpers;
use App\Warehouse;
use App\User;
class MyFuncs {

    public static function getWarehouseAuthById($id) {
        $user =  User::pluck('id',"frenchise")->toArray();
        return $user[$id];
    }
    public static function getWarehouseIdByAuth($id) {
        $user =  User::pluck('id',"frenchise")->toArray();
        return $user[$id];
    }
    public static function getWarehouseByAuth($id) {
        $user =  User::where('id',$id)->first()->frenchise;
        $wh = Warehouse::where('id',$user)->first()->centerName;
        return $wh;
    }
}