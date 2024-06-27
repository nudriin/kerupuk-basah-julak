<section>
    <div class="container mt-14">
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
    <div class="container w-9/12 p-4 py-20 mx-auto">
        <div class="flex items-center justify-center">
            <div class="w-3/4 lg:w-2/4">
                <h1 class="mb-4 text-4xl font-medium text-center font-rubik">Daftar User</h1>
            </div>
        </div>
        <?php if (isset($model['user']) && $model['user'] != null && !isset($model['error'])) { ?>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 rtl:text-right bg-dark-white">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nomor Telepon
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model['user'] as $row) { ?>
                            <?php if ($row['role'] == "User") { ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $row['username'] ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $row['name'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $row['email'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $row['phone'] ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="flex items-center justify-center col-span-12">
                <div class="w-3/4 lg:w-2/4">
                    <h1 class="mb-4 text-3xl text-center"><?= $model['error'] ?></h1>
                </div>
            </div>
        <?php } ?>
</section>