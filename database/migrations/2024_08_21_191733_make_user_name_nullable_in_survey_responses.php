<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->string('user_name')->nullable()->change();
            $table->integer('user_age')->nullable()->change();
            $table->string('user_sex')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->string('user_name')->nullable(false)->change();
            $table->integer('user_age')->nullable(false)->change();
            $table->string('user_sex')->nullable(false)->change();
        });
    }    
};
