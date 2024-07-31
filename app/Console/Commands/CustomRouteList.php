<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class CustomRouteList extends Command
{
    protected $signature = 'custom:api-route-list';
    protected $description = 'List all API routes, skipping those with errors';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $routes = Route::getRoutes();
        $rows = [];

        foreach ($routes as $route) {
            try {
                // Filter for routes that belong to the 'api' middleware group
                if (in_array('api', $route->middleware())) {
                    $rows[] = [
                        'method' => implode('|', $route->methods()),
                        'uri' => $route->uri(),
                        'name' => $route->getName(),
                        'action' => $route->getActionName(),
                        'middleware' => implode(', ', $route->middleware()),
                    ];
                }
            } catch (\Exception $e) {
                $this->error("Error processing route: " . $route->uri());
            }
        }

        $this->table(['Method', 'URI', 'Name', 'Action', 'Middleware'], $rows);
    }
}
