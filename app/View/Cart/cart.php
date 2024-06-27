<!-- Keranjang -->
<section>
    <div class="container justify-center w-full p-4 mx-auto mb-12">
        <div class="flex items-center justify-center w-9/12 mx-auto">
            <h1 class="mt-12 text-4xl font-medium font-rubik">
                Keranjang
            </h1>
        </div>
        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-20 h-20 mx-auto my-12 text-merah">
            <path d="M1 1.75A.75.75 0 011.75 1h1.628a1.75 1.75 0 011.734 1.51L5.18 3a65.25 65.25 0 0113.36 1.412.75.75 0 01.58.875 48.645 48.645 0 01-1.618 6.2.75.75 0 01-.712.513H6a2.503 2.503 0 00-2.292 1.5H17.25a.75.75 0 010 1.5H2.76a.75.75 0 01-.748-.807 4.002 4.002 0 012.716-3.486L3.626 2.716a.25.25 0 00-.248-.216H1.75A.75.75 0 011 1.75zM6 17.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15.5 19a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
        </svg> -->
        <div class="w-9/12 mx-auto">
            <?php $totalPrice = 0; ?>
            <?php $totalProducts = 0; ?>
            <?php if (isset($model['cart']) && $model['cart'] != null  && !isset($model['error'])) { ?>
                <div class="flex flex-wrap justify-center mt-4 -m-4">
                    <?php foreach ($model['cart'] as $row) { ?>
                        <!-- card -->
                        <div class="relative w-full p-4 sm:w-1/2 md:1/3">
                            <a href="/products/<?= $row['products_id'] ?>">
                                <div class="h-full overflow-hidden rounded-lg shadow-lg">
                                    <img src="<?= getUploadedImg("products/" . $row['images']) ?>" alt="" class="object-cover object-center w-full h-48">
                                    <div class="p-6 transition duration-200 ease-in hover:bg-merah hover:text-white">
                                        <h1 class="text-xl font-semibold"><?= $row['products_name'] ?></h1>
                                        <p><?= $row['price'] ?></p>
                                        <p class="opacity-50">Jumlah : <?= $row['quantity'] ?></p>
                                        <?php $total = $row['price'] * $row['quantity'] ?>
                                        <p class="opacity-50">Total : <?= $total ?></p>
                                    </div>
                                </div>
                            </a>
                            <div class="absolute top-6 right-6">
                                <a onclick="return confirm('Anda yakin ingin menghapus produk ini? (<?= $row['products_name'] ?>)')" href="/user/cart/delete/<?= $row['cart_id'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 text-merah">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <?php $totalPrice += $total ?>
                        <?php $totalProducts += $row['quantity'] ?>
                    <?php } ?>
                </div>
                <div class="items-center justify-center w-full h-24 p-6 mx-auto mt-12 overflow-hidden border-2 rounded-lg shadow-lg border-abu lg:w-9/12">
                    <h1 class="font-medium text-center font-rubik">Total belanja : <span class="text-merah">Rp. <?= $totalPrice ?></span></h1>
                    <h1 class="text-center">Total produk : <span class=""><?= $totalProducts ?> produk</span></h1>
                    <form action="/user/cart" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
                        <h1 class="font-medium text-center font-rubik">Silahkan lakukan pembayaran</h1>
                        <h1 class="font-medium text-center">BRI : 4552 0102 9451 536 an Devina</h1>
                        <div class="flex flex-col items-center justify-center">
                            <input type="file" name="payment" class="overflow-hidden border-2 rounded-lg font-rubik text-abu border-abu file:bg-biru file:border-0 file:text-white file:font-rubik" required>
                        </div>
                        <button type="submit" class="w-full px-4 py-3 mt-4 font-semibold text-center rounded-lg bg-biru text-dark-white">
                            Checkout
                        </button>

                    </form>
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