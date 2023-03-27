<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\Usecase;
use App\Models\Language;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\Facads\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;

class PlansController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locales = Language::getLocales();
        $search = $request->get('q', false);

        $plans = Plan::withTranslation();
        if (!empty($search)) {
            $plans->search($search, null, true);
        }
        $plans = $plans->paginate();

        return view('plans.index', compact('locales', 'plans'));
    }

    public function create(Request $request)
    {
        $locales = Language::getLocales();
        $usecases = Usecase::active()->withTranslation()->get();

        return view('plans.create', compact('locales', 'usecases'));
    }

    public function store(PlanRequest $request)
    {
        $plan = Plan::create($request->only('yearly_price', 'monthly_price', 'no_of_words', 'is_support', 'usecase_daily_limit'));

        $langs = Language::getLocales();
        foreach ($langs as $lang) {
            $translation = $request->only($lang->locale);
            if ($translation[$lang->locale]['name']) {
                $plan->fill($translation);
            }
        }
        $plan->save();

        $plan->usecases()->sync($request->usecases);

        return redirect()->route('admin.plans')->withSuccess(__('admin.planCreated'));
    }


    public function edit(Request $request, Plan $plan)
    {
        $locales = Language::getLocales();
        $usecases = Usecase::active()->withTranslation()->get();
        $plan->load('usecases');

        return view('plans.edit', compact('locales', 'usecases', 'plan'));
    }

    /**
     *
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        $plan->update($request->only('yearly_price', 'monthly_price', 'no_of_words', 'is_support', 'usecase_daily_limit'));
        $langs = Language::getLocales();
        foreach ($langs as $lang) {
            $translation = $request->only($lang->locale);
            if ($translation[$lang->locale]['name']) {
                $plan->fill($translation);
            }
        }
        $plan->save();

        $plan->usecases()->sync($request->usecases);

        return redirect()->route('admin.plans')->withSuccess(__('admin.planUpdated'));
    }

    public function statusChange($id, $status)
    {
        $plan = Plan::findOrFail($id);
        $plan->update(['status' => $status]);

        return redirect()->route('admin.plans')->withSuccess(__('admin.planUpdated'));
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->back()->withSuccess(__('admin.planDeleted'));
    }

    public function transactions()
    {
        $transactions = Transaction::with(['plan', 'user'])->active()->has('plan')->has('user')->paginate();

        return view('plans.transactions', compact('transactions'));
    }


    public function createPlanSusbcription($plan = null)
    {
        $gateways = Payment::all();
        foreach ($gateways as $key => $gateway) {
            $gateway->createPlan($plan);
        }
    }
}
