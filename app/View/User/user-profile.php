<section x-data="{open : true}">
    <div class="container px-4 py-4 mx-auto lg:px-20 lg:py-10">
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
        <div class="flex items-center justify-center">
            <div class="w-3/4 lg:w-2/4">
                <h1 class="mt-12 mb-4 text-4xl font-medium text-center font-rubik">Profil</h1>
            </div>
        </div>
        <div class="w-full p-4">
            <div class="h-full mx-auto overflow-hidden rounded-lg shadow-lg lg:w-9/12">
                <div class="grid items-center justify-center grid-cols-12 gap-4 p-4">
                    <form action="/user/profile" method="post" class="z-0 flex flex-col items-center justify-center col-span-12 gap-2" enctype="multipart/form-data">
                        <div class="relative inset-0 col-span-12 mx-auto mb-5 text-center">
                            <!-- <div class="relative"> -->
                            <img src="<?= getUploadedImg("profile/" . $model['user_profile']) ?? '' ?>" alt="" id="profile_img" class="object-cover object-center w-48 h-48 border-4 rounded-full border-abu">
                            <div id="upload" style="position: absolute; bottom: 0; right: 0; width: 32px; height: 32px; line-height: 33px; text-align: center; border-radius: 50%; overflow: hidden; cursor: pointer;">
                                <input type="file" name="picture" id="picture" required style="position: absolute; transform: scale(2); opacity: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                    <path d="M12 9a3.75 3.75 0 100 7.5A3.75 3.75 0 0012 9z" />
                                    <path fill-rule="evenodd" d="M9.344 3.071a49.52 49.52 0 015.312 0c.967.052 1.83.585 2.332 1.39l.821 1.317c.24.383.645.643 1.11.71.386.054.77.113 1.152.177 1.432.239 2.429 1.493 2.429 2.909V18a3 3 0 01-3 3h-15a3 3 0 01-3-3V9.574c0-1.416.997-2.67 2.429-2.909.382-.064.766-.123 1.151-.178a1.56 1.56 0 001.11-.71l.822-1.315a2.942 2.942 0 012.332-1.39zM6.75 12.75a5.25 5.25 0 1110.5 0 5.25 5.25 0 01-10.5 0zm12-1.5a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div id="cancel" style="position: absolute; bottom: 0; left: 0; width: 32px; height: 32px; line-height: 33px; text-align: center; border-radius: 50%; overflow: hidden; cursor: pointer; display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="w-full col-span-12 p-3 overflow-hidden border-2 rounded-lg border-abu bg-dark-white"><?= $model['user']->email ?? $model['user_email'] ?></p>
                        <input class="w-full p-3 mb-4 border-2 rounded-lg border-abu" type="text" value="<?= $model['user']->name ?? $model['user_name'] ?>" name="name" required>
                        <div>
                            <button type="submit" class="w-full p-2 text-xl font-semibold text-center transition duration-200 ease-in rounded-lg text-dark-white bg-merah hover:bg-biru">Simpan</button>
                        </div>
                    </form>
                    <script type="text/javascript">
                        document.getElementById("picture").onchange = function() {
                            document.getElementById("profile_img").src = URL.createObjectURL(picture.files[0]);
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
</section>