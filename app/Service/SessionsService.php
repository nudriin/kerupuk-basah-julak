<?php
namespace Devina\KerupukJulak\Service;

use Devina\KerupukJulak\Domain\Sessions;
use Devina\KerupukJulak\Domain\Account;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Repository\AccountRepository;

class SessionsService
{
    private static string $SESSION_USER = "X-USER-SESSION";
    private static string $SESSION_ADMIN = "X-ADMIN-SESSION";
    private SessionsRepository $sessionsRepository;
    private AccountRepository $accountRepository;

    public function __construct(SessionsRepository $sessionsRepository, AccountRepository $accountRepository)
    {
        $this->sessionsRepository = $sessionsRepository;
        $this->accountRepository = $accountRepository;
    }

    public function createSessions(string $account_id, string $role) : Sessions
    {
        $sessions = new Sessions();
        $sessions->id = uniqid();
        $sessions->account_id = $account_id;

        $this->sessionsRepository->addSessions($sessions);
        if($role == "Admin"){
            setcookie(self::$SESSION_ADMIN, $sessions->id, time() + (60 * 60 * 24 * 30), "/");
        } else if($role == "User") {
            setcookie(self::$SESSION_USER, $sessions->id, time() + (60 * 60 * 24 * 30), "/");
        }

        return $sessions;
    }

    public function current(string $role) : ?Account
    {
        if($role == "Admin"){
            $sessionsId = $_COOKIE[self::$SESSION_ADMIN] ?? "";
        } else if($role == "User"){
            $sessionsId = $_COOKIE[self::$SESSION_USER] ?? "";
        }
        $sessions = $this->sessionsRepository->findById($sessionsId);

        if($sessions == null){
            return null;
        }

        return $this->accountRepository->findById($sessions->account_id);
    }

    public function destroy(string $role)
    {
        if($role == "Admin"){
            $sessionsId = $_COOKIE[self::$SESSION_ADMIN] ?? "";
            $this->sessionsRepository->deleteById($sessionsId);
            // set session to expired by (1 = masa lampau) 
            setcookie(self::$SESSION_ADMIN, "", 1, "/");
        } else if($role == "User"){
            $sessionsId = $_COOKIE[self::$SESSION_USER] ?? "";
            $this->sessionsRepository->deleteById($sessionsId);
            // set session to expired by (1 = masa lampau) 
            setcookie(self::$SESSION_USER, "", 1, "/");
        }
    }
    
//     public function createAdminSessions(string $account_id) : Sessions
//     {
//         $sessions = new Sessions();
//         $sessions->id = uniqid();
//         $sessions->account_id = $account_id;

//         $this->sessionsRepository->addSessions($sessions);

//         setcookie(self::$SESSION_ADMIN, $sessions->id, time() + (60 * 60 * 24 * 30), "/");

//         return $sessions;
//     }

//     public function currentAdmin() : ?Account
//     {
//         $sessionsId = $_COOKIE[self::$SESSION_ADMIN] ?? "";
//         $sessions = $this->sessionsRepository->findById($sessionsId);

//         if($sessions == null){
//             return null;
//         }

//         return $this->accountRepository->findById($sessions->account_id);
//     }

//     public function destroyAdmin()
//     {
//         $sessionsId = $_COOKIE[self::$SESSION_ADMIN] ?? "";
//         $this->sessionsRepository->deleteById($sessionsId);
//         // set session to expired by (1 = masa lampau) 
//         setcookie(self::$SESSION_ADMIN, "", 1, "/");
//     }
}