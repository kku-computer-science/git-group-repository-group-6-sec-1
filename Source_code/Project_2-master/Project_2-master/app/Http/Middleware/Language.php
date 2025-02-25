<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // เพิ่มการตรวจสอบพารามิเตอร์ lang จาก URL ถ้ามี
        $localeParam = $request->route('lang');

        if ($localeParam && array_key_exists($localeParam, config('languages'))) {
            // ถ้ามีพารามิเตอร์ lang ที่ถูกต้อง ให้เซ็ตภาษาตามพารามิเตอร์
            App::setLocale($localeParam);
            Session::put('applocale', $localeParam);
        } else {
            // ====== โค้ดเดิมของคุณ ======
            if (Session()->has('applocale') 
                && array_key_exists(Session()->get('applocale'), config('languages'))) {
                App::setLocale(Session()->get('applocale'));
            } else {
                // ถ้าไม่มีใน Session ก็ใช้ fallback_locale
                App::setLocale(config('app.fallback_locale'));
            }
            // ====== จบโค้ดเดิม ======
        }

        return $next($request);
    }
}
