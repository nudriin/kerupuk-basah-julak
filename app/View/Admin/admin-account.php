<section>
    <div class="container p-4 py-20 mx-auto mt-12">
        <div class="flex items-center justify-start w-9/12 mx-auto mb-4">
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
        <div class="flex items-center justify-center">
            <div class="w-3/4 lg:w-2/4">
                <h1 class="mb-4 text-4xl font-medium text-center font-rubik">Admin</h1>
            </div>
        </div>
        <div class="flex items-center justify-center">
            <div class="w-3/4 lg:w-2/4">
                <h1 class="mb-4 text-xl font-medium text-center font-rubik">Admin sedang login</h1>
            </div>
        </div>
        <?php if (isset($model['displayAdmin']) && isset($model['admin']) && $model['displayAdmin'] != null && $model['admin'] != null && !isset($model['error'])) { ?>
            <div class="flex items-center justify-center mb-4 -m-4">
                <div class="w-full p-4 sm:w-1/3">
                    <div class="h-full overflow-hidden rounded-lg shadow-xl">
                        <img src="<?= getUploadedImg("profile/" . $model['admin']->profile_pic) ?>" alt="" class="object-cover object-center w-full h-40">
                        <div class="px-6 py-4">
                            <h1 class="text-2xl font-semibold text-center"><?= $model['admin']->username ?></h1>
                        </div>
                        <div class="px-6 py-4 space-y-2">
                            <div class="px-6 py-4 border-2 rounded-lg border-abu bg-dark-white">
                                <p class="text-xl font-medium font-rubik text-abu">Nama : <?= $model['admin']->name ?></p>
                                <p class="text-xl font-medium font-rubik text-abu">Email : <?= $model['admin']->email ?></p>
                                <p class="text-xl font-medium font-rubik text-abu">Nomor hp : <?= $model['admin']->phone ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="w-3/4 lg:w-2/4">
                    <h1 class="mt-4 mb-4 text-xl font-medium text-center font-rubik">Daftar admin</h1>
                </div>
            </div>
            <div class="flex flex-wrap items-center justify-center -m-4">
                <?php foreach ($model['displayAdmin'] as $row) { ?>
                    <?php if ($row['role'] == "Admin") { ?>
                        <?php if ($row['email'] != $model['admin']->email) { ?>
                            <!-- card -->
                            <div class="w-full p-4 sm:w-1/3">
                                <div class="relative h-full overflow-hidden rounded-lg shadow-xl hover:bg-merah hover:text-white">
                                    <img src="<?= getUploadedImg("profile/" . $row['profile_pic']) ?>" alt="" class="object-cover object-center w-full h-40">
                                    <div class="px-6 py-4">
                                        <h1 class="text-2xl font-semibold text-center"><?= $row['username'] ?></h1>
                                    </div>
                                    <div class="px-6 py-4 space-y-2">
                                        <div class="px-6 py-4 border-2 rounded-lg border-abu bg-dark-white">
                                            <p class="text-xl font-medium font-rubik text-abu">Nama : <?= $row['name'] ?></p>
                                            <p class="text-xl font-medium font-rubik text-abu">Email : <?= $row['email'] ?></p>
                                            <p class="text-xl font-medium font-rubik text-abu">Nomor hp : <?= $row['phone'] ?></p>
                                        </div>
                                    </div>
                                    <a onclick="return confirm('Anda yakin ingin menghapus admin (<?= $row['username'] ?>)')" href="/admin/delete/<?= $row['id'] ?>">
                                        <div class="absolute top-0 right-0 mt-2 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 text-merah">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="flex items-center justify-center col-span-12">
                <div class="w-3/4 lg:w-2/4">
                    <h1 class="mb-4 text-3xl text-center"><?= $model['error'] ?></h1>
                </div>
            </div>
        <?php } ?>
    </div>
</section>