<?php

use App\LicenseOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateLicenseOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('license_options')->insert(
            array(
                'name' => 'Prefeitura Municipal'
            )
        );
        DB::table('license_options')->insert(
            array(
                'name' => 'Corpo de Bombeiros'
            )
        );
        DB::table('license_options')->insert(
            array(
                'name' => 'Vigilancia Sanitária'
            )
        );
        DB::table('license_options')->insert(
            array(
                'name' => 'Concessionária Elétrica'
            )
        );
        DB::table('license_options')->insert(
            array(
                'name' => 'Licença Ambiental'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('license_options')->delete();
    }
}
