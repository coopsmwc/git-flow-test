<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLicenceStartEndDateToCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->timestamp('licence_start_date')->after('licences')->nullable();
            $table->timestamp('licence_end_date')->after('licence_start_date')->nullable();
            $table->string('employee_register_login')->after('licence_end_date')->nullable();
            $table->string('employee_register_password')->after('employee_register_login')->nullable();
            $table->enum('status', ['PENDING', 'ACTIVE', 'SUSPENDED', 'CANCELLED'])->default('PENDING');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('licence_start_date');
            $table->dropColumn('licence_end_date');
            $table->dropColumn('employee_register_login');
            $table->dropColumn('employee_register_password');
            $table->dropColumn('status');
        });
    }
}
