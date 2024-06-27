    <!-- add product -->
    <section x-data="{open : true}">
        <div class="container pt-20 mt-12">
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
        <div class="container w-9/12 px-4 py-4 mx-auto mt-12 lg:px-20 lg:py-28 lg:mt-0">
            <?php if (isset($model['error'])) { ?>
                <div x-show="open" class="flex flex-row items-center justify-between px-5 py-3 bg-red-600 rounded-md opacity-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                    <h1 class="text-lg text-white"><?= $model['error'] ?></h1>
                    <button @click="open = !open" class="px-4 py-2 text-white border-2 rounded-full border-inherit">X</button>
                </div>
            <?php } ?>
            <div class="grid items-center grid-cols-12">
                <div class="items-center justify-center col-span-12">
                    <h1 class="font-rubik font-medium text-[38px] text-center mb-4">Edit produk</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20 mx-auto text-merah">
                        <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 004.25 22.5h15.5a1.875 1.875 0 001.865-2.071l-1.263-12a1.875 1.875 0 00-1.865-1.679H16.5V6a4.5 4.5 0 10-9 0zM12 3a3 3 0 00-3 3v.75h6V6a3 3 0 00-3-3zm-3 8.25a3 3 0 106 0v-.75a.75.75 0 011.5 0v.75a4.5 4.5 0 11-9 0v-.75a.75.75 0 011.5 0v.75z" clip-rule="evenodd" />
                    </svg>

                    <div class="relative w-full py-10">
                        <div class="h-full py-10 rounded-lg shadow-xl">
                            <form method="post" action="/admin/products/edit/<?= $model['products']->id ?>" enctype="multipart/form-data">
                                <div class="flex flex-col w-9/12 gap-2 mx-auto">
                                    <label for="judul" class="font-semibold">Nama produk</label>
                                    <input type="text" name="products_name" class="px-4 py-2 rounded-md font-rubik bg-dark-white" required placeholder="Nama produk" value="<?= $model['products']->name ?>">
                                </div>
                                <div class="flex flex-col w-9/12 gap-2 mx-auto">
                                    <img src="<?= getUploadedImg("products/" . $model['products']->images) ?>" alt="" id="profile_img" class="object-cover object-center w-full h-64">
                                    <label class="block mt-4 font-semibold text-abu produk" for="file_input">Gambar</label>
                                    <input id="file_input" class="block w-full rounded-md font-rubik text-abu bg-dark-white file:bg-merah file:text-dark-white file:rounded-lg" name="products_images" type="file" required>
                                </div>
                                <div class="flex flex-col w-9/12 gap-2 mx-auto">
                                    <label for="judul" class="font-semibold">Harga</label>
                                    <input type="number" name="products_price" class="px-4 py-2 rounded-md font-rubik bg-dark-white" required placeholder="Harga produk" value="<?= $model['products']->price ?>">
                                </div>
                                <div class="flex flex-col w-9/12 gap-2 mx-auto">
                                    <label for="judul" class="font-semibold">Stok</label>
                                    <input type="number" name="products_quantity" class="px-4 py-2 rounded-md font-rubik bg-dark-white" required placeholder="Stok" value="<?= $model['products']->quantity ?>">
                                </div>
                                <div class="flex flex-col w-9/12 h-48 gap-2 mx-auto">
                                    <label for="judul" class="mt-2 font-semibold">Deskripsi produk</label>
                                    <textarea name="products_description" id="" cols="30" rows="10" class="px-4 rounded-md bg-dark-white font-rubik" required placeholder="Deskripsi produk"><?= $model['products']->description ?></textarea>
                                </div>
                                <!-- <div class="flex flex-col w-9/12 gap-2 mx-auto">
                                    <label for="judul" class="mt-2 font-semibold">Kategori</label>
                                    <select name="category" id=""
                                        class="px-4 py-2 font-semibold rounded-md bg-dark-white" required>
                                        <option value="Original" class="font-semibold">Original</option>
                                        <option value="Sambal goreng" class="font-semibold">Sambal goreng</option>
                                    </select>
                                </div> -->
                                <div class="w-9/12 mx-auto mt-4">
                                    <button class="py-2 font-semibold text-white rounded-lg bg-merah px-9" type="submit">Ubah</button>
                                </div>
                            </form>
                            <script type="text/javascript">
                                document.getElementById("file_input").onchange = function() {
                                    document.getElementById("profile_img").src = URL.createObjectURL(file_input.files[0]);
                                    document.getElementById("cancel").style.display = "block";
                                    document.getElementById("upload").style.display = "none";
                                }
                                var userImg = document.getElementById('profile_img').src;
                                document.getElementById("cancel").onclick = function() {
                                    document.getElementById('profile_img').src = userImg;
                                    document.getElementById("cancel").style.display = "none";
                                    document.getElementById("upload").style.display = "block";
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>