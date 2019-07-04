<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Http\Requests\Client\Api\v1\ReportRequest;
use App\Models\Feedback;
use App\Notifications\OrganizationReport;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class FeedbackController extends Controller
{

    use ApiControllerTrait;

    public function send(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            $this->validate($request, [
                'email' => 'required|email',
                'description' => 'required|min:6|max:2048',
            ]);

            Feedback::create([
                'theme' => $request->email,
                'description' => $request->description
            ]);

        } else {
            $this->validate($request, [
                'theme' => 'required|min:6|max:255',
                'description' => 'required|min:6|max:2048',
            ]);

            $user->userfeed()->create($request->all(['theme', 'description']));
        }

        return $this->successResponse();
    }

    public function report(ReportRequest $request)
    {
        $user = Auth::guard('api')->user();
        $feed = $user->userfeed()->create($request->all([
            'theme',
            'description',
            'org_id',
            'news_id',
            'deal_id',
            'message_id',
        ]));
        $feed->report = 1;
        $feed->save();

        $user->organization->notify(new OrganizationReport($feed));

        return $this->successResponse();
    }

}
