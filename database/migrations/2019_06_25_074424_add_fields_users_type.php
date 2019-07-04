<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class AddFieldsUsersType extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('hide_email')->after('is_org_created');
            $table->enum('account_is_created', [User::ACCOUNT_CREATED_USER, User::ACCOUNT_CREATED_AUTO])->default(User::ACCOUNT_CREATED_USER)->nullable()->after('hide_email');
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
            Schema::dropIfExists('hide_email');
        });
    }
}
