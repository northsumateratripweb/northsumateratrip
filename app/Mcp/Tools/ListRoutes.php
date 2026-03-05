<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Route;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('List all registered routes in the application with method, URI, name, and controller info.')]
class ListRoutes extends Tool
{
    public function handle(Request $request): Response
    {
        $filter = $request->string('filter', '');
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
                'middleware' => implode(', ', $route->middleware()),
            ];
        });

        if ($filter) {
            $routes = $routes->filter(fn ($r) => str_contains($r['uri'], $filter) || str_contains($r['name'] ?? '', $filter));
        }

        $output = $routes->map(fn ($r) => "{$r['method']} {$r['uri']} [{$r['name']}] → {$r['action']}")->implode("\n");

        return Response::text("Routes (" . $routes->count() . "):\n" . $output);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'filter' => $schema->string()->description('Optional filter to search routes by URI or name'),
        ];
    }
}
