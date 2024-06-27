<?php
namespace Devina\KerupukJulak\Middleware;

use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Repository\AccountRepository;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Service\SessionsService;


class AdminMustLoginMiddleware{
    private SessionsService $sessionsService;

    public function __construct() {
        $connection = Database::getConnect();
        $accountRepository = new AccountRepository($connection);
        $sessionsRepository = new SessionsRepository($connection);
        $this->sessionsService = new SessionsService($sessionsRepository, $accountRepository);
    }

    public function before(): void
    {
        $admin = $this->sessionsService->current("Admin");

        if($admin == null){
            ViewRender::redirect("/admin/login");
        }

    }
}