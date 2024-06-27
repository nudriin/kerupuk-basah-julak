<section x-data="{open : true}">
    <div class="container px-4 py-4 mx-auto lg:px-20 lg:py-28">
        <div class="mt-12 lg:mt-0">
            <div class="flex items-center justify-center">
                <div class="w-3/4 lg:w-2/4">
                    <h1 class="mb-4 text-4xl font-medium text-center font-rubik">Dashboard</h1>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-20 h-20 mx-auto mb-12 text-merah">
                <path d="M12 9a1 1 0 01-1-1V3c0-.553.45-1.008.997-.93a7.004 7.004 0 015.933 5.933c.078.547-.378.997-.93.997h-5z" />
                <path d="M8.003 4.07C8.55 3.992 9 4.447 9 5v5a1 1 0 001 1h5c.552 0 1.008.45.93.997A7.001 7.001 0 012 11a7.002 7.002 0 016.003-6.93z" />
            </svg>

            <div class="flex flex-wrap -m-4">
                <!-- card -->
                <div class="w-full p-4 sm:w-1/3">
                    <div class="h-full overflow-hidden rounded-lg shadow-xl">
                        <div class="px-6 py-4">
                            <h1 class="text-2xl font-semibold text-center">Pesanan</h1>
                        </div>
                        <div class="px-6 py-4 space-y-2">
                            <div class="px-6 py-4 border-2 rounded-lg border-abu bg-dark-white">
                                <p class="text-xl font-medium text-center font-rubik"><?=$model['count_transactions']?></p>
                            </div>
                            <div>
                                <a href="/admin/transactions">
                                    <div class="px-6 py-4 text-white transition duration-200 ease-in rounded-lg bg-merah">
                                        <p class="text-xl font-medium text-center font-rubik">Lihat</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card -->
                <div class="w-full p-4 sm:w-1/3">
                    <div class="h-full overflow-hidden rounded-lg shadow-xl">
                        <div class="px-6 py-4">
                            <h1 class="text-2xl font-semibold text-center">Produk</h1>
                        </div>
                        <div class="px-6 py-4 space-y-2">
                            <div class="px-6 py-4 border-2 rounded-lg border-abu bg-dark-white">
                                <p class="text-xl font-medium text-center font-rubik"><?=$model['count_products']?></p>
                            </div>
                            <div>
                                <a href="/admin/products">
                                    <div class="px-6 py-4 text-white transition duration-200 ease-in rounded-lg  bg-merah">
                                        <p class="text-xl font-medium text-center font-rubik">Lihat</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card -->
                <div class="w-full p-4 sm:w-1/3">
                    <div class="h-full overflow-hidden rounded-lg shadow-xl">
                        <div class="px-6 py-4">
                            <h1 class="text-2xl font-semibold text-center">Profil</h1>
                        </div>
                        <div class="px-6 py-4 space-y-2">
                            <div class="px-6 py-4 border-2 rounded-lg border-abu bg-dark-white">
                                <p class="text-xl font-medium text-center font-rubik"><?=$model['admin']->name?></p>
                            </div>
                            <div>
                                <a href="/admin/profile">
                                    <div class="px-6 py-4 text-white transition duration-200 ease-in rounded-lg bg-merah">
                                        <p class="text-xl font-medium text-center font-rubik">Ubah</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card -->
                <div class="w-full p-4 sm:w-1/3">
                    <div class="h-full overflow-hidden rounded-lg shadow-xl">
                        <div class="px-6 py-4">
                            <h1 class="text-2xl font-semibold text-center">Admin</h1>
                        </div>
                        <div class="px-6 py-4 space-y-2">
                            <div class="px-6 py-4 border-2 rounded-lg border-abu bg-dark-white">
                                <p class="text-xl font-medium text-center font-rubik"><?=$model['count_admin']?></p>
                            </div>
                            <div>
                                <a href="/admin/account">
                                    <div class="px-6 py-4 text-white transition duration-200 ease-in rounded-lg bg-merah">
                                        <p class="text-xl font-medium text-center font-rubik">Lihat</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card -->
                <div class="w-full p-4 sm:w-1/3">
                    <div class="h-full overflow-hidden rounded-lg shadow-xl">
                        <div class="px-6 py-4">
                            <h1 class="text-2xl font-semibold text-center">Laporan</h1>
                        </div>
                        <div class="px-6 py-4 space-y-2">
                            <div class="px-6 py-4 border-2 rounded-lg border-abu bg-dark-white">
                                <p class="text-xl font-medium text-center font-rubik">laporan hari ini</p>
                            </div>
                            <div>
                                <a href="/admin/statistics">
                                    <div class="px-6 py-4 text-white transition duration-200 ease-in rounded-lg bg-merah">
                                        <p class="text-xl font-medium text-center font-rubik">Lihat</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>