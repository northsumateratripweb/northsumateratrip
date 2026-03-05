<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\DB;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Run a read-only SQL query against the database. Only SELECT statements are allowed.')]
class DatabaseQuery extends Tool
{
    public function handle(Request $request): Response
    {
        $query = trim($request->string('query'));

        // Only allow SELECT queries for safety
        if (!preg_match('/^\s*SELECT\b/i', $query)) {
            return Response::text('Error: Only SELECT queries are allowed.');
        }

        // Block dangerous patterns
        if (preg_match('/\b(DROP|DELETE|UPDATE|INSERT|ALTER|TRUNCATE|CREATE|GRANT|REVOKE)\b/i', $query)) {
            return Response::text('Error: Only read-only SELECT queries are allowed.');
        }

        try {
            $results = DB::select($query);
            $output = json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            return Response::text("Results (" . count($results) . " rows):\n" . $output);
        } catch (\Exception $e) {
            return Response::text('Query error: ' . $e->getMessage());
        }
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()->description('The SELECT SQL query to run'),
        ];
    }
}
