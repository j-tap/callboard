<?php

namespace App\Models\Org;

use Illuminate\Database\Eloquent\Model;

class OrganizationOffice extends Model
{
    protected $table = 'organizations_offices';
    protected $fillable = ['address', 'phone', 'email', 'geo_lat', 'geo_lon'];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class);
    }
}
