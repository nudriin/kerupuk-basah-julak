<section x-data="{open : true}">
    <div class="container mx-auto px-4 py-4 lg:px-20 lg:py-28 items-center justify-center mt-12">
        <?php if (isset($model['error'])) { ?>
            <div class="w-full lg:w-9/12 mx-auto">
                <div x-show="open" class="flex flex-row bg-red-600 rounded-md opacity-50 py-3 px-5 items-center justify-between" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                    <h1 class="text-white text-lg"><?= $model['error'] ?></h1>
                    <button @click="open = !open" class="border-2 border-inherit text-white py-2 px-4 rounded-full">X</button>
                </div>
            </div>
        <?php } ?>
        <div class="p-4">
            <h1 class="font-rubik font-medium text-4xl text-center mb-5">Login</h1>
            <div class="rounded-lg w-full md:w-9/12 lg:w-1/3 mx-auto bg-white shadow-xl">
                <form action="/user/login" method="post" class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1 px-4 mt-4">
                        <label for="" class="text-xl font-semibold">Email</label>
                        <input type="text" name="email" class="border-2 border-abu rounded-lg p-2">
                    </div>
                    <div class="flex flex-col gap-1 px-4">
                        <label for="" class="text-xl font-semibold">Password</label>
                        <input type="password" name="password" class="border-2 border-abu rounded-lg p-2">
                    </div>
                    <div class="flex items-center justify-center mb-4 px-4 mt-4">
                        <button type="submit" class="font-semibold text-dark-white text-center bg-merah rounded-lg text-xl w-full p-2">Sign
                            in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>