# strackt-fixture-symfony

A `symfony/skeleton` app with Symfony Messenger and the Doctrine transport, used to test Strackt's managed Messenger worker.

- `App\Message\Ping` is routed to the `async` transport (`MESSENGER_TRANSPORT_DSN`, Doctrine by default).
- `php bin/console app:ping` dispatches one message.
- `PingHandler` logs `[st2592-messenger] handled Ping …` to stderr, which lands in the worker's journal.

## Branch `committed-env`

The stock Symfony shape: `.env` is committed with the recipe placeholders (`APP_ENV=dev`, an empty `APP_SECRET`, a `!ChangeMe!` PostgreSQL `DATABASE_URL`) and there is no `.env.example`. Doctrine ORM and Migrations are installed; one migration creates `handled_ping` and `messenger_messages` (the transport runs with `auto_setup=0`).

- `GET /probe/db` runs `SELECT 1` through Doctrine and returns `ok`.
- `GET /probe/dispatch` dispatches a `Ping` to the `async` transport.
- `GET /probe/count` returns how many `Ping` messages the worker has handled (`PingHandler` stores one `handled_ping` row each).
