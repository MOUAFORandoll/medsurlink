<?php

namespace App\Providers;

use App\Models\ConsultationMedecineGenerale;
use App\Models\Motif;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
        Relation::morphMap([
            'Motif'=>Motif::class,
            'Consultation'=>ConsultationMedecineGenerale::class
        ]);
    }
}
