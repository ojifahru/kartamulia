<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Logo;
use App\Models\Identity;
use App\Models\Facility;
use App\Models\Category;
use App\Models\Faculty;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // View composer untuk logo
        View::composer('*', function ($view) {
            $logo = Logo::first() ?? new Logo();
            $view->with('logo', $logo);
        });

        // View service untuk identity
        View::composer('*', function ($view) {
            $identity = Identity::first() ?? new Identity();
            $view->with('identity', $identity);
        });

        // View composer untuk Facilities - perbaikan untuk memastikan slug tersedia
        View::composer(['layouts.navbar', 'pages.facilities', 'pages.home'], function ($view) {
            $facilities = Facility::select('id', 'name', 'slug', 'image')->get();
            $view->with('facilities', $facilities);
        });

        // View Composer untuk category
        View::composer(['layouts.navbar'], function ($view) {
            $categories = Category::select('id', 'name', 'slug')->get();
            $view->with('categories', $categories);
        });

        // View composer untuk faculties dan departments
        View::composer(['layouts.navbar'], function ($view) {
            // Define the custom order of faculty IDs
            $orderedIds = [13, 14, 11, 10, 15, 12, 9]; // Replace with your desired order

            // Get faculties with their departments
            $faculties = Faculty::with(['departements:id,faculty_id,name,slug'])
                ->select('id', 'name')
                ->get();

            // Sort the collection based on the custom order
            $sortedFaculties = $faculties->sortBy(function ($faculty) use ($orderedIds) {
                return array_search($faculty->id, $orderedIds) !== false
                    ? array_search($faculty->id, $orderedIds)
                    : PHP_INT_MAX; // Put any IDs not in the list at the end
            });

            $view->with('faculties', $sortedFaculties);
        });
    }
}
