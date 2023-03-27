<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function changeLocale(Request $request, $locale)
    {
        if (\Lang::hasForLocale('common.noRecordsFund', $locale)) {
            \App::setLocale($locale);

            session()->put('locale', $locale);
            $menus = Menu::get();
            foreach ($menus as $menu) {
                app('\App\Models\Menu')->removeMenuFromCache($menu);
            }

            return redirect()->route('front.index');
        }

        return redirect()->route('front.index')->with('error', __('Language not found.'));
    }
}
