<?php

namespace App\Models\Org;

use Illuminate\Database\Eloquent\Model;

class OrganizationRate extends Model
{
    protected $table = 'organizations_rating';
    protected $fillable = ['comment', 'rate', 'sender_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class, 'sender_id');
    }
}
