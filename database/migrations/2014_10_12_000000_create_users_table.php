<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->string('email')->unique();
            $table->string('password');

            $table->integer('organization_id')->nullable()->index();

            $table->enum('role', [User::ROLE_ADMINISTRATOR, User::ROLE_MODERATOR, User::ROLE_CLIENT, User::ROLE_CLIENT_WORKER])->default('client');
            $table->enum('status', [User::USER_STATUS_APPROVE, User::USER_STATUS_ARCHIVE, User::USER_STATUS_REGISTRED])->default(User::USER_STATUS_REGISTRED)->nullable()->index();
            $table->string('api_token', 60)->unique()->nullable()->default(null);
            $table->string('register_confirm_token', 60)->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
