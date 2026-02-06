<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\BlogPost;

class SitemapController extends Controller
{
    /**
     * Generate sitemap index
     */
    public function index()
    {
        $sitemaps = [
            ['loc' => url('/sitemap-pages.xml'), 'lastmod' => now()->toW3cString()],
            ['loc' => url('/sitemap-services.xml'), 'lastmod' => now()->toW3cString()],
            ['loc' => url('/sitemap-posts.xml'), 'lastmod' => now()->toW3cString()],
        ];

        $content = view('sitemaps.index', compact('sitemaps'))->render();
        
        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate sitemap for static pages
     */
    public function pages()
    {
        $pages = [
            ['loc' => url('/'), 'lastmod' => now()->toW3cString(), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => url('/dang-nhap'), 'lastmod' => now()->toW3cString(), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => url('/dang-ky'), 'lastmod' => now()->toW3cString(), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => url('/ma-giam-gia'), 'lastmod' => now()->toW3cString(), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => url('/huong-dan'), 'lastmod' => now()->toW3cString(), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => url('/lien-he'), 'lastmod' => now()->toW3cString(), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => url('/dieu-khoan'), 'lastmod' => now()->toW3cString(), 'changefreq' => 'monthly', 'priority' => '0.3'],
        ];

        $content = view('sitemaps.urls', ['urls' => $pages])->render();
        
        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate sitemap for services
     */
    public function services()
    {
        // List of all services
        $serviceTypes = [
            'unlocktool', 'griffin', 'tsm', 'vietmap', 'amt', 'kg-killer',
            'samsung-tool', 'chimera', 'octoplus', 'infinity', 'easy-jtag',
            'medusa', 'umt', 'mrt', 'falcon', 'hydra', 'pandora', 'z3x',
            'nck', 'sigma', 'frp', 'halabtech', 'gsm-aladdin', 'eft',
            'uni-android', 'ultimate-multi'
        ];

        $urls = [];
        foreach ($serviceTypes as $type) {
            $urls[] = [
                'loc' => url("/thue-{$type}"),
                'lastmod' => now()->toW3cString(),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ];
        }

        $content = view('sitemaps.urls', ['urls' => $urls])->render();
        
        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate sitemap for blog posts
     */
    public function posts()
    {
        $urls = [];

        // Add blog index page
        $urls[] = [
            'loc' => url('/blog'),
            'lastmod' => now()->toW3cString(),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];

        // Get blog posts from database
        try {
            $posts = BlogPost::where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->get();

            foreach ($posts as $post) {
                $lastmod = $post->updated_at ?? $post->published_at ?? now();
                $urls[] = [
                    'loc' => url("/blog/{$post->slug}"),
                    'lastmod' => $lastmod->toW3cString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7'
                ];
            }
        } catch (\Exception $e) {
            // Log error but continue
            \Log::error('Sitemap posts error: ' . $e->getMessage());
        }

        // Add testpoint pages
        $testpoints = [
            'testpoint-edl9008-xiaomi',
            'testpoint-edl9008-samsung',
            'testpoint-edl9008-oppo',
            'testpoint-edl9008-vivo',
            'testpoint-edl9008-realme',
        ];

        foreach ($testpoints as $testpoint) {
            $urls[] = [
                'loc' => url("/blog/{$testpoint}"),
                'lastmod' => now()->toW3cString(),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ];
        }

        $content = view('sitemaps.urls', ['urls' => $urls])->render();
        
        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
