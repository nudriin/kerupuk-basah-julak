<?php

namespace Devina\KerupukJulak\Controller;

require_once __DIR__ . "/../Helper/ImageHelper.php";

use Exception;
use Devina\KerupukJulak\App\ViewRender;
use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Domain\Sessions;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Account\AccountDeleteRequest;
use Devina\KerupukJulak\Model\Account\AccountLoginRequest;
use Devina\KerupukJulak\Model\Account\AccountPasswordRequest;
use Devina\KerupukJulak\Model\Account\AccountRegisterRequest;
use Devina\KerupukJulak\Model\Account\AccountUpdateProfileRequest;
use Devina\KerupukJulak\Repository\AccountRepository;
use Devina\KerupukJulak\Repository\SessionsRepository;
use Devina\KerupukJulak\Service\AccountService;
use Devina\KerupukJulak\Service\SessionsService;

class AdminController
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
        $admin = $this->sessionsService->current("Admin");
        if ($admin != null) {
            $profile = $admin->profile_pic;
        }
        ViewRender::adminRender("Admin/admin-register", [
            "title" => "Tambah Admin",
            "admin_profile" => $profile
        ]);
    }

    public function postRegister()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $request = new AccountRegisterRequest();
            $request->id = "ADM" . uniqid();
            $request->username = htmlspecialchars($_POST['username']);
            $request->email = htmlspecialchars($_POST['email']);
            $request->name = htmlspecialchars($_POST['name']);
            $request->phone =  htmlspecialchars($_POST['phone']);
            $request->password = htmlspecialchars($_POST['password']);
            $request->role = "Admin";

            $this->accountService->register($request);
            ViewRender::redirect("/admin");
        } catch (Exception $e) {
            ViewRender::adminRender("Admin/admin-register", [
                "title" => "Tambah Admin",
                "post_username" => $request->username,
                "post_email" => $request->email,
                "post_name" => $request->name,
                "post_phone" => $request->phone,
                "error" => $e->getMessage(),
                "admin_profile" => $profile
            ]);
        }
    }

    public function login()
    {
        ViewRender::render("Admin/admin-login", [
            "title" => "Admin Login"
        ]);
    }

    public function postLogin()
    {
        try {
            $request = new AccountLoginRequest();
            $request->email = htmlspecialchars($_POST['email']);
            $request->password = htmlspecialchars($_POST['password']);

            $account = $this->accountService->accountLogin($request);
            $this->sessionsService->createSessions($account->account->id, "Admin");

            ViewRender::redirect("/admin");
        } catch (ValidationException $e) {
            ViewRender::render("Admin/admin-login", [
                "title" => "Admin Login",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        $this->sessionsService->destroy("Admin");
        ViewRender::redirect("/");
    }

    public function updateProfile()
    {
        $admin = $this->sessionsService->current("Admin");
        if ($admin != null) {
            $profile = $admin->profile_pic;
        }
        ViewRender::adminRender("Admin/admin-profile", [
            "title" => "Update profile",
            "admin" => $admin,
            "admin_profile" => $profile
        ]);
    }

    public function postUpdateProfile()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $request = new AccountUpdateProfileRequest();
            $request->id = $admin->id;
            $request->name = htmlspecialchars($_POST['name']);
            $request->profile_pic = htmlspecialchars($_FILES['picture']['name']);
            $this->accountService->accountUpdateProfile($request);
            if ($profile != "profile.png") {
                deleteImage($profile, "profile");
            }
            moveImage($_FILES['picture']['tmp_name'], $request->profile_pic, "profile");
            ViewRender::redirect('/admin/profile');
        } catch (ValidationException $e) {
            ViewRender::adminRender(
                "Admin/admin-profile",
                [
                    "title" => "Update profile",
                    "error" => $e->getMessage(),
                    "admin_profile" => $profile,
                    "admin_email" => $admin->email,
                    "admin_name" => $request->name
                ]
            );
        }
    }

    public function updatePassword()
    {
        $admin = $this->sessionsService->current("Admin");
        if ($admin != null) {
            $profile = $admin->profile_pic;
        }
        ViewRender::adminRender("Admin/admin-password", [
            "title" => "Update password",
            "admin" => $admin,
            "admin_profile" => $profile,
        ]);
    }

    public function postUpdatePassword()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $request = new AccountPasswordRequest();
            $request->id = $admin->id;
            $request->oldPassword = htmlspecialchars($_POST['old_password']);
            $request->newPassword = htmlspecialchars($_POST['new_password']);

            $this->accountService->accountUpdatePassword($request);
            ViewRender::redirect('/admin');
        } catch (ValidationException $e) {
            ViewRender::adminRender("Admin/admin-password", [
                "title" => "Update password",
                "admin" => $admin,
                "admin_profile" => $profile,
            ]);
        }
    }

    public function adminAccount()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $displayAdmin = $this->accountService->displayAccount();
            ViewRender::adminRender("Admin/admin-account", [
                "title" => "Admin account",
                "admin" => $admin,
                "displayAdmin" => $displayAdmin->account,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::adminRender("Admin/admin-account", [
                "title" => "Admin account",
                "error" => $e->getMessage(),
                "admin_profile" => $profile,
            ]);
        }
    }

    public function delete(string $id)
    {
        try {
            $request = new AccountDeleteRequest();
            $request->id = $id;

            $this->accountService->deleteAdmin($request);
            ViewRender::redirect("/admin/account");
        } catch (ValidationException $e) {
            ViewRender::redirect("/admin/account");
        }
    }

    public function displayAllUser()
    {
        try {
            $admin = $this->sessionsService->current("Admin");
            if ($admin != null) {
                $profile = $admin->profile_pic;
            }
            $user = $this->accountService->displayAccount();
            ViewRender::adminRender("Admin/admin-user-list", [
                "title" => "Daftar User",
                "user" => $user->account,
                "admin_profile" => $profile,
            ]);
        } catch (ValidationException $e) {
            ViewRender::adminRender("Admin/admin-user-list", [
                "title" => "Admin account",
                "error" => $e->getMessage(),
                "admin_profile" => $profile,
            ]);
        }
    }
}
