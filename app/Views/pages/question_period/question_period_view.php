<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div>
    <div class="my-2">
        <a href="<?= current_url() . "/add" ?>" data-type="button" class="bg-green-400 inline-block p-2">
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000">
                    <path d="M444-444H240v-72h204v-204h72v204h204v72H516v204h-72v-204Z" />
                </svg>
            </div>
        </a>
    </div>
    <table width="80%" class="table-auto border-collapse table-border">
        <thead>
            <tr>
                <th>id</th>
                <th>Judul</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Di Buat Oleh</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td> <?= esc($question['id']) ?></td>
                    <td> <?= esc($question['title']) ?></td>
                    <td> <?= esc($question['start_date']) ?></td>
                    <td> <?= esc($question['end_date']) ?></td>
                    <td> <?= esc($question['created_by']) ?></td>
                    <td> <?= esc($question['status']) ? "Active" : "Inactive" ?></td>
                    <td>
                        <div class="flex gap-1">
                            <a href="<?= current_url() . "/edit/" . $question['id'] ?>" data-type="button" class="bg-sky-300 inline-block p-2">
                                <div class="flex gap-1 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#000">
                                        <path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z" />
                                    </svg>
                                    <span class="text-sm">edit</span>
                                </div>
                            </a>

                            <a href="<?= current_url() . "/delete/" . $question['id'] ?>" data-type="button" class="bg-red-400 inline-block p-2">
                                <div class="flex gap-1 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#b91c1c">
                                        <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z" />
                                    </svg>
                                    <span class="text-sm">hapus</span>
                                </div>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8">
                    <div class="w-full flex justify-between">
                        <div class="flex items-center">
                            <h4 class="font-semibold text-lg">Pagination</h4>
                        </div>
                        <?= $this->include('partial/pagination_action.php') ?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<?= $this->endSection() ?>