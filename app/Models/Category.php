<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'parent_id', 'cl_icon', 'cl_background'];
    public $timestamps = false;
    protected $hidden = ['pivot'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(\App\Models\Org\Organization::class, 'organizations_categories', 'category_id', 'organization_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function news()
    {
        return $this->belongsToMany(\App\Models\News::class, 'news_categories', 'category_id', 'news_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deals()
    {
        return $this->belongsToMany(\App\Models\Org\OrganizationDeals::class, 'organizations_deals_categories', 'deal_id', 'category_id');
    }

    public function children()
    {
        return $this->hasMany(\App\Models\Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Category::class, 'parent_id');
    }

}
