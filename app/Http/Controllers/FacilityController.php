<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FacilityController extends Controller
{
    public function index()
    {
        // Get all facilities
        $facilities = facility::all();

        // Title for the page
        $title = [
            'id' => 'Fasilitas Karta Mulia',
            'en' => 'Batam University Facilities'
        ];

        // Get current locale and use the appropriate title
        $currentLocale = app()->getLocale();
        $pageTitle = $title[$currentLocale] ?? $title['en']; // Fallback to English if translation not found

        return view('pages.facilities', compact('facilities', 'pageTitle'));
    }

    /**
     * Display the details of a specific facility
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        // Get current locale
        $locale = app()->getLocale();

        // Find the facility by slug in the current locale
        $facility = Facility::where("slug->$locale", $slug)->first();

        // If not found, try to find by any locale's slug
        if (!$facility) {
            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                $facility = Facility::where("slug->$localeCode", $slug)->first();
                if ($facility) {
                    break;
                }
            }
        }

        // If still not found, return 404
        if (!$facility) {
            abort(404);
        }

        $pageTitle = $facility->getTranslation('name', $locale, false);

        // Generate localized URLs for different languages
        $localizedUrls = [];
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            // Get slug for this locale, with fallback to current slug if translation not available
            $localizedSlug = $facility->getTranslation('slug', $localeCode, false) ?: $slug;

            // Generate proper URL for this locale
            $url = LaravelLocalization::getLocalizedURL(
                $localeCode,
                route('facility.detail', ['slug' => $localizedSlug], false)
            );

            $localizedUrls[$localeCode] = $url;
        }

        // Share facility with all views including the topbar
        view()->share('currentFacility', $facility);

        return view('pages.facility-detail', compact('facility', 'pageTitle', 'localizedUrls'));
    }
}
