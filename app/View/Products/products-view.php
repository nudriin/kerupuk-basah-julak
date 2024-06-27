<section x-data="{open : true}">
    <div class="container justify-center w-full p-4 py-20 mx-auto mb-12">
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
        <?php if (isset($model['error'])) { ?>
            <div x-show="open" class="flex flex-row items-center justify-between px-5 py-3 bg-red-600 rounded-md opacity-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <h1 class="text-lg text-white"><?= $model['error'] ?></h1>
                <button @click="open = !open" class="px-4 py-2 text-white border-2 rounded-full border-inherit">X</button>
            </div>
            <div class="flex items-center justify-center w-9/12 mx-auto">
                <img src="<?= getImage("vector/repair.jpg") ?>" alt="" class="object-cover object-center w-full h-full">
            </div>
        <?php } ?>
        <div class="w-9/12 mx-auto">
            <div class="grid grid-cols-12 shadow-lg">
                <?php if (isset($model['products']) && $model['products'] != null && !isset($model['error'])) { ?>
                    <div class="col-span-12 lg:col-span-5">
                        <img src="<?= getUploadedImg("products/" . $model['products']->images) ?? 'https://dummyimage.com/600x400/f4f4f4/000000' ?>" alt="" class="object-cover object-center w-full h-72">
                    </div>
                    <div class="flex flex-col col-span-12 gap-4 p-6 lg:col-span-7">
                        <div class="flex flex-col gap-2">
                            <h1 class="text-2xl font-medium font-rubik"><?= $model['products']->name ?></h1>
                            <p class="text-sm opacity-50">SKU : <?= $model['products']->id ?></p>
                            <p class="text-2xl">Rp. <?= $model['products']->price ?></p>
                            <p class="text-sm">Stok : <?= $model['products']->quantity ?></p>
                        </div>
                        <div class="flex gap-2">
                            <form action="/products/<?= $model['products']->id ?>" method="post">
                                <input type="hidden" name="products_id" value="<?= $model['products']->id ?>">
                                <input type="number" value="1" class="w-12 h-12 text-center border-2 rounded-lg border-abu" name="quantity" min="1" max="<?= $model['products']->quantity ?>">
                                <button type="submit" class="px-4 py-2 rounded-lg bg-merah text-dark-white">Masukan ke keranjang</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>