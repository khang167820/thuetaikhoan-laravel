<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportBlogPosts extends Command
{
    protected $signature = 'blog:import {--path= : Path to legacy blog folder}';
    protected $description = 'Import blog posts from legacy PHP files';

    public function handle()
    {
        $blogPath = $this->option('path') ?: 'D:/Dowload/thuetaikhoan/public_html/blog';
        
        if (!is_dir($blogPath)) {
            $this->error("Blog directory not found: $blogPath");
            return 1;
        }

        $files = glob($blogPath . '/*.php');
        $imported = 0;
        $skipped = 0;
        $errors = [];

        // Skip these files
        $skipFiles = ['post.php', '.htaccess', 'testpoint-edl9008-data.php', 'testpoint-edl9008-samsung-data.php'];

        $this->info("Found " . count($files) . " PHP files in $blogPath");
        $this->info("Starting import...\n");

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        foreach ($files as $file) {
            $filename = basename($file);
            
            // Skip helper files
            if (in_array($filename, $skipFiles) || strpos($filename, 'testpoint-edl9008-samsung-galaxy') !== false 
                || strpos($filename, 'testpoint-edl9008-xiaomi-') !== false) {
                $bar->advance();
                $skipped++;
                continue;
            }

            try {
                // Generate slug from filename
                $slug = str_replace('.php', '', $filename);
                
                // Check if already exists
                $exists = DB::table('blog_posts')->where('slug', $slug)->first();
                if ($exists) {
                    $bar->advance();
                    $skipped++;
                    continue;
                }

                // Extract data from file
                $content = file_get_contents($file);
                
                // Extract title
                $title = $this->extractTitle($content, $slug);
                
                // Extract meta info
                $description = $this->extractMetaDescription($content);
                $keywords = $this->extractMetaKeywords($content);
                $category = $this->extractCategory($content, $filename);
                
                // Extract HTML content (everything between <article> tags or the main content)
                $htmlContent = $this->extractHtmlContent($content);
                
                // Insert into database
                DB::table('blog_posts')->insert([
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => Str::limit(strip_tags($description ?: $htmlContent), 200),
                    'content' => $htmlContent,
                    'category' => $category,
                    'author' => 'Admin',
                    'status' => 'published',
                    'views' => rand(100, 5000),
                    'meta_title' => $title,
                    'meta_description' => $description,
                    'meta_keywords' => $keywords,
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now(),
                ]);
                
                $imported++;

            } catch (\Exception $e) {
                $errors[] = "$filename: " . $e->getMessage();
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Import completed!");
        $this->info("   Imported: $imported posts");
        $this->info("   Skipped: $skipped files");
        
        if (!empty($errors)) {
            $this->warn("   Errors: " . count($errors));
            foreach (array_slice($errors, 0, 10) as $error) {
                $this->error("   - $error");
            }
        }

        return 0;
    }

    private function extractTitle($content, $slug)
    {
        // Try to find title from $pageTitle variable
        if (preg_match('/\$pageTitle\s*=\s*[\'"]([^\|\'\"]+)/i', $content, $matches)) {
            return trim($matches[1]);
        }
        
        // Try from $post['title']
        if (preg_match('/[\'"]title[\'"]\s*=>\s*[\'"]([^\'\"]+)/i', $content, $matches)) {
            return trim($matches[1]);
        }
        
        // Try from <h1>
        if (preg_match('/<h1[^>]*>([^<]+)<\/h1>/i', $content, $matches)) {
            return trim(strip_tags($matches[1]));
        }
        
        // Generate from slug
        return ucfirst(str_replace(['-', '_'], ' ', $slug));
    }

    private function extractMetaDescription($content)
    {
        if (preg_match('/\$pageDescription\s*=\s*[\'"]([^\'\"]+)/i', $content, $matches)) {
            return trim($matches[1]);
        }
        return '';
    }

    private function extractMetaKeywords($content)
    {
        if (preg_match('/\$pageKeywords\s*=\s*[\'"]([^\'\"]+)/i', $content, $matches)) {
            return trim($matches[1]);
        }
        return '';
    }

    private function extractCategory($content, $filename)
    {
        // Try from $post['category']
        if (preg_match('/[\'"]category[\'"]\s*=>\s*[\'"]([^\'\"]+)/i', $content, $matches)) {
            return trim($matches[1]);
        }
        
        // Determine from filename
        if (strpos($filename, 'huong-dan') !== false) return 'Hướng dẫn';
        if (strpos($filename, 'so-sanh') !== false) return 'So sánh';
        if (strpos($filename, 'mua-license') !== false) return 'Mua License';
        if (strpos($filename, 'testpoint') !== false) return 'Testpoint';
        if (strpos($filename, 'cach-') !== false) return 'Hướng dẫn';
        if (strpos($filename, 'xoa-frp') !== false) return 'FRP';
        if (strpos($filename, 'top-') !== false) return 'Top List';
        if (strpos($filename, 'tai-') !== false) return 'Download';
        
        return 'Tin tức';
    }

    private function extractHtmlContent($content)
    {
        // Try to extract content between <article> tags
        if (preg_match('/<article[^>]*>(.*?)<\/article>/is', $content, $matches)) {
            return $this->cleanHtml($matches[1]);
        }
        
        // Try to extract after blog-post-hero section
        if (preg_match('/<section class="blog-post-content">(.*?)<\/section>/is', $content, $matches)) {
            return $this->cleanHtml($matches[1]);
        }
        
        // Extract any h2, p, ul, ol content
        $html = '';
        if (preg_match_all('/<(h2|h3|p|ul|ol|table|blockquote)[^>]*>.*?<\/\1>/is', $content, $matches)) {
            $html = implode("\n", $matches[0]);
        }
        
        return $this->cleanHtml($html) ?: '<p>Nội dung đang được cập nhật...</p>';
    }

    private function cleanHtml($html)
    {
        // Remove PHP tags
        $html = preg_replace('/<\?php.*?\?>/is', '', $html);
        $html = preg_replace('/<\?=.*?\?>/is', '', $html);
        
        // Remove script tags
        $html = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $html);
        
        // Remove style tags  
        $html = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $html);
        
        // Remove sidebar
        $html = preg_replace('/<aside[^>]*>.*?<\/aside>/is', '', $html);
        
        // Clean up whitespace
        $html = preg_replace('/\s+/', ' ', $html);
        $html = trim($html);
        
        return $html;
    }
}
