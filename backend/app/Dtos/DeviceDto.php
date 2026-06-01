<?php

namespace App\Dtos;

class DeviceDto
{
    public function __construct(
        public string $uuid,
        public string $name,
    ) {
    }
}
