<?php

namespace App\Repositories\Ping;

use App\Dtos\PingDto;

interface PingRepositoryInterface
{
    public function store(PingDto $data): void;
}
