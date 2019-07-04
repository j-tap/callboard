<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreDocs extends Model
{
    protected $table = 'score_docs';

    protected $fillable = [
        'owner_id', 'organization_id', 'unique_id', 'number_score', 'dt_score', 'summ', 'user_id', 'status'
    ];
}
