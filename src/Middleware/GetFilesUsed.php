<?php

namespace Laraveldevtools\Laraveldevtools\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class GetFilesUsed
{
    protected array $renderedViews = [];

    public function handle($request, Closure $next)
    {
        Log::info('GetFilesUsed middleware is running.');

        // Register a composer for all views
        View::composer('*', function($view) {
            $path = $view->getPath();
            Log::info('View composed: ' . $path);
            if (!in_array($path, $this->renderedViews)) {
                $this->renderedViews[] = $path;
            }
        });

        $response = $next($request);

        // Log all rendered Blade view files
        Log::info('Blade files used in this request:', $this->renderedViews);

        // Store views in JSON file
        $this->storeViewsToJson($request);

        return $response;
    }

    protected function storeViewsToJson($request): void
    {
        // Get the path and ensure it's not empty
        $path = $request->path();
        $path = $path ?: 'index';

        // Create a safe filename from the path
        $filename = urlencode($path) . '.json';

        // Ensure the storage directory exists
        $directory = storage_path('framework/devtools/views');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Create the JSON data
        $data = [
            'url' => $request->fullUrl(),
            'path' => $path,
            'views' => $this->renderedViews,
            'timestamp' => now()->toIso8601String(),
        ];

        // Store the JSON file
        File::put(
            $directory . '/' . $filename,
            json_encode($data, JSON_PRETTY_PRINT)
        );
    }
}