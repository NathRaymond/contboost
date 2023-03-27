<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use App\Models\Plan;
use App\Models\Tool;
use App\Models\Property;
use Illuminate\Http\Request;
use Butschster\Head\Facades\Meta;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function plans()
    {
        $plans = Plan::active()
            ->withTranslation()
            ->get();

        $meta = __("static_pages.plans");
        Meta::setMeta((object) $meta);

        return view('plans.list', compact('plans'));
    }
}
