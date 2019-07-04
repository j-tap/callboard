<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DealsQuestionsRequest;
use App\Models\DealQuestion;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DealsQuestionsController extends Controller
{

    use ApiControllerTrait;

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        return DealQuestion::filtredData($request, ['id', 'name', 'question'])
            ->paginate($request->input('per_page', 10));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(DealsQuestionsRequest $request)
    {
        return DealQuestion::create($request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return DealQuestion::findOrFail($id, ['id', 'name', 'question']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(DealsQuestionsRequest $request, $id)
    {
        $question = DealQuestion::findOrFail($id, ['id', 'name', 'question']);
        $question->update($request->all());

        return $question;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        DealQuestion::findOrFail($id)->delete();
        return $this->successResponse();
    }

}
