<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\User;

class UpdateStatusColInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM ('" . 
                        User::USER_STATUS_REGISTRED . "','" . 
                        User::USER_STATUS_APPROVE . "','" . 
                        User::USER_STATUS_ARCHIVE . "','" . 
                        User::USER_STATUS_BANNED . "') DEFAULT '" .User::USER_STATUS_REGISTRED . "';");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM ('" . 
            User::USER_STATUS_REGISTRED . "','" . 
            User::USER_STATUS_APPROVE . "','" . 
            User::USER_STATUS_ARCHIVE . "') DEFAULT '" .User::USER_STATUS_REGISTRED . "';");
        });
    }
}
