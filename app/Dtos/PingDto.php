<?php

namespace App\Dtos;

class PingDto
{
    public function __construct(
        public string $uuid,
        public int $batteryPercent,
    ) {
    }
}
