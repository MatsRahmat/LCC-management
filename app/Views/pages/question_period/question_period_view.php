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
    <div class="border rounded-md overflow-y-auto py-3 px-2 space-y-2" style="height: calc(80dvh - 5rem);">
        <?php foreach ($questions as $question): ?>
            <div class="flex justify-between gap-2 border p-2 rounded-md border-black hover:bg-slate-100">
                <div class="flex-1 w-full border-r">
                    <div class="flex gap-1 items-center">
                        <a href="" class="hover:underline hover:underline-offset-2 decoration-blue-700 group/item">
                            <h1 class="text-lg text-blue-500"><?= esc($question['title']) ?></h1>
                        </a>
                        <span class="group-hover/item:visible">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#334155">
                                <path d="M440-280H280q-83 0-141.5-58.5T80-480q0-83 58.5-141.5T280-680h160v80H280q-50 0-85 35t-35 85q0 50 35 85t85 35h160v80ZM320-440v-80h320v80H320Zm200 160v-80h160q50 0 85-35t35-85q0-50-35-85t-85-35H520v-80h160q83 0 141.5 58.5T880-480q0 83-58.5 141.5T680-280H520Z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-sm">
                        <span><?= esc(date('l, d/m/Y', strtotime($question['start_date']))) ?></span>
                        <span>-</span>
                        <span><?= esc(date('l, d/m/Y', strtotime($question['end_date']))) ?></span>
                    </div>
                </div>
                <div class="flex-none">
                    <div class="flex gap-2 h-full items-center">
                        <a href="<?= current_url() . "/edit/" . $question['id'] ?>" data-type="button" class="bg-sky-300 inline-block p-1">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#000">
                                    <path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z" />
                                </svg>
                                <span class="text-sm">edit</span>
                            </div>
                        </a>
                        <a href="<?= current_url() . "/delete/" . $question['id'] ?>" data-type="button" class="bg-red-400 inline-block p-1">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#b91c1c">
                                    <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z" />
                                </svg>
                                <span class="text-sm">hapus</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>