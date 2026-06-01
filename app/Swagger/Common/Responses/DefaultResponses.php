<?php

declare(strict_types=1);

namespace App\Swagger\Common\Responses;

class DefaultResponses
{
    public static function get(): array
    {
        return [
            400 => new BadRequestResponse(),
            404 => new NotFoundResponse(),
            422 => new UnprocessableEntityResponseResponse(),
            500 => new InternalServerErrorResponse(),
        ];
    }
}
