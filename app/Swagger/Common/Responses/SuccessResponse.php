<?php

declare(strict_types=1);

namespace App\Swagger\Common\Responses;

use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class SuccessResponse extends OA\Response
{
    public function __construct(
        $status = 'success',
        $statusCode = Response::HTTP_OK,
        $statusMessage = 'OK'
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
