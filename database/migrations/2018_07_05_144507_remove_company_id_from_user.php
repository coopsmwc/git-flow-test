<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveCompanyIdFromUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('employee_register_login');
            $table->dropColumn('licence_active_date');
        });
        
        DB::statement('ALTER TABLE companies CHANGE employee_register_password employee_register_passkey VARCHAR(255)');
        
        Schema::table('company_admins', function (Blueprint $table) {
            $table->dropColumn('last_name');
        });
        
        DB::statement('ALTER TABLE company_admins CHANGE first_name name VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('company_id')->after('email')->nullable();
        });
        
        Schema::table('companies', function (Blueprint $table) {
            $table->string('employee_register_login')->after('licence_end_date')->nullable();
            $table->timestamp('licence_active_date')->after('licence_end_date')->nullable();
        });
        
        DB::statement('ALTER TABLE companies CHANGE employee_register_passkey employee_register_password VARCHAR(255)');
        
        Schema::table('company_admins', function (Blueprint $table) {
            $table->string('last_name')->after('name')->nullable();
        });
        
        DB::statement('ALTER TABLE company_admins CHANGE name first_name VARCHAR(255)');
    }
}
