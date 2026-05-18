<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLanguage
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if (in_array($lang, ['ar', 'fr', 'en'])) {
                Session::put('locale', $lang);
            }
        }

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            // Default to fr if not set
            App::setLocale('fr');
        }

        return $next($request);
    }
}
