<?php

namespace App\Http\Middleware;

use Theme;
use Closure;
use Butschster\Head\Facades\Meta;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class FrontTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $theme = !Config::get('artisan.installed') ?: Config::get('artisan.front_theme', 'neuralink');

        $this->setTheme($theme);

        return $next($request);
    }

    public function setTheme($themeName)
    {
        if (Theme::exists($themeName)) {
            Theme::set($themeName);
        }
    }
}
