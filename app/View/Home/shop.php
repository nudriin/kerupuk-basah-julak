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
                Daftar Produk
            </h1>
        </div>
        <div class="w-9/12 mx-auto">
            <?php if (isset($model['products']) && $model['products'] != null  && !isset($model['error'])) { ?>
                <div class="flex flex-wrap justify-center mt-4 -m-4">
                    <?php foreach ($model['products'] as $row) { ?>
                        <!-- card -->
                        <div class="w-full p-4 space-y-2 sm:w-1/2 md:1/3">
                            <div class="h-full overflow-hidden rounded-lg shadow-lg">
                                <img src="<?= getUploadedImg("products/" . $row['images']) ?? 'https://dummyimage.com/600x400/f4f4f4/000000' ?>" alt="" class="object-cover object-center w-full h-48">
                                <div class="p-6 transition duration-200 ease-in hover:bg-merah hover:text-white">
                                    <a href="/products/<?= $row['id'] ?>">
                                        <h1 class="text-xl font-semibold"><?= $row['name'] ?></h1>
                                        <p class="mb-4">Rp. <?= $row['price'] ?></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <!-- <div class="flex items-center justify-start w-9/12 mx-auto">
                    <button onclick="history.back()">Kembali</button>
                </div> -->
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