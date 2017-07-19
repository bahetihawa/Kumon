<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggerRender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER trigger_render AFTER INSERT ON `renders` FOR EACH ROW

                BEGIN

                   
                    UPDATE `stoks` SET `count` = (`count`-NEW.quantity) WHERE `specify` = NEW.item AND `warehouse` = NEW.warehouse AND `category` != 1;

                END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `trigger_render`');
    }
}
