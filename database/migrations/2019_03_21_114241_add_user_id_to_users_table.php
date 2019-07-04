<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\Admin\UsersController;   
use \App\Models\User;


class AddUserIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('unique_id')->after('password')->index();
        });
      //  DB::update('ALTER table `users` modify `unique_id` INTEGER(11) UNIQUE NOT NULL');
      $users = User::all();
      if($users){
        foreach($users as $user){
            $user->unique_id = UsersController::generateUniqueUserIdNumber();
            $user->save();
        }
        
      }

     //   DB::update('UPDATE `users` SET `unique_id` = ' . UsersController::generateUniqueUserIdNumber());
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('unique_id');
        });
    }
}
