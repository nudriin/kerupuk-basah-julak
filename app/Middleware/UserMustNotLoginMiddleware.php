<?php

namespace Devina\KerupukJulak\Middleware;

use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Repository\AccountRepository;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Service\SessionsService;


class UserMustNotLoginMiddleware
{
    private SessionsService $sessionsService;

    public function __construct()
    {
        $connection = Database::getConnect();
        $accountRepository = new AccountRepository($connection);
        $sessionsRepository = new SessionsRepository($connection);
        $this->sessionsService = new SessionsService($sessionsRepository, $accountRepository);
    }

    public function before(): void
    {
        $user = $this->sessionsService->current("User");

        if ($user != null) {
            ViewRender::redirect("/");
        }
    }
}
