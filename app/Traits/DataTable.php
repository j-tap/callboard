<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait DataTable
{

    public static function filtredData(Request $request, array $select = [])
    {
        if (!empty($select)) {
            $query = self::select($select);
        } else {
            $query = self::select();
        }

        if (!$request->get('sort_key')) {
            $request->merge([
                'sort_key' => 'created_at',
                'sort_order' => 'desc'
            ]);
        }

        if (isset($request->sort_key) && in_array($request->sort_key, static::$sortable)) {
            $query->orderBy($request->sort_key, $request->input('sort_order', 'asc'));
        }

        if (isset($request->search_string) && isset($request->search_id) && in_array($request->search_id, static::$sortable)) {
            $query->orWhere($request->search_id, 'like', '%' . $request->search_string . '%');
        }

        return $query;
    }

}