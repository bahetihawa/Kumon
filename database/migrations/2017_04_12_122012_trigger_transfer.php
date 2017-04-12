<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggerTransfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER trigger_transfer AFTER INSERT ON `transfers` FOR EACH ROW

                BEGIN

                   
                    UPDATE `stoks` SET `count` = (`count`-NEW.quantity) WHERE `specify` = NEW.item AND `warehouse` = NEW.warehouse;

                END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
                DB::unprepared('DROP TRIGGER `trigger_transfer`');

    }
}
