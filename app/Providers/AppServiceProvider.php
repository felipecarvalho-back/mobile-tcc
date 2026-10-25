<?php

namespace App\Providers;

use App\NativeComponents\AppBottomBar;
use App\NativeComponents\MercosulPlate;
use App\NativeComponents\VehicleCard;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Native\Mobile\Edge\ComponentRegistry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! app()->runningInConsole()) {
            set_time_limit(120);
            ini_set('max_execution_time', '120');
        }

        Http::globalOptions([
            'timeout' => 120,
            'connect_timeout' => 30,
        ]);

        $this->configureDefaults();

        ComponentRegistry::components([
            'mercosul-plate' => MercosulPlate::class,
            'app-bottom-bar' => AppBottomBar::class,
            'vehicle-card' => VehicleCard::class,
        ]);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
