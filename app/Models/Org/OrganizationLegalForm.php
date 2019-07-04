<?php

namespace App\Models\Org;

use Illuminate\Database\Eloquent\Model;

class OrganizationLegalForm extends Model
{
    protected $table = 'organizations_legal_forms';
    protected $fillable = ['name', 'short_name'];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizations()
    {
        return $this->hasMany(\App\Models\Org\Organization::class, null, 'org_legal_form_id');
    }

}
