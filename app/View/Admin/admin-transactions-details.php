<section x-data="{open : false}">
    <div class="container justify-center w-full p-4 mx-auto mb-12">
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
        <div class="flex items-center justify-center w-9/12 mx-auto">
            <h1 class="mt-12 text-4xl font-medium font-rubik">
                Detail pesanan
            </h1>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20 mx-auto my-12 text-merah">
            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 004.25 22.5h15.5a1.875 1.875 0 001.865-2.071l-1.263-12a1.875 1.875 0 00-1.865-1.679H16.5V6a4.5 4.5 0 10-9 0zM12 3a3 3 0 00-3 3v.75h6V6a3 3 0 00-3-3zm-3 8.25a3 3 0 106 0v-.75a.75.75 0 011.5 0v.75a4.5 4.5 0 11-9 0v-.75a.75.75 0 011.5 0v.75z" clip-rule="evenodd" />
        </svg>
        <div class="w-9/12 mx-auto">
            <?php if (isset($model['detail_transactions']) && $model['detail_transactions'] != null  && !isset($model['error'])) { ?>

                <div class="flex flex-wrap justify-center -m-4">
                    <!-- card -->
                    <?php $email = null;
                    $nama = null;
                    $totalHarga = null;
                    $tanggal = null;
                    $payment_confirm = null;
                    $status = null;
                    $id = null;
                    $products = []; ?>
                    <?php foreach ($model['detail_transactions'] as $row) { ?>
                        <?php
                        $id = $row['tr_id'];
                        $status = $row['status'];
                        $email = $row['email'];
                        $nama = $row['user_name'];
                        $totalHarga = $row['total_price'];
                        $tanggal = $row['transaction_time'];
                        $payment_confirm = $row['payment_confirm'];
                        $products[] = $row['products_name'] ?>
                    <?php } ?>
                    <div class="relative w-full p-4">
                        <div class="h-full p-6 space-y-3 overflow-hidden rounded-lg shadow-lg">
                            <h1 class="mb-4 text-md">Order Id : <span class=""><?= $id ?></span></h1>
                            <h1 class="text-md">Email : <span class=""><?= $email ?></span></h1>
                            <h1 class="text-md">Nama : <span class=""><?= $nama ?></span></h1>
                            <h1 class="mb-4 text-md">Tanggal : <span class=""><?= $tanggal ?></span></h1>
                            <form action="/admin/transactions/<?= $id ?>" method="post">
                                <input type="hidden" name="order_id" value="<?= $id ?>">
                                <label for="">Status</label>
                                <div>
                                    <select name="status" id="" class="p-2 border-2 rounded-lg border-abu" onchange="this.form.submit()">
                                        <option value="<?= $status ?>" selected disabled><?= $status ?></option>
                                        <option value="Menunggu">Menunggu</option>
                                        <option value="Diproses">Diproses</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>
                            </form>
                            <h1 class="mb-4 text-md">Bukti Pembayaran : <button class="underline hover:cursor-pointer text-biru" @click="open = !open">Lihat</button></h1>
                            <div x-show="open" class="w-full">
                                <div class="h-full mx-auto overflow-hidden text-center duration-200">
                                    <div class="p-4">
                                        <img src="<?= getUploadedImg("payment/{$payment_confirm}") ?>" class="object-cover object-center rounded-lg" alt="" style="height: 500px;">
                                    </div>
                                </div>
                            </div>
                            <table class="w-full mt-8 mb-8 overflow-x-scroll text-sm text-left text-gray-500 rtl:text-right bg-merah">
                                <thead class="text-xs uppercase bg-gray-700 text-dark-white dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($model['detail_transactions'] as $row) { ?>
                                        <tr class="border-b bg-dark-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?= $row['products_name'] ?>
                                            </th>
                                            <td class="px-6 py-4">
                                                <?= $row['quantity'] ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                Rp. <?= $row['price'] ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                Rp. <?= $total = $row['price'] * $row['quantity'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <h1 class="mt-4 text-center text-md">Total Harga : <span class="font-semibold text-merah">Rp. <?= $totalHarga ?></span></h1>
                        </div>
                    </div>
                </div>
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
    </div>
</section>