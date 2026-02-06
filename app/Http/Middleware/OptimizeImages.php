<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptimizeImages
{
    /**
     * Automatically add lazy loading to images in response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Only process HTML responses
        if (!$this->isHtmlResponse($response)) {
            return $response;
        }
        
        $content = $response->getContent();
        
        // Add loading="lazy" to images that don't have it
        $content = preg_replace(
            '/<img(?![^>]*loading=)([^>]*)>/i',
            '<img loading="lazy"$1>',
            $content
        );
        
        // Add decoding="async" to images that don't have it
        $content = preg_replace(
            '/<img(?![^>]*decoding=)([^>]*)>/i',
            '<img decoding="async"$1>',
            $content
        );
        
        $response->setContent($content);
        
        return $response;
    }
    
    protected function isHtmlResponse($response)
    {
        $contentType = $response->headers->get('Content-Type');
        return $contentType && str_contains($contentType, 'text/html');
    }
}
