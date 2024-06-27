<?php
require_once __DIR__ . "/../Helper/ImageHelper.php";
require_once __DIR__ . "/../Helper/RegexHelper.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $model['title'] ?>
    </title>
    <link rel="stylesheet" href="http://localhost/css/styles.css">
    <link rel="icon" type="image/x-icon" href="http://localhost/Template/img/logo/HeroLogo1.png">
    <!-- <link rel="stylesheet" href="http://1291-114-10-143-235.ngrok-free.app/css/styles.css"> -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@500&family=Lilita+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Secular+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,700;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap');
    </style>
    <!-- Alpine js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="text-abu font-poppins" x-data="{profileOpen : false}">
    <!-- Navigation -->
    <nav x-data="{navOpen : false}" class="px-4 py-5">
        <div class="fixed top-0 left-0 right-0 z-50 items-center justify-center px-4 py-4 mx-auto bg-white shadow-md">
            <div class="container mx-auto lg:px-20">
                <div class="flex items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 lg:hidden sm:order-3 text-merah" @click="navOpen = !navOpen">
                        <path fill-rule="evenodd" d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                    </svg>
                    <!-- <img src="<?= getImage('toggle.svg') ?>"> -->
                    <div class="flex items-center gap-3">
                        <a href="/" class="font-rubik text-merah sm:order-2">KerupukBasahJulak</a>
                        <img src="<?= getImage("logo/HeroLogo1.png") ?>" class="object-cover object-center w-8 h-8 rounded-full sm:order-1">
                    </div>
                    <div class="items-center hidden mb-2 lg:block">
                        <ul class="flex flex-row items-center gap-5 mt-2 text-merah">
                            <li><a href="/admin">Dashboard</a></li>
                            <li><a href="/admin/transactions">Pesanan</a></li>
                            <li><a href="/admin/products">Produk</a></li>
                            <li><a href="/admin/add-products">Tambah produk</a></li>
                            <li><a href="/admin/user-list">User</a></li>
                            <li><a href="/admin/statistics">Laporan</a></li>
                        </ul>
                    </div>
                    <div class="hidden lg:block" @click="profileOpen = !profileOpen">
                        <div class="flex items-center justify-center">
                            <img src="<?= getUploadedImg("profile/" . $model['admin_profile']) ?>" alt="" class="object-cover object-center w-12 h-12 mr-8 border-2 rounded-full border-abu">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
            <!-- mobile navigation -->
            <!-- z index buat fixed bottom -->
            <div class="fixed top-0 left-0 z-50 w-64 h-screen duration-200 transform -translate-x-full lg:hidden" :class="{'translate-x-0' : navOpen === true, '-translate-x-full' : navOpen === false}">
                <div class="h-full px-4 py-4 bg-dark-white">
                    <div class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center rounded-xl font-rubik">
                        <span class="flex-1 font-medium text-left font-rubik text-md text-merah">Kerupuk Basah
                            Julak</span>
                        <button type="button" class="p-2 rounded-md focus:outline-none focus:bg-merah hover:bg-merah hover:text-dark-white" @click="navOpen = false">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </button>
                    </div>
                    <ul class="py-4 space-y-3">
                        <li class="border-2 border-abu rounded-xl">
                            <a href="/" class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center group rounded-xl font-rubik hover:bg-merah hover:text-dark-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                                </svg>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li class="border-2 border-abu rounded-xl">
                            <a href="/admin" class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center group rounded-xl font-rubik hover:bg-merah hover:text-dark-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M12 9a1 1 0 01-1-1V3c0-.553.45-1.008.997-.93a7.004 7.004 0 015.933 5.933c.078.547-.378.997-.93.997h-5z" />
                                    <path d="M8.003 4.07C8.55 3.992 9 4.447 9 5v5a1 1 0 001 1h5c.552 0 1.008.45.93.997A7.001 7.001 0 012 11a7.002 7.002 0 016.003-6.93z" />
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="border-2 border-abu rounded-xl">
                            <a href="/admin/transactions" class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center group rounded-xl font-rubik hover:bg-merah hover:text-dark-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M2.879 7.121A3 3 0 007.5 6.66a2.997 2.997 0 002.5 1.34 2.997 2.997 0 002.5-1.34 3 3 0 104.622-3.78l-.293-.293A2 2 0 0015.415 2H4.585a2 2 0 00-1.414.586l-.292.292a3 3 0 000 4.243zM3 9.032a4.507 4.507 0 004.5-.29A4.48 4.48 0 0010 9.5a4.48 4.48 0 002.5-.758 4.507 4.507 0 004.5.29V16.5h.25a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75v-3.5a.75.75 0 00-.75-.75h-2.5a.75.75 0 00-.75.75v3.5a.75.75 0 01-.75.75h-4.5a.75.75 0 010-1.5H3V9.032z" />
                                </svg>
                                <span>Pesanan</span>
                            </a>
                        </li>
                        <li class="border-2 border-abu rounded-xl">
                            <a href="/admin/products" class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center group rounded-xl font-rubik hover:bg-merah hover:text-dark-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M6 5v1H4.667a1.75 1.75 0 00-1.743 1.598l-.826 9.5A1.75 1.75 0 003.84 19H16.16a1.75 1.75 0 001.743-1.902l-.826-9.5A1.75 1.75 0 0015.333 6H14V5a4 4 0 00-8 0zm4-2.5A2.5 2.5 0 007.5 5v1h5V5A2.5 2.5 0 0010 2.5zM7.5 10a2.5 2.5 0 005 0V8.75a.75.75 0 011.5 0V10a4 4 0 01-8 0V8.75a.75.75 0 011.5 0V10z" clip-rule="evenodd" />
                                </svg>
                                <span>Produk</span>
                            </a>
                        </li>
                        <li class="border-2 border-abu rounded-xl">
                            <a href="/admin/profile" class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center group rounded-xl font-rubik hover:bg-merah hover:text-dark-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" />
                                </svg>
                                <span>Profil</span>
                            </a>
                        </li>
                        <li class="border-2 border-abu rounded-xl">
                            <a href="/admin/account" class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center group rounded-xl font-rubik hover:bg-merah hover:text-dark-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                </svg>
                                <span>Admin</span>
                            </a>
                        </li>
                        <li class="border-2 border-abu rounded-xl">
                            <a href="/admin/register" class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center group rounded-xl font-rubik hover:bg-merah hover:text-dark-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M11 5a3 3 0 11-6 0 3 3 0 016 0zM2.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 018 18a9.953 9.953 0 01-5.385-1.572zM16.25 5.75a.75.75 0 00-1.5 0v2h-2a.75.75 0 000 1.5h2v2a.75.75 0 001.5 0v-2h2a.75.75 0 000-1.5h-2v-2z" />
                                </svg>

                                <span>Tambah admin</span>
                            </a>
                        </li>
                        <li class="border-2 border-abu rounded-xl">
                            <a href="/admin/statistics" class="flex items-center w-full px-3 py-2 space-x-2 font-medium text-center group rounded-xl font-rubik hover:bg-merah hover:text-dark-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Laporan bulanan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <style>
        .profileDropdown {
            position: fixed;
            top: 2;
            right: 0;
            z-index: 50;
            width: 300px;
            margin-top: 45px;
            margin-right: 20px;
            background-color: #EEEFFF;
            border-radius: 12px;
            padding: 16px;
            border: 2px solid #262433;
        }
    </style>
    <div class="profileDropdown" x-show="profileOpen">
        <div class="grid grid-cols-4 gap-2">
            <div class="col-span-2">
                <a href="/admin/profile">
                    <div class="flex items-center justify-center p-2 font-semibold text-center bg-merah rounded-xl text-dark-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="col-span-2 ">
                <a href="/admin/password">
                    <div class="flex items-center justify-center p-2 font-semibold text-center bg-merah rounded-xl text-dark-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M8 7a5 5 0 113.61 4.804l-1.903 1.903A1 1 0 019 14H8v1a1 1 0 01-1 1H6v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-2a1 1 0 01.293-.707L8.196 8.39A5.002 5.002 0 018 7zm5-3a.75.75 0 000 1.5A1.5 1.5 0 0114.5 7 .75.75 0 0016 7a3 3 0 00-3-3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="col-span-2">
                <a href="/admin/account">
                    <div class="flex items-center justify-center p-2 font-semibold text-center bg-merah rounded-xl text-dark-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                            <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="col-span-2">
                <a href="/admin/register">
                    <div class="flex items-center justify-center p-2 font-semibold text-center bg-merah rounded-xl text-dark-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                            <path d="M11 5a3 3 0 11-6 0 3 3 0 016 0zM2.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 018 18a9.953 9.953 0 01-5.385-1.572zM16.25 5.75a.75.75 0 00-1.5 0v2h-2a.75.75 0 000 1.5h2v2a.75.75 0 001.5 0v-2h2a.75.75 0 000-1.5h-2v-2z" />
                        </svg>

                    </div>
                </a>
            </div>
            <div class="col-span-4">
                <a href="/admin/logout">
                    <div class="p-2 font-semibold text-center bg-merah rounded-xl text-dark-white">
                        logout
                    </div>
                </a>
            </div>
        </div>
    </div>