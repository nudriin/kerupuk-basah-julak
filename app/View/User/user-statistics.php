<section>
    <div class="container mt-12">
        <div class="flex items-center justify-start w-9/12 mx-auto mt-12 mb-4">
            <button class="flex items-center gap-2" onclick="history.back()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8">
                    <g clip-path="url(#clip0_9_2121)">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.25-7.25a.75.75 0 000-1.5H8.66l2.1-1.95a.75.75 0 10-1.02-1.1l-3.5 3.25a.75.75 0 000 1.1l3.5 3.25a.75.75 0 001.02-1.1l-2.1-1.95h4.59z" clip-rule="evenodd" />
                    </g>
                    <defs>
                        <clipPath id="clip0_9_2121">
                            <path d="M0 0h20v20H0z" />
                        </clipPath>
                    </defs>
                </svg>
                <span class="">Kembali</span>
            </button>
        </div>
    </div>
    <div class="container relative w-9/12 p-4 py-20 mx-auto mt-12">
        <div class="flex items-center justify-center">
            <div class="w-3/4 lg:w-2/4">
                <h1 class="mb-4 text-4xl font-medium text-center font-rubik">Order history</h1>
            </div>
        </div>
        <div class="p-2 mx-auto mb-4 rounded-lg bg-dark-white">
            <div class="flex items-center justify-between px-6">
                <!-- <div>
                    <a href="">Semua</a>
                </div> -->
                <div>
                    <a href="/user/statistics?status=Menunggu">Menunggu</a>
                </div>
                <div>
                    <a href="/user/statistics?status=Diproses">Diproses</a>
                </div>
                <div>
                    <a href="/user/statistics?status=Selesai">Selesai</a>
                </div>
                <div>
                    <a href="/user/statistics?status=Ditolak">Ditolak</a>
                </div>
            </div>
        </div>
        <div class="sm:rounded-lg" style="overflow: auto;">
            <?php if (isset($model['transactions']) && $model['transactions'] != null  && !isset($model['error'])) { ?>
                <table class="w-full overflow-x-scroll text-sm text-left text-gray-500 rtl:text-right bg-dark-white">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Id pesanan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Produk
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Harga satuan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total harga
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($model['transactions'] as $row) { ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $row['tr_id'] ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?= $row['email'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $row['user_name'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $row['products_name'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $row['quantity'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $row['price'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $total = $row['price'] * $row['quantity'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $row['transaction_time'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($row['status'] == "Ditolak") { ?>
                                        <span class="text-merah"><?= $row['status'] ?></span>
                                    <?php } else if ($row['status'] == "Diproses") { ?>
                                        <span style="color: orange;"><?= $row['status'] ?></span>
                                        <form action="/user/statistics?status=Diproses" method="post">
                                            <input type="hidden" name="transaction_id" value="<?= $row['tr_id'] ?>">
                                            <button type="submit" name="status" value="Selesai" class="p-2 text-white rounded-lg hover:bg-biru bg-merah">Selesai</button>
                                        </form>
                                    <?php } else if ($row['status'] == "Selesai" || $row['status'] == "Diterima") { ?>
                                        <span style="color: green;"><?= $row['status'] ?></span>
                                    <?php } else { ?>
                                        <?= $row['status'] ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="flex flex-col items-center justify-center col-span-12">
                    <div class="w-full">
                        <h1 class="mt-4 mb-4 text-3xl text-center"><?= $model['error'] ?></h1>
                    </div>
                    <div class="flex items-center justify-center w-9/12 mx-auto">
                        <img src="<?= getImage("vector/noProducts.jpg") ?>" alt="" class="object-cover object-center w-full h-full">
                    </div>
                </div>
            <?php } ?>
        </div>
</section>