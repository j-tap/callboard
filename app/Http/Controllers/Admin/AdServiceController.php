<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdService;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdServiceController extends Controller
{

    use ApiControllerTrait;

    /**
     * Show all services
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function services()
    {
        $items = AdService::all(['id', 'parent_id', 'name', 'slug', 'days', 'cost']);
        $aditems = [];

        foreach ($items as $ad) {
            $itm = $ad->toArray();

            if (!$itm['parent_id']) {
                foreach ($items as $sad) {
                    if ($sad['parent_id'] == $itm['id'])
                        $itm['items'][] = $sad;
                }

                $aditems[] = $itm;
            }
        }

        return $aditems;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4|max:32',
            'days' => 'required',
            'cost' => 'required',
        ]);
        // Wtf? Who is writing technical documents???? Are u crazy?
        $ad = new AdService();
        $ad->name = $request->get('name');
        $ad->slug = time();
        $ad->days = $request->get('days');
        $ad->cost = $request->get('cost');
        $ad->parent_id = $request->get('parent_id', 0);

        $ad->save();

        return $this->successResponse();
    }

    /**
     * Update service
     *
     * @param Request $request
     * @param AdService $service
     */
    public function update(Request $request, AdService $service)
    {
        $this->validate($request, [
            'days' => 'required|integer',
            'cost' => 'required|integer',
        ]);

        $service->update($request->all(['cost', 'days']));
    }

}
