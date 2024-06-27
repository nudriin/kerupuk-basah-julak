<?php

use Devina\KerupukJulak\App\Router;
use Devina\KerupukJulak\Controller\AdminHomeController;
use Devina\KerupukJulak\Controller\ArticleController;
use Devina\KerupukJulak\Controller\HomeController;
use Devina\KerupukJulak\Controller\SuggestionsController;
use Devina\KerupukJulak\Controller\AdminController;
use Devina\KerupukJulak\Controller\CartController;
use Devina\KerupukJulak\Controller\DiaryController;
use Devina\KerupukJulak\Controller\ProductsController;
use Devina\KerupukJulak\Controller\TransactionsController;
use Devina\KerupukJulak\Controller\UserController;
use Devina\KerupukJulak\Controller\UserHomeController;
use Devina\KerupukJulak\Middleware\AdminMustLoginMiddleware;
use Devina\KerupukJulak\Middleware\AdminMustNotLoginMiddleware;
use Devina\KerupukJulak\Controller\UsersController;
use Devina\KerupukJulak\Domain\User;
use Devina\KerupukJulak\Middleware\UserMustLoginMiddleware;
use Devina\KerupukJulak\Middleware\UserMustNotLoginMiddleware;

require_once "../vendor/autoload.php";
require_once "../app/App/Router.php";


Router::add("GET", "/", HomeController::class, "index");
Router::add("GET", "/shop", HomeController::class, "shop");

Router::add("GET", "/admin", AdminHomeController::class, "index", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/login", AdminController::class, "login", [AdminMustNotLoginMiddleware::class]);
Router::add("POST", "/admin/login", AdminController::class, "postLogin", [AdminMustNotLoginMiddleware::class]);
Router::add("GET", "/admin/register", AdminController::class, "register", [AdminMustLoginMiddleware::class]);
Router::add("POST", "/admin/register", AdminController::class, "postRegister", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/profile", AdminController::class, "updateProfile", [AdminMustLoginMiddleware::class]);
Router::add("POST", "/admin/profile", AdminController::class, "postUpdateProfile", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/password", AdminController::class, "updatePassword", [AdminMustLoginMiddleware::class]);
Router::add("POST", "/admin/password", AdminController::class, "postUpdatePassword", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/account", AdminController::class, "adminAccount", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/logout", AdminController::class, "logout", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/delete/([a-z0-9A-Z]+)", AdminController::class, "delete", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/user-list", AdminController::class, "displayAllUser", [AdminMustLoginMiddleware::class]);


Router::add("GET", "/admin/add-products", ProductsController::class, "addProducts", [AdminMustLoginMiddleware::class]);
Router::add("POST", "/admin/add-products", ProductsController::class, "postAddProducts", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/products", ProductsController::class, "products", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/products/edit/([a-z0-9A-Z]+)", ProductsController::class, "editProducts", [AdminMustLoginMiddleware::class]);
Router::add("POST", "/admin/products/edit/([a-z0-9A-Z]+)", ProductsController::class, "postEditProducts", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/products/delete/([a-z0-9A-Z]+)", ProductsController::class, "deleteProducts", [AdminMustLoginMiddleware::class]);

Router::add("GET", "/products/([a-z0-9A-Z]+)", ProductsController::class, "detailProducts");
Router::add("POST", "/products/([a-z0-9A-Z]+)", CartController::class, "addToCart");

Router::add("GET", "/user/login", UserController::class, "login", [UserMustNotLoginMiddleware::class]);
Router::add("POST", "/user/login", UserController::class, "postLogin", [UserMustNotLoginMiddleware::class]);
Router::add("GET", "/user/register", UserController::class, "register", [UserMustNotLoginMiddleware::class]);
Router::add("POST", "/user/register", UserController::class, "postRegister", [UserMustNotLoginMiddleware::class]);
Router::add("GET", "/user/profile", UserController::class, "updateProfile", [UserMustLoginMiddleware::class]);
Router::add("POST", "/user/profile", UserController::class, "postUpdateProfile", [UserMustLoginMiddleware::class]);
Router::add("GET", "/user/password", UserController::class, "updatePassword", [UserMustLoginMiddleware::class]);
Router::add("POST", "/user/password", UserController::class, "postUpdatePassword", [UserMustLoginMiddleware::class]);
Router::add("GET", "/user/logout", UserController::class, "logout", [UserMustLoginMiddleware::class]);


Router::add("GET", "/user/cart", CartController::class, "displayCart", [UserMustLoginMiddleware::class]);
Router::add("GET", "/user/cart/delete/([a-z0-9A-Z]+)", CartController::class, "deleteCartById", [UserMustLoginMiddleware::class]);
Router::add("POST", "/user/cart", TransactionsController::class, "makeTransactions", [UserMustLoginMiddleware::class]);
Router::add("GET", "/admin/transactions", TransactionsController::class, "transactions", [AdminMustLoginMiddleware::class]);
Router::add("POST", "/admin/transactions", TransactionsController::class, "postTransactionsByDate", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/admin/statistics", TransactionsController::class, "transactionStatistics", [AdminMustLoginMiddleware::class]);
Router::add("POST", "/admin/statistics", TransactionsController::class, "postStatisticsByDate", [AdminMustLoginMiddleware::class]);
Router::add("GET", "/user/statistics", TransactionsController::class, "transactionStatisticsUser", [UserMustLoginMiddleware::class]);
Router::add("POST", "/user/statistics", TransactionsController::class, "updateStatusUserTransaction", [UserMustLoginMiddleware::class]);
Router::add("GET", "/admin/transactions/([a-z0-9A-Z]+)", TransactionsController::class, "displayDetail", [AdminMustLoginMiddleware::class]);
Router::add("POST", "/admin/transactions/([a-z0-9A-Z]+)", TransactionsController::class, "updateStatusTransaction", [AdminMustLoginMiddleware::class]);

// Router::add("GET", "/active-article", ArticleController::class, "activeArticle", [AdminMustLoginMiddleware::class]);
// Router::add("POST", "/active-article", ArticleController::class, "postActiveArticle", [AdminMustLoginMiddleware::class]);
// Router::add("GET", "/deactive-article", ArticleController::class, "deactiveArticle", [AdminMustLoginMiddleware::class]);
// Router::add("POST", "/deactive-article", ArticleController::class, "postDeactiveArticle", [AdminMustLoginMiddleware::class]);
// Router::add("GET", "/article/([a-zA-Z]+)/([a-z0-9A-Z]+)", ArticleController::class, "viewArticle");
// Router::add("GET", "/post-article", ArticleController::class, "postingArticle", [AdminMustLoginMiddleware::class]);
// Router::add("POST", "/post-article", ArticleController::class, "postPostingArticle", [AdminMustLoginMiddleware::class]);
// Router::add("GET", "/article/([a-zA-Z]+)", ArticleController::class, "articleByCategory");
// Router::add("GET", "/edit-article/([a-z0-9A-Z]+)", ArticleController::class, "editArticle", [AdminMustLoginMiddleware::class]);
// Router::add("POST", "/edit-article/([a-z0-9A-Z]+)", ArticleController::class, "postEditArticle", [AdminMustLoginMiddleware::class]);


// Router::add("POST", "/", SuggestionsController::class, "postAddSuggestion");
// Router::add("GET", "/suggestions", SuggestionsController::class, "suggestions", [AdminMustLoginMiddleware::class]);
// Router::add("POST", "/suggestions", SuggestionsController::class, "postSuggestions", [AdminMustLoginMiddleware::class]);


// Router::add("GET", "/admin", AdminHomeController::class, "index", [AdminMustLoginMiddleware::class]);
// Router::add("GET", "/admin/login", AdminController::class, "login", [AdminMustNotLoginMiddleware::class]);
// Router::add("POST", "/admin/login", AdminController::class, "postLogin", [AdminMustNotLoginMiddleware::class]);
// Router::add("GET", "/admin/logout", AdminController::class, "logout", [AdminMustLoginMiddleware::class]);
// Router::add("GET", "/admin/profile", AdminController::class, "profileUpdate", [AdminMustLoginMiddleware::class]);
// Router::add("POST", "/admin/profile", AdminController::class, "postProfileUpdate", [AdminMustLoginMiddleware::class]);
// Router::add("GET", "/admin/password", AdminController::class, "passwordUpdate", [AdminMustLoginMiddleware::class]);
// Router::add("POST", "/admin/password", AdminController::class, "postPasswordUpdate", [AdminMustLoginMiddleware::class]);
// Router::add("GET", "/admin/register", AdminController::class, "register", [AdminMustLoginMiddleware::class]);
// Router::add("POST", "/admin/register", AdminController::class, "postRegister", [AdminMustLoginMiddleware::class]);
// Router::add("GET", "/admin/admin-account", AdminController::class, "adminAccount", [AdminMustLoginMiddleware::class]);

// Router::add("GET", "/user", UserHomeController::class, "index", [UserMustLoginMiddleware::class]);
// Router::add("GET", "/user/register", UsersController::class, "register", [UserMustNotLoginMiddleware::class]);
// Router::add("POST", "/user/register", UsersController::class, "postRegister", [UserMustNotLoginMiddleware::class]);
// Router::add("GET", "/user/login", UsersController::class, "login", [UserMustNotLoginMiddleware::class]);
// Router::add("POST", "/user/login", UsersController::class, "postLogin", [UserMustNotLoginMiddleware::class]);
// Router::add("GET", "/user/password", UsersController::class, "passwordUpdate", [UserMustLoginMiddleware::class]);
// Router::add("POST", "/user/password", UsersController::class, "postPasswordUpdate", [UserMustLoginMiddleware::class]);
// Router::add("GET", "/user/logout", UsersController::class, "logout", [UserMustLoginMiddleware::class]);
// Router::add("GET", "/user/profile", UsersController::class, "profile", [UserMustLoginMiddleware::class]);
// Router::add("POST", "/user/profile", UsersController::class, "postProfile", [UserMustLoginMiddleware::class]);

// Router::add("GET", "/user/diary", DiaryController::class, "diary", [UserMustLoginMiddleware::class]);
// Router::add("GET", "/user/diary/([a-zA-Z0-9_.%+-]+@[a-zA-Z0-9.-]+)/([a-z0-9A-Z]+)", DiaryController::class, "viewDiary", [UserMustLoginMiddleware::class]);
// Router::add("GET", "/user/post-diary", DiaryController::class, "addDiary", [UserMustLoginMiddleware::class]);
// Router::add("POST", "/user/post-diary", DiaryController::class, "postAddDiary", [UserMustLoginMiddleware::class]);
// Router::add("GET", "/user/edit-diary/([a-zA-Z0-9_.%+-]+@[a-zA-Z0-9.-]+)/([a-z0-9A-Z]+)", DiaryController::class, "updateDiary", [UserMustLoginMiddleware::class]);
// Router::add("POST", "/user/edit-diary/([a-zA-Z0-9_.%+-]+@[a-zA-Z0-9.-]+)/([a-z0-9A-Z]+)", DiaryController::class, "postUpdateDiary", [UserMustLoginMiddleware::class]);
// Router::add("POST", "/user/delete/([a-zA-Z0-9_.%+-]+@[a-zA-Z0-9.-]+)/([a-z0-9A-Z]+)", DiaryController::class, "deleteDiary", [UserMustLoginMiddleware::class]);
// Router::add("GET", "/user/delete/([a-zA-Z0-9_.%+-]+@[a-zA-Z0-9.-]+)/([a-z0-9A-Z]+)", DiaryController::class, "deleteDiary", [UserMustLoginMiddleware::class]);

// Router::add("GET", "/user/diary/([a-z0-9A-Z^\w!@£]+)/([a-z0-9A-Z]+)", DiaryController::class, "viewDiary", [UserMustLoginMiddleware::class]);

Router::run();


