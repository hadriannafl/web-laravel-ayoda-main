<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $this->CRM_ISS = DB::table('m_company')->select('nilai')->where('kunci', 'Nama OS')->first();
        } catch (\Exception $e) {
            $this->CRM_ISS = null;
        }

        if (is_null($this->CRM_ISS)) {
            $this->CRM_ISS = (object) ['nilai' => ''];
        }

        view()->composer('*', function ($view) {
            $view->with([
                'CRM_ISS' => $this->CRM_ISS,
            ]);
        });
    }
}
