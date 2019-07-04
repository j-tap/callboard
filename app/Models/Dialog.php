<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dialog extends Model
{
    use SoftDeletes;

    protected $table = 'dialogs';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class, 'seller_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class, 'buyer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class, 'dialog_id');
    }

    public function unreaded_messages($myUserId)
    {
        return $this->messages()->where("status", "=" , \App\Models\Message::MESSAGE_STATUS_UNREADED)->where("user_id", "<>", $myUserId)->get()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function last_message()
    {
        return $this->hasOne(\App\Models\Message::class, 'dialog_id')->orderBy('created_at', 'desc');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function deal()
    {
        return $this->hasOne(\App\Models\Org\OrganizationDeal::class, 'id', 'deal_id');
    }
}
