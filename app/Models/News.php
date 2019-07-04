<?php

namespace App\Models;

use App\Traits\DataTable;
use App\Traits\ModelFileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class News extends Model
{
    use DataTable;
    use ModelFileUpload;

    protected $hidden = ['pivot'];
    protected $fillable = ['title', 'description', 'status', 'stock', 'url'];
    static protected $sortable = ['id', 'status', 'user_id', 'created_at', 'title'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'news_categories', 'news_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedback()
    {
        return $this->hasMany(\App\Models\Feedback::class, 'news_id');
    }

    public function scopeStock($query)
    {
        return $query->where('stock', 1);
    }

    public function scopeNews($query)
    {
        return $query->where('stock', 0);
    }

    public function scopeApprove($query)
    {
        return $query->where('news.status', 'approve');
    }

    public function uploadImages(Request $request)
    {
        $this->image_1 = $this->uploadFile($request, 'image_1', 'news/' . $this->id, $this->image_1);
        $this->image_2 = $this->uploadFile($request, 'image_2', 'news/' . $this->id, $this->image_2);
        $this->image_3 = $this->uploadFile($request, 'image_3', 'news/' . $this->id, $this->image_3);

        $this->save();
    }

}
