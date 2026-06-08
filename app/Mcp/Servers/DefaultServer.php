<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\DatabaseQuery;
use App\Mcp\Tools\ListModels;
use App\Mcp\Tools\ListRoutes;
use App\Mcp\Tools\RunArtisan;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('North Sumatera Trip')]
#[Version('1.0.0')]
#[Instructions('MCP Server for the North Sumatera Trip Laravel application. Provides tools to query the database, list routes, list models, and run safe artisan commands.')]
class DefaultServer extends Server
{
    protected array $tools = [
        DatabaseQuery::class,
        ListRoutes::class,
        ListModels::class,
        RunArtisan::class,
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
