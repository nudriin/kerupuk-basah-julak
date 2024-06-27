    <!-- HEro section -->
    <section class="py-20 bg-merah">
        <div class="relative w-full h-full">
            <!-- <div class="absolute bottom-0 left-0" style="z-index: 0;">
                <img src="<?= getImage("bg/Bottom-hero.png") ?>" class="" alt="">
            </div> -->
            <div class="container w-9/12 px-4 py-4 mx-auto my-auto">
                <div class="grid items-center justify-center grid-cols-12">
                    <div class="items-center justify-center order-2 w-full col-span-12 mt-20 lg:col-span-6 lg:order-1">
                        <h1 class="mb-4 font-rubik font-medium text-[38px] md:text-[54px] leading-tight text-center lg:text-left text-dark-white">
                            Tempat terbaik untuk
                            menemukan kerupuk basah
                            asli dari tempat asalnya
                        </h1>
                        <p class="mt-4 mb-4 text-center lg:text-left text-dark-white">Kerupuk basah julak menyediakan
                            kerupuk basah yang di dibawa langsung dari daerah asalnya, yaitu sukamara.</p>
                        <div class="flex flex-col justify-center" style="z-index: 20;">
                            <button class="py-4 mb-12 font-semibold rounded-lg px-9 bg-dark-white text-merah"><a href="/shop">Mulai belanja</a></button>
                        </div>
                    </div>
                    <div class="order-1 col-span-12 mt-12 lg:col-span-6 lg:order-2">
                        <div class="flex items-center justify-center">
                            <img src="<?= getImage("logo/HeroLogo1.png") ?>" alt="" class="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk terlaris -->
    <section class="py-20">
        <div class="container justify-center w-full p-4 mx-auto mb-12">
            <div class="flex items-center justify-center w-9/12 mx-auto">
                <h1 class="mt-12 text-4xl font-medium font-rubik">
                    Produk kami
                </h1>
            </div>
            <div class="w-9/12 mx-auto">
                <?php if (isset($model['products']) && $model['products'] != null  && !isset($model['error'])) { ?>
                    <div class="flex flex-wrap justify-center mt-4 -m-4">
                        <?php if (sizeof($model['products']) >= 3) { ?>
                            <?php for ($i = 0; $i < 3; $i++) { ?>
                                <!-- card -->
                                <div class="w-full p-4 space-y-2 sm:w-1/2 md:1/3">
                                    <a href="/products/<?= $model['products'][$i]['id'] ?>">
                                        <div class="h-full overflow-hidden rounded-lg shadow-lg">
                                            <img src="<?= getUploadedImg("products/" . $model['products'][$i]['images']) ?? 'https://dummyimage.com/600x400/f4f4f4/000000' ?>" alt="" class="object-cover object-center w-full h-48">
                                            <div class="p-6 transition duration-200 ease-in hover:bg-merah hover:text-white">
                                                <h1 class="text-xl font-semibold"><?= $model['products'][$i]['name'] ?></h1>
                                                <p><?= $model['products'][$i]['price'] ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } else if (sizeof($model['products']) >= 2) { ?>
                            <?php for ($i = 0; $i < 2; $i++) { ?>
                                <div class="w-full p-4 space-y-2 sm:w-1/2 md:1/3">
                                    <a href="/products/<?= $model['products'][$i]['id'] ?>">
                                        <div class="h-full overflow-hidden rounded-lg shadow-lg">
                                            <img src="<?= getUploadedImg("products/" . $model['products'][$i]['images']) ?? 'https://dummyimage.com/600x400/f4f4f4/000000' ?>" alt="" class="object-cover object-center w-full h-48">
                                            <div class="p-6 transition duration-200 ease-in hover:bg-merah hover:text-white">
                                                <h1 class="text-xl font-semibold"><?= $model['products'][$i]['name'] ?></h1>
                                                <p><?= $model['products'][$i]['price'] ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php }  ?>
                        <?php } else if (sizeof($model['products']) >= 1) { ?>
                            <?php for ($i = 0; $i < 1; $i++) { ?>
                                <div class="w-full p-4 space-y-2 sm:w-1/2 md:1/3">
                                    <a href="/products/<?= $model['products'][$i]['id'] ?>">
                                        <div class="h-full overflow-hidden rounded-lg shadow-lg">
                                            <img src="<?= getUploadedImg("products/" . $model['products'][$i]['images']) ?? 'https://dummyimage.com/600x400/f4f4f4/000000' ?>" alt="" class="object-cover object-center w-full h-48">
                                            <div class="p-6 transition duration-200 ease-in hover:bg-merah hover:text-white">
                                                <h1 class="text-xl font-semibold"><?= $model['products'][$i]['name'] ?></h1>
                                                <p>Rp. <?= $model['products'][$i]['price'] ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php }  ?>
                        <?php }  ?>
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
    </section>

    <section class="relative py-20 bg-merah">
        <div class="container w-9/12 px-4 py-4 mx-auto lg:px-20 lg:py-28">
            <div class="grid items-center justify-center grid-cols-12 gap-5">
                <!-- Gmabar -->
                <div class="col-span-12 lg:col-span-7">
                    <div class="flex items-center justify-center">
                        <img src="<?= getImage("logo/HeroLogo1.png") ?>" alt="">
                    </div>
                </div>

                <!-- about us -->
                <div class="items-center justify-center col-span-12 lg:col-span-5 text-dark-white">
                    <h1 class="mt-4 mb-4 text-4xl font-medium text-center font-rubik">Tentang kami</h1>
                    <p class="mt-4"><span class="font-medium font-rubik">Kerupuk Basah Julak</span> adalah sebuah usaha
                        UMKM yang bergerak di bidang f&b, produk kami ialah kerupuku basah yang merupakan makanan khas
                        daerah kabupaten sukamara. usaha kami sudah berdiri sejak 2 tahun yang lalu, yaitu sejak tahun
                        2021. Visi kami dalam menjalan usaha ini adalah untuk mensejahterakan perekonomian keluarga
                        kami, serta memperkenalkan makanan khas kabupaten sukamara ke daerah daerah lainnya.</p>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 z-0">
            <img src="<?= getImage("bg/Bottom-hero.png") ?>" class="" alt="">
        </div>
    </section>