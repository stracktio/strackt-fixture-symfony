<?php

namespace App\MessageHandler;

use App\Message\Ping;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PingHandler
{
    public function __invoke(Ping $ping): void
    {
        error_log(sprintf(
            '[st2592-messenger] handled Ping id=%s dispatched=%s consumer=%s pid=%d env=%s',
            $ping->id,
            $ping->dispatchedAt,
            getenv('MESSENGER_CONSUMER_NAME') ?: '(unset)',
            getmypid(),
            $_SERVER['APP_ENV'] ?? '(unset)',
        ));
    }
}
