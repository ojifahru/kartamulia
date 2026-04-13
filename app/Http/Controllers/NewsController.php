<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function news()
    {
        $news = News::with('category')
            ->where('is_published', true)
            ->where('category_id', 2) // Berita reguler
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $title = [
            'id' => 'Berita Karta Mulia',
            'en' => 'Batam University News'
        ];

        // Get current locale and use the appropriate title
        $currentLocale = app()->getLocale();
        $pageTitle = $title[$currentLocale] ?? $title['en']; // Fallback to English if translation not found

        return view('pages.news', compact('news', 'pageTitle'));
    }

    public function announcement()
    {
        $news = News::with('category')
            ->where('is_published', true)
            ->where('category_id', 3) // Pengumuman
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $title = [
            'id' => 'Pengumuman',
            'en' => 'Announcement'
        ];

        // Get current locale and use the appropriate title
        $currentLocale = app()->getLocale();
        $pageTitle = $title[$currentLocale] ?? $title['en']; // Fallback to English if translation not found

        return view('pages.news', compact('news', 'pageTitle'));
    }

    public function detail($slug)
    {
        // Get the current locale
        $locale = app()->getLocale();

        // Check which route was called (news or announcements)
        $routeName = request()->route()->getName();
        $isAnnouncement = $routeName === 'announcements.detail';

        // Filter by category based on the route
        $categoryId = $isAnnouncement ? 3 : 2;

        // Find the news by checking the slug against the title in the current locale
        // and filter by the correct category
        $news = News::with('category')
            ->where('is_published', true)
            ->where('category_id', $categoryId)
            ->get()
            ->filter(function ($item) use ($slug, $locale) {
                return Str::slug($item->getTranslation('title', $locale)) == $slug;
            })
            ->first();

        // If news not found by slug, try to find it by ID (fallback)
        if (!$news && is_numeric($slug)) {
            $news = News::with('category')
                ->where('id', $slug)
                ->where('is_published', true)
                ->where('category_id', $categoryId)
                ->first();
        }

        // If still not found, return 404
        if (!$news) {
            abort(404);
        }

        $pageTitle = $news->getTranslation('title', $locale);

        // Pass the type to the view for proper back navigation and breadcrumbs
        return view('pages.news_detail', compact('news', 'pageTitle', 'isAnnouncement'));
    }
}
