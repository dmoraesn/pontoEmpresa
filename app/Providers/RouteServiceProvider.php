<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Middleware\CheckTipoUsuario;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Defina o namespace base para os controllers
     */
    protected $namespace = 'App\\Http\\Controllers';

    public function boot()
    {
        parent::boot();

        // 👉 Registrar alias para nosso middleware customizado
        Route::aliasMiddleware('check.tipo', CheckTipoUsuario::class);
    }

    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
