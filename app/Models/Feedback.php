<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTable;

class Feedback extends Model
{
    use DataTable;

    protected $fillable = ['theme', 'description', 'status', 'moder_id', 'deal_id', 'news_id', 'org_id', 'message_id'];
    static protected $sortable = ['id', 'report', 'theme', 'status', 'created_at', 'owner_id', 'moder_id'];

    const STATUS_OPENED = 'opened';
    const STATUS_PROGRESS = 'progress';
    const STATUS_CLOSED = 'closed';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moder()
    {
        return $this->belongsTo(\App\Models\User::class, 'moder_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function news()
    {
        return $this->belongsTo(\App\Models\News::class, 'news_id');
    }

    public function deal()
    {
        return $this->belongsTo(\App\Models\Org\OrganizationDeal::class, 'deal_id');
    }

    public function message()
    {
        return $this->belongsTo(\App\Models\Message::class, 'message_id');
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class, 'org_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeReport($query)
    {
        return $query->where('report', 1);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeFeed($query)
    {
        return $query->where('report', 0);
    }
}
