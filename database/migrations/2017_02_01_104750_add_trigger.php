<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
               DB::unprepared('CREATE TRIGGER item_update AFTER INSERT ON `consignments` FOR EACH ROW

                BEGIN

                    UPDATE `stoks` SET `unit_price` = (NEW.ammount_inr+unit_price*`count`)/(count+NEW.quantity),`count` = `count`+NEW.quantity WHERE `specify` = NEW.item AND `warehouse` = NEW.warehouse;

                END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::unprepared('DROP TRIGGER `item_update`');
    }
}
