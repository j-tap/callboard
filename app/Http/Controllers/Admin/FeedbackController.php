<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\FeedbackUpdateRequest;
use App\Models\Feedback;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{

    use ApiControllerTrait;

    public function reports(Request $request)
    {
        return Feedback::filtredData($request, ['id', 'theme', 'created_at', 'status', 'owner_id', 'moder_id', 'news_id', 'org_id', 'message_id', 'deal_id'])
            ->with('moder', 'owner', 'news', 'organization')
            ->report()
            ->paginate($request->input('per_page', 10));
    }

    public function messages(Request $request)
    {
        return Feedback::filtredData($request, ['id', 'theme', 'created_at', 'status', 'owner_id', 'moder_id', 'news_id', 'org_id', 'message_id', 'deal_id'])
            ->with('moder', 'owner', 'news', 'organization')
            ->feed()
            ->paginate($request->input('per_page', 10));
    }

    public function feedcount()
    {
        return [
            'feed' => Feedback::feed()->where('status', 'opened')->count(),
            'report' => Feedback::report()->where('status', 'opened')->count()
        ];
    }

    public function show($id)
    {
        return Feedback::with([
            'owner',
            'deal',
            'news',
            'message.user.organization',
            'organization',
            'moder'
        ])->find($id);
    }

    public function update(FeedbackUpdateRequest $request, $id)
    {
        $feed = Feedback::findOrFail($id);

        $feed->update(
            collect($request->all())
            ->only(collect($request->rules())
            ->keys())
            ->toArray()
        );

        return $this->successResponse();
    }

    public function delete(Request $request, $id)
    {
        if ($feed = Feedback::findOrFail($id))
            $feed->delete();

        return $this->successResponse();
    }


}
