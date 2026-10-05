<?php

namespace App\MessageHandler;

use App\Entity\HandledPing;
use App\Message\Ping;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PingHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(Ping $ping): void
    {
        $this->entityManager->persist(new HandledPing($ping->id, new \DateTimeImmutable()));
        $this->entityManager->flush();

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
