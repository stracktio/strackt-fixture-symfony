<?php

namespace App\Controller;

use App\Entity\HandledPing;
use App\Message\Ping;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ProbeController
{
    #[Route('/probe/db', methods: ['GET'])]
    public function db(Connection $connection): Response
    {
        $connection->executeQuery('SELECT 1')->fetchOne();

        return new Response("ok\n", headers: ['Content-Type' => 'text/plain']);
    }

    #[Route('/probe/dispatch', methods: ['GET'])]
    public function dispatch(MessageBusInterface $bus): Response
    {
        $id = bin2hex(random_bytes(4));
        $bus->dispatch(new Ping($id, date(DATE_ATOM)));

        return new Response("dispatched {$id}\n", headers: ['Content-Type' => 'text/plain']);
    }

    #[Route('/probe/count', methods: ['GET'])]
    public function count(EntityManagerInterface $entityManager): Response
    {
        $count = $entityManager->getRepository(HandledPing::class)->count([]);

        return new Response("{$count}\n", headers: ['Content-Type' => 'text/plain']);
    }
}
