<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['message', 'user_id', 'dialog_id'];
    static protected $sortable = ['id', 'user_id', 'dialog_id', 'status', 'created_at'];

    const MESSAGE_STATUS_READED       = 'readed'; // сообщение прочитано
    const MESSAGE_STATUS_UNREADED     = 'unreaded'; // сообщение не прочитано

    const MESSAGE_TYPE_MESSAGE      = 'message'; // тип сообщения - обычное сообщение
    const MESSAGE_TYPE_RESPONCE     = 'responce'; // тип сообщения - отклик

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dialog()
    {
        return $this->belongsTo(\App\Models\Dialog::class, 'dialog_id');
    }

    public function markAsReaded()
    {
        $this->status = self::MESSAGE_STATUS_READED;
        $this->save();
    }

      // public function unreaded_messages()
    // {
    //     return $this->hasMany(\App\Models\Message::class, 'dialog_id')->where("status", "=" , \App\Models\Message::MESSAGE_STATUS_UNREADED);
    // }
}
