<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Modules\Core\App\Providers\CoreServiceProvider;
use Modules\PkgSanction\App\Providers\PkgSanctionServiceProvider;
<<<<<<< HEAD
use Modules\PkgAbsence\App\Providers\PkgAbsenceServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(PkgSanctionServiceProvider::class);
        $this->app->register(PkgApprenantServiceProvider::class);
        $this->app->register(PkgAbsenceServiceProvider::class);
=======
use Modules\PkgApprenant\App\Providers\PkgApprenantServiceProvider;
use modules\PkgEntretienInscrition\App\Providers\PkgEntretienInscritionProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->register(CoreServiceProvider::class);
    $this->app->register(PkgSanctionServiceProvider::class);
    $this->app->register(PkgApprenantServiceProvider::class);
    $this->app->register(PkgEntretienInscritionProvider::class);
  }
>>>>>>> 6705191a7201257af06be41baa0c7352c71b7391

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Vite::prefetch(concurrency: 3);
    View::addLocation(base_path('Modules/Core/Resources/Views'));
  }
}
