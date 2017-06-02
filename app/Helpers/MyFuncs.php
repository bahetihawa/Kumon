<?php

namespace App\Helpers;

use App\User;
class MyFuncs {

    public static function getWarehouseAuthById($id) {
        $user =  User::pluck('id',"frenchise")->toArray();
        return $user[$id];
    }
}