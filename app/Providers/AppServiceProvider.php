<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Mcp\Facades\Mcp;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\TourRepositoryInterface::class,
            \App\Repositories\TourRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\CarRepositoryInterface::class,
            \App\Repositories\CarRepository::class
        );
    }

    public function boot(): void
    {
        Mcp::local('default', \App\Mcp\Servers\DefaultServer::class);

        // Share categories and settings with all views (cached per request)
        View::composer('*', function ($view) {
            static $sharedData = null;

            if ($sharedData === null) {
                // Cache kategori navigasi selama 1 jam
                $navCategories = Cache::remember('nav_categories', 3600, function () {
                    return Category::active()->orderBy('sort_order')->get();
                });

                // Cache settings selama 1 jam
                $settings = Cache::remember('app_settings', 3600, function () {
                    $allSettings = Setting::all();
                    $result = [];
                    foreach ($allSettings as $s) {
                        $value = $s->value;
                        if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
                            $decoded = json_decode($value, true);
                            $value = (json_last_error() === JSON_ERROR_NONE) ? $decoded : $value;
                        }
                        $result[$s->key] = $value;
                    }
                    return $result;
                });

                $wishlistedProductIds = [];
                $wishlistedVehicleIds = [];
                try {
                    $wishlistQuery = Wishlist::query();
                    if (Auth::check()) {
                        $wishlistQuery->where('user_id', Auth::id());
                    } else {
                        $wishlistQuery->where('session_id', Session::getId());
                    }
                    $wishlisted = $wishlistQuery->get();
                    $wishlistedProductIds = $wishlisted->pluck('product_id')->filter()->toArray();
                    $wishlistedVehicleIds = $wishlisted->pluck('vehicle_id')->filter()->toArray();
                } catch (\Throwable $e) {
                    // ignore
                }

                $sharedData = compact('navCategories', 'settings', 'wishlistedProductIds', 'wishlistedVehicleIds');
            }

            $view->with('navCategories', $sharedData['navCategories']);
            $view->with('settings', $sharedData['settings']);
            $view->with('wishlistedProductIds', $sharedData['wishlistedProductIds']);
            $view->with('wishlistedVehicleIds', $sharedData['wishlistedVehicleIds']);
        });

        // Set application locale from session
        try {
            $locale = Session::get('locale');
            if ($locale) {
                \Illuminate\Support\Facades\App::setLocale($locale);
            }
        } catch (\Throwable $e) {
            // ignore during early bootstrap
        }
    }
}
