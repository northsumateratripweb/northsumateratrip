<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Artisan;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Run safe artisan commands like migrate:status, route:list, config:show, etc. Dangerous commands are blocked.')]
class RunArtisan extends Tool
{
    private const ALLOWED_COMMANDS = [
        'migrate:status',
        'route:list',
        'config:show',
        'about',
        'db:show',
        'db:table',
        'model:show',
        'schedule:list',
        'env',
    ];

    public function handle(Request $request): Response
    {
        $command = trim($request->string('command'));

        // Check if command is in allowed list
        $baseCommand = explode(' ', $command)[0];
        if (!in_array($baseCommand, self::ALLOWED_COMMANDS)) {
            return Response::text("Error: Command '{$baseCommand}' is not allowed.\nAllowed: " . implode(', ', self::ALLOWED_COMMANDS));
        }

        try {
            Artisan::call($command);
            $output = Artisan::output();
            return Response::text($output ?: 'Command completed with no output.');
        } catch (\Throwable $e) {
            return Response::text('Error: ' . $e->getMessage());
        }
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'command' => $schema->string()->description('The artisan command to run (e.g. migrate:status, route:list, about)'),
        ];
    }
}
