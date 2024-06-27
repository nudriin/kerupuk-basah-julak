<?php

namespace Devina\KerupukJulak\Controller;

require_once __DIR__ . "/../Helper/ImageHelper.php";

use Exception;
use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Domain\Sessions;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Account\AccountLoginRequest;
use Devina\KerupukJulak\Model\Account\AccountPasswordRequest;
use Devina\KerupukJulak\Model\Account\AccountRegisterRequest;
use Devina\KerupukJulak\Model\Account\AccountUpdateProfileRequest;
use Devina\KerupukJulak\Repository\AccountRepository;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Service\AccountService;
use Devina\KerupukJulak\Service\SessionsService;

class UserController
{
    private AccountService $accountService;
    private SessionsService $sessionsService;
    public function __construct()
    {
        $connection = Database::getConnect();
        $accountRepository = new AccountRepository($connection);
        $sessionsRepository = new SessionsRepository($connection);
        $this->accountService = new AccountService($accountRepository);
        $this->sessionsService = new SessionsService($sessionsRepository, $accountRepository);
    }

    public function register()
    {
        ViewRender::render("User/user-register", [
            "title" => "Daftar"
        ]);
    }

    public function postRegister()
    {
        try {
            $request = new AccountRegisterRequest();
            $request->id = "USR" . uniqid();
            $request->username = htmlspecialchars($_POST['username']);
            $request->email = htmlspecialchars($_POST['email']);
            $request->name = htmlspecialchars($_POST['name']);
            $request->phone =  htmlspecialchars($_POST['phone']);
            $request->password = htmlspecialchars($_POST['password']);
            $request->role = "User";

            $this->accountService->register($request);
            ViewRender::redirect("/");
        } catch (Exception $e) {
            ViewRender::render("User/user-register", [
                "title" => "Daftar",
                "post_username" => $request->username,
                "post_email" => $request->email,
                "post_name" => $request->name,
                "post_phone" => $request->phone,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function login()
    {
        ViewRender::render("User/user-login", [
            "title" => "Login"
        ]);
    }

    public function postLogin()
    {
        try {
            $request = new AccountLoginRequest();
            $request->email = htmlspecialchars($_POST['email']);
            $request->password = htmlspecialchars($_POST['password']);

            $account = $this->accountService->accountLogin($request);
            $this->sessionsService->createSessions($account->account->id, "User");

            ViewRender::redirect("/");
        } catch (ValidationException $e) {
            ViewRender::render("User/user-login", [
                "title" => "Login",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        $this->sessionsService->destroy("User");
        ViewRender::redirect("/");
    }

    public function updateProfile()
    {
        $user = $this->sessionsService->current("User");
        $profile = $user->profile_pic;

        ViewRender::userRender("User/user-profile", [
            "title" => "Update profile",
            "user" => $user,
            "user_profile" => $profile
        ]);
    }

    public function postUpdateProfile()
    {
        try {
            $user = $this->sessionsService->current("User");
            $profile = $user->profile_pic;
            $request = new AccountUpdateProfileRequest();
            $request->id = $user->id;
            $request->name = htmlspecialchars($_POST['name']);
            $request->profile_pic = htmlspecialchars($_FILES['picture']['name']);
            $this->accountService->accountUpdateProfile($request);
            if ($profile != "profile.png"){
                deleteImage($profile, "profile");
            }
            moveImage($_FILES['picture']['tmp_name'], $request->profile_pic, "profile");
            ViewRender::redirect('/user/profile');
        } catch (ValidationException $e) {
            ViewRender::userRender(
                "User/user-profile",
                [
                    "title" => "Update profile",
                    "error" => $e->getMessage(),
                    "user_profile" => $profile,
                    "user_email" => $user->email,
                    "user_name" => $request->name
                ]
            );
        }
    }

    public function updatePassword()
    {
        $user = $this->sessionsService->current("User");
        $profile = $user->profile_pic;
        ViewRender::userRender("User/user-password", [
            "title" => "Update password",
            "user" => $user,
            "user_profile" => $profile,
        ]);
    }

    public function postUpdatePassword()
    {
        try {
            $user = $this->sessionsService->current("User");
            $profile = $user->profile_pic;
            $request = new AccountPasswordRequest();
            $request->id = $user->id;
            $request->oldPassword = htmlspecialchars($_POST['old_password']);
            $request->newPassword = htmlspecialchars($_POST['new_password']);

            $this->accountService->accountUpdatePassword($request);
            ViewRender::redirect('/user');
        } catch (ValidationException $e) {
            ViewRender::userRender("User/user-password", [
                "title" => "Update password",
                "user" => $user,
                "user_profile" => $profile,
            ]);
        }
    }
}
