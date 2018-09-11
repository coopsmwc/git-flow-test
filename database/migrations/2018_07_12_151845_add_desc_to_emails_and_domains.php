<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescToEmailsAndDomains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_domains', function (Blueprint $table) {
            $table->text('description')->after('domain')->nullable();
        });
        Schema::table('company_emails', function (Blueprint $table) {
            $table->text('description')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_domains', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        
        Schema::table('company_emails', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
