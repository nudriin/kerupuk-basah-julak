<section x-data="{open : true}">
    <div class="container items-center justify-center px-4 py-4 mx-auto mt-12 lg:px-20 lg:py-28 lg:mt-0">
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
            <div class="w-full mx-auto lg:w-9/12">
                <div x-show="open" class="flex flex-row items-center justify-between px-5 py-3 bg-red-600 rounded-md opacity-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                    <h1 class="text-lg text-white"><?= $model['error'] ?></h1>
                    <button @click="open = !open" class="px-4 py-2 text-white border-2 rounded-full border-inherit">X</button>
                </div>
            </div>
        <?php } ?>
        <div class="p-4">
            <div class="mb-5">
                <h1 class="text-4xl font-medium text-center font-rubik">Ganti password</h1>
            </div>
            <div class="w-full mx-auto bg-white rounded-lg shadow-xl lg:w-9/12">
                <form action="/admin/password" method="post" class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1 px-4 mt-4">
                        <label for="" class="text-xl font-semibold">Email</label>
                        <input type="text" name="email" class="p-2 border-2 rounded-lg border-abu" value="<?= $model['admin']->email ?>" disabled>
                    </div>
                    <div class="flex flex-col gap-1 px-4">
                        <label for="" class="text-xl font-semibold">Password lama</label>
                        <input type="password" name="old_password" class="p-2 border-2 rounded-lg border-abu">
                    </div>
                    <div class="flex flex-col gap-1 px-4">
                        <label for="" class="text-xl font-semibold">Password baru</label>
                        <input type="password" name="new_password" class="p-2 border-2 rounded-lg border-abu">
                    </div>
                    <div class="flex items-center justify-center px-4 mt-4 mb-4">
                        <button type="submit" class="w-full p-2 text-xl font-semibold text-center rounded-lg text-dark-white bg-merah" onclick="alert('Anda yakin ingin mengubah password')">Ganti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>