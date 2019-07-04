<?php

namespace App\Models\Org;

use Illuminate\Database\Eloquent\Model;

class OrganizationNotification extends Model
{
    protected $table = 'organizations_notifications';
    protected $guarded = ['id'];

    public function organization()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class, 'organization_id');
    }
}
