# strackt-fixture-symfony

A `symfony/skeleton` app with Symfony Messenger and the Doctrine transport, used to test Strackt's managed Messenger worker.

- `App\Message\Ping` is routed to the `async` transport (`MESSENGER_TRANSPORT_DSN`, Doctrine by default).
- `php bin/console app:ping` dispatches one message.
- `PingHandler` logs `[st2592-messenger] handled Ping …` to stderr, which lands in the worker's journal.
