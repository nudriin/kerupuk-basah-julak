<?php
namespace Devina\KerupukJulak\Service;

use Devina\KerupukJulak\Config\Database;
use Devina\KerupukJulak\Domain\Account;
use Devina\KerupukJulak\Exception\ValidationException;
use Devina\KerupukJulak\Model\Account\AccountDeleteRequest;
use Devina\KerupukJulak\Model\Account\AccountDisplayResponse;
use Devina\KerupukJulak\Model\Account\AccountLoginRequest;
use Devina\KerupukJulak\Model\Account\AccountLoginResponse;
use Devina\KerupukJulak\Model\Account\AccountPasswordRequest;
use Devina\KerupukJulak\Model\Account\AccountPasswordResponse;
use Devina\KerupukJulak\Model\Account\AccountRegisterRequest;
use Devina\KerupukJulak\Model\Account\AccountRegisterResponse;
use Devina\KerupukJulak\Model\Account\AccountUpdateProfileRequest;
use Devina\KerupukJulak\Model\Account\AccountUpdateProfileResponse;
use Devina\KerupukJulak\Repository\AccountRepository;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class AccountService
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository) 
    {
        $this->accountRepository = $accountRepository;
    }

    public function register(AccountRegisterRequest $request) : AccountRegisterResponse
    {
        $this->validateRegister($request);
        try {
            Database::beginTransaction();
            $account = $this->accountRepository->findByEmail($request->email);
            if($account != null){
                throw new ValidationException("Email ini sudah terdaftar");
            }
            $account = new Account();
            $account->id = $request->id;
            $account->username = $request->username;
            $account->name = $request->name;
            $account->email = $request->email;
            $account->phone = $request->phone;
            $account->password = password_hash($request->password, PASSWORD_BCRYPT);
            $account->role = $request->role;
            $account->profile_pic = "profile.png";
            
            $this->accountRepository->save($account);
            Database::commitTransaction();

            $response = new AccountRegisterResponse();
            $response->account = $account;

            return $response;
        } catch (ValidationException $e) {
            //throw $th;
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function validateRegister(AccountRegisterRequest $request) 
    {
        if($request->username == null || $request->name == null || $request->email == null || $request->password == null || $request->phone == null ||
            trim($request->username) == "" || trim($request->name) == "" || trim($request->email) == "" || trim($request->password) == "" || trim($request->phone == "")){
                throw new ValidationException("Username, email, nama, dan password tidak boleh kosong");
            }
    }
    
    public function accountLogin(AccountLoginRequest $request) : AccountLoginResponse
    {
        $this->validateLogin($request);
        try{
            $account = $this->accountRepository->findByEmail($request->email);
            if($account == null){
                throw new ValidationException("Email atau password salah");
            }
            if(password_verify($request->password, $account->password)){
                $response = new AccountLoginResponse();
                $response->account = $account;
                return $response;
            } else{
                throw new ValidationException("Email atau password salah");
            }
        } catch(ValidationException $e){
            throw $e;
        }
    }

    
    public function validateLogin(AccountLoginRequest $request) 
    {
        if($request->email == null || $request->password == null ||
        trim($request->email) == "" || trim($request->password) == ""){
            throw new ValidationException("Email dan password tidak boleh kosong");
        }
    }
    
    public function accountUpdateProfile(AccountUpdateProfileRequest $request) : AccountUpdateProfileResponse 
    {
        $this->validateAccountUpdateProfile($request);
        try{
            Database::beginTransaction();
            $account = $this->accountRepository->findById($request->id);
            if($account == null){
                throw new ValidationException("Akun tidak ditemukan");
            }
            $account->name = $request->name;
            $account->profile_pic = $request->profile_pic;
            $this->accountRepository->update($account);
            Database::commitTransaction();
            $response = new AccountUpdateProfileResponse();
            $response->account = $account;
            return $response;
        } catch (ValidationException $e){
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function validateAccountUpdateProfile(AccountUpdateProfileRequest $request) 
    {
        if($request->name == null || $request->profile_pic == null || trim($request->name) == ""){
            throw new ValidationException("Nama tidak boleh kosong");
        }
    }
    
    public function accountUpdatePassword(AccountPasswordRequest $request) : AccountPasswordResponse
    {
        $this->validateaAccountUpdatePassword($request);
        try {
            Database::beginTransaction();
            $account = $this->accountRepository->findById($request->id);
            if($account == null){
                throw new ValidationException("Akun tidak ditemukan");
            }

            if(!password_verify($request->oldPassword, $account->password)){
                throw new ValidationException("Password lama salah");
            }

            $account->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $this->accountRepository->update($account);
            Database::commitTransaction();
            $response = new AccountPasswordResponse();
            $response->account = $account;
            return $response;
        } catch (ValidationException $e) {
            Database::rollbackTransaction();
            throw $e;

        }
    }
    
    public function validateaAccountUpdatePassword(AccountPasswordRequest $request) 
    {
        if($request->oldPassword == null || $request->newPassword == null || trim($request->oldPassword) == "" || trim($request->newPassword) == ""){
            throw new ValidationException("Password tidak boleh kosong");
        }
    }

    public function displayAccount() : AccountDisplayResponse
    {
        try{
            $account = $this->accountRepository->findAll();
            if($account == null){
                throw new ValidationException("Akun tidak ditemukan");
            }
            $response = new AccountDisplayResponse();
            $response->account = $account;
            return $response;
        } catch(ValidationException $e) {
            throw $e;
        }
    }   
    
    public function deleteAdmin(AccountDeleteRequest $request)
    {
        try {
            $admin = $this->accountRepository->findById($request->id);
            if($admin == null){
                throw new ValidationException("Gagal menghapus admin");
            }
            $this->accountRepository->deleteById($request->id);
        } catch (ValidationException $e) {
            throw $e;
        }
    }
}