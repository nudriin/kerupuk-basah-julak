<section>
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
                Pesanan
            </h1>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20 mx-auto my-12 text-merah">
            <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 004.25 22.5h15.5a1.875 1.875 0 001.865-2.071l-1.263-12a1.875 1.875 0 00-1.865-1.679H16.5V6a4.5 4.5 0 10-9 0zM12 3a3 3 0 00-3 3v.75h6V6a3 3 0 00-3-3zm-3 8.25a3 3 0 106 0v-.75a.75.75 0 011.5 0v.75a4.5 4.5 0 11-9 0v-.75a.75.75 0 011.5 0v.75z" clip-rule="evenodd" />
        </svg>
        <div class="w-9/12 mx-auto">
            <div>
                <form action="/admin/transactions" method="post" class="flex items-end gap-2 mb-4">
                    <div class="flex flex-col">
                        <label for="" class="font-rubik">Dari tanggal</label>
                        <input type="date" name="start_date" class="p-2 border-2 rounded-lg border-abu" required>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="font-rubik">Sampai tanggal</label>
                        <input type="date" name="end_date" class="p-2 border-2 rounded-lg border-abu" required>
                    </div>
                    <div>
                        <button type="submit" class="p-2 text-white rounded-lg font-rubik bg-merah">Filter</button>
                    </div>
                </form>
            </div>
            <?php if (isset($model['transactions']) && $model['transactions'] != null  && !isset($model['error'])) { ?>
                <div class="flex flex-wrap justify-center -m-4">
                    <!-- card -->
                    <?php foreach ($model['transactions'] as $row) { ?>
                        <div class="relative w-full p-4 sm:w-1/2 md:1/3">
                            <a href="/admin/transactions/<?= $row['tr_id'] ?>">
                                <div class="h-full p-6 space-y-3 overflow-hidden rounded-lg shadow-lg hover:bg-merah hover:text-dark-white">
                                    <h1 class="text-xl">Id pesanan : <span class="font-semibold"><?= $row['tr_id'] ?></span></h1>
                                    <h1 class="text-xl">Email : <span class="font-semibold"><?= $row['email'] ?></span></h1>
                                    <!-- <h1 class="text-xl">Nama : <span class="font-semibold"><?= $row['user_name'] ?></span></h1> -->
                                    <!-- <h1 class="text-xl">Alamat : <span class="font-semibold">JL. Yos Soedarso</span></h1> -->
                                    <!-- <h1 class="text-xl">Produk : <span class="font-semibold"><?= $row['products_name'] ?></span></h1> -->
                                    <!-- <h1 class="text-xl">Total Harga : <span class="font-semibold"><?= $row['total_price'] ?></span></h1> -->
                                    <h1 class="text-xl">Tanggal : <span class="font-semibold"><?= $row['transaction_time'] ?></span></h1>
                                    <!-- <h1 class="text-xl">Metode pembayaran : <span class="font-semibold">Cash on delivery (COD)</span></h1>
                                    <h1 class="text-xl">Status : <span class="font-semibold">Menunggu pembayaran</span></h1> -->
                                </div>
                            </a>
                        </div>
                    <?php } ?>
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