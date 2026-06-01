<?php

declare(strict_types=1);

namespace App\Swagger\Common\Responses;

use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class NotFoundResponse extends OA\Response
{
    public function __construct(
        $status = 'error',
        $statusCode = Response::HTTP_NOT_FOUND,
        $statusMessage = 'Not Found',
    ) {
        $properties[] = new OA\Property(property: 'status', type: 'string', example: $status);
        $properties[] = new OA\Property(property: 'statusCode', type: 'integer', example: $statusCode);
        $properties[] = new OA\Property(property: 'message', type: 'string', example: $statusMessage);

        parent::__construct(
            response: $statusCode,
            description: $statusMessage,
            content: new OA\JsonContent(
                properties: $properties
            ),
        );
    }
}
