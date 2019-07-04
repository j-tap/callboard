<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LegalFormRequest;
use App\Models\Org\OrganizationLegalForm;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LegalFormsController extends Controller
{
    use ApiControllerTrait;

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        return OrganizationLegalForm::all(['id', 'name', 'short_name'])->toArray();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(LegalFormRequest $request)
    {
        return OrganizationLegalForm::create($request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return OrganizationLegalForm::findOrFail($id, ['id', 'name', 'short_name']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(LegalFormRequest $request, $id)
    {
        $question = OrganizationLegalForm::findOrFail($id, ['id', 'name', 'short_name']);
        $question->update($request->all());

        return $question;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        OrganizationLegalForm::findOrFail($id)->delete();
        return $this->successResponse();
    }
}
