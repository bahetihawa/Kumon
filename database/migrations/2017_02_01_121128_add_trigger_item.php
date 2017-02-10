<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class AddTriggerItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        DB::unprepared('CREATE TRIGGER stoks_update AFTER INSERT ON `items` FOR EACH ROW

                BEGIN

                   INSERT INTO `stoks`(`category`, `sub_cat`, `specify`, `count`, `warehouse`) 
                   VALUES (NEW.category,0,NEW.id,NEW.quantity,0);

                END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `stoks_update`');
    }
}
