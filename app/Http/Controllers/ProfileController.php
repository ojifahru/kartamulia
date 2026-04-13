<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;
use Illuminate\Support\Facades\App;

class ProfileController extends Controller
{
    public function index()
    {
        // Get all AboutUs entries
        $aboutUsEntries = AboutUs::all();

        // Title for the page
        $title = [
            'id' => 'Profil Karta Mulia',
            'en' => 'Batam University Profile'
        ];

        // Get current locale and use the appropriate title
        $currentLocale = App::getLocale();
        $pageTitle = $title[$currentLocale] ?? $title['en']; // Fallback to English if translation not found

        return view('pages.profile', compact('aboutUsEntries', 'pageTitle'));
    }
}
