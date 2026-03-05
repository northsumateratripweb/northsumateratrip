<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\File;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('List all Eloquent models with their fillable fields, casts, and relationships.')]
class ListModels extends Tool
{
    public function handle(Request $request): Response
    {
        $modelsPath = app_path('Models');
        $files = File::files($modelsPath);
        $output = [];

        foreach ($files as $file) {
            $className = 'App\\Models\\' . $file->getFilenameWithoutExtension();
            if (!class_exists($className)) continue;

            try {
                $model = new $className;
                $reflection = new \ReflectionClass($model);

                $relationships = [];
                foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    if ($method->class !== $className) continue;
                    $returnType = $method->getReturnType();
                    if ($returnType && str_contains((string)$returnType, 'Illuminate\\Database\\Eloquent\\Relations')) {
                        $relationships[] = $method->getName();
                    }
                }

                $info = $file->getFilenameWithoutExtension();
                $info .= "\n  Table: " . $model->getTable();
                $info .= "\n  Fillable: " . implode(', ', $model->getFillable());
                $info .= "\n  Casts: " . json_encode($model->getCasts());
                if (!empty($relationships)) {
                    $info .= "\n  Relationships: " . implode(', ', $relationships);
                }
                $output[] = $info;
            } catch (\Throwable $e) {
                $output[] = $file->getFilenameWithoutExtension() . " - Error: " . $e->getMessage();
            }
        }

        return Response::text(implode("\n\n", $output));
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
