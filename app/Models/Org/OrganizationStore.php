<?php

namespace App\Models\Org;

use Illuminate\Database\Eloquent\Model;

class OrganizationStore extends Model
{
    protected $table = 'organizations_stores';
    protected $fillable = ['address', 'geo_lat', 'geo_lon'];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class);
    }

}
