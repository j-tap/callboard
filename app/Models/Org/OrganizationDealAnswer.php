<?php

namespace App\Models\Org;

use Illuminate\Database\Eloquent\Model;

class OrganizationDealAnswer extends Model
{
    protected $table = 'organizations_deals_answers';
    protected $fillable = ['answer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class, 'organization_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(\App\Models\DealQuestion::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deal()
    {
        return $this->belongsTo(\App\Models\Org\OrganizationDeal::class, 'deal_id');
    }
}
