<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Message;

class AddTypeColToMessagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->enum('type', [Message::MESSAGE_TYPE_MESSAGE ,
                                  Message::MESSAGE_TYPE_RESPONCE])->after('status')->default(Message::MESSAGE_TYPE_MESSAGE)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            Schema::dropIfExists('type');
        });
    }
}
