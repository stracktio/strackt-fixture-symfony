<?php

namespace App\Message;

final class Ping
{
    public function __construct(
        public readonly string $id,
        public readonly string $dispatchedAt,
    ) {
    }
}
