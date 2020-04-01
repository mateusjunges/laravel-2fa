<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Laravel2faFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = config("laravel-2fa.tables.users", "users");

        Schema::table($users, function(Blueprint $table) {
            $table->string('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $users = config("laravel-2fa.tables.users", "users");

        Schema::table($users, function(Blueprint $table) {
            $table->dropColumn('two_factor_code');
            $table->dropColumn('two_factor_expires_at');
        });
    }
}
