<?php

// Configurado para realizar gerenciamento de rotas 
namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60) -> by($request -> user()?-> id ?: $request -> ip());
        });

        $this->routes(function () {
            // Rotas da API
            Route::middleware('api') -> prefix('api') -> group(base_path('routes/api.php'));

            // Rotas Web
            Route::middleware('web') -> group(function(){
                require base_path('routes/web.php');      // Rotas principais do site 
                require base_path('routes/auth.php');     // Rotas de auteticação
            });
        });
    }
}
