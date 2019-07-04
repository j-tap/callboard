<?php

namespace App\Http\Controllers\Admin;

use App\Models\Org\Organization;
use App\Models\Org\OrganizationDeal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Larinfo;
use DB;

class AdminController extends Controller
{
    /**
     * SPA view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.layouts.spa');
    }

    /**
     * System info api
     *
     * @return mixed
     */
    public function systemInfo()
    {
        return Larinfo::getInfo();
    }

    public function statistic()
    {
        return [
            'deals' => [
                'all' => OrganizationDeal::count(),
                'finish' => OrganizationDeal::where('finish', 1)->count(),
                'min_budget' => OrganizationDeal::min('budget_from'),
                'max_budget' => OrganizationDeal::max('budget_to'),
                'middle_budget'=> (OrganizationDeal::avg('budget_from') + OrganizationDeal::avg('budget_to')) / 2,
                'members' => DB::table('organizations_deals_members')->count(),
            ],
            'fast_deals' => [
                'all' => OrganizationDeal::where('fast_deal', 1)->count(),
                'finish' => OrganizationDeal::where('fast_deal', 1)->where('finish', 1)->count(),
                'min_budget' => OrganizationDeal::where('fast_deal', 1)->min('budget_from'),
                'max_budget' => OrganizationDeal::where('fast_deal', 1)->max('budget_to'),
                'middle_budget'=> (OrganizationDeal::where('fast_deal', 1)->avg('budget_from') + OrganizationDeal::where('fast_deal', 1)->avg('budget_to')) / 2,
                'members' => DB::table('organizations_deals_members')->count(),
            ],
            'user' => [
                'all' => Organization::count(),
                'sellers' => Organization::where('org_type', Organization::ORG_TYPE_SELLER)->count(),
                'buyers' => Organization::where('org_type', Organization::ORG_TYPE_BUYER)->count(),
            ],
            'pro' => [
                'buys' => '-',
                'ad_rubric' => '-',
                'ad_platform' => '-',
                'ad_stocks' => '-',
                'ad_map' => '-',
                'ad_fast' => '-',
                'ad_member' => '-',
                'ad_news' => '-',
            ]
        ];
    }
}
