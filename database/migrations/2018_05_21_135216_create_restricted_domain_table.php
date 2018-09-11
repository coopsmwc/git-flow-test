<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRestrictedDomainTable extends Migration
{
    
    public $restricted = ['gmail\..*', 'googlemail\..*', 'hotmail\..*', 'yahoo\..*', 'aol\..*', 'icloud\..*', 'gmx\..*', 'sharklasers\..*', 'guerillamail\..*', 
        'pokemail\..*', 'spam4\..*', 'mailinator\..*', 'nwytg\..*', '20email\..*'];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restricted_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain');
            $table->unsignedInteger('company_id')->nullable();
            $table->timestamps();
        });
        
        foreach ($this->restricted as $restricted) {
            DB::table('restricted_domains')->insert([
                'domain' => $restricted,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restricted_domain');
    }
}
