<?php

declare(strict_types=1);

namespace App\Swagger\Attributes;

use App\Swagger\Common\Responses\DefaultResponses;
use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class PostEndpoint extends OA\Post
{
    public function __construct(
        string $path,
        string $operationId = '',
        string $description = '',
        string $summary = '',
        array $tags = [],
        array $parameters = [],
        ?OA\RequestBody $requestBody = null,
        array $responses = [],
    ) {
        parent::__construct(
            path: $path,
            operationId: $operationId,
            description: $description,
            summary: $summary,
            tags: $tags,
            parameters: $parameters,
            requestBody: $requestBody,
            responses: array_values(array_merge($responses, DefaultResponses::get())),
        );
    }
}
