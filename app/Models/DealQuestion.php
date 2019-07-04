<?php

namespace App\Models;

use App\Traits\DataTable;
use Illuminate\Database\Eloquent\Model;

class DealQuestion extends Model
{
    use DataTable;

    protected $table = 'deals_questions';
    protected $fillable = ['name', 'question'];
    static protected $sortable = ['id', 'name'];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deals()
    {
        return $this->belongsToMany(\App\Models\Org\OrganizationDeal::class, 'organizations_deals_questions', 'deal_id', 'question_id');
    }
}
