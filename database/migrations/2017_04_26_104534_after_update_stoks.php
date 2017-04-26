<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AfterUpdateStoks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::unprepared('CREATE TRIGGER after_update_stoks AFTER INSERT ON `stoks` FOR EACH ROW

                BEGIN              
                    INSERT INTO `stoksLog` (`category`, `unit_price`, `specify`, `count`, `warehouse`, `created_at`, `updated_at`) 
                    VALUES (NEW.`category`, NEW.`unit_price`, NEW.`specify`, NEW.`count`, NEW.`warehouse`, NEW.`updated_at`, NEW.`updated_at`);
                END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::unprepared('DROP TRIGGER `after_update_stoks`');
    }
}
