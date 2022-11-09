<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Theloai;
use Carbon\Carbon;
use App\Models\Config;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
            $view->with([
                'theloai'=>Theloai::all(),
                'now'=>Carbon::now(),
                'address' => Config::where('slug', 'address')->where('type',3)->first(),
                'map' => Config::where('slug', 'map')->where('type',3)->first(),
                'phone' => Config::where('slug', 'phone')->where('type',3)->first(),
                'worktime' => Config::where('slug', 'work-time')->where('type',3)->first(),
                'email' => Config::where('slug', 'email')->where('type',3)->first(),
                'logo_home'=>Config::where('slug','logo-home')->where('type',1)->first(),
                'logo_title'=>Config::where('slug','logo-title')->where('type',1)->first(),
            ]);
            Carbon::setLocale('vi');
        });
    }
}
