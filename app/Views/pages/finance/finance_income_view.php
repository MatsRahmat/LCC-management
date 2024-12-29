<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?php
$fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
?>

<?= $this->section('content') ?>
<section class="space-y-2">
    <div class="py-3 px-2 border-b border-black">
        <?= $this->include('partial/back_btn') ?>
    </div>
    <h2 class="text-center font-semibold text-2xl">Income/Pemasukan</h2>
    <div class="overflow-auto p-3 border rounded-md" style="height: calc(80dvh - 5rem);">
        <table class="w-full border border-black">
            <colgroup>
                <col class="text-center">
                <col>
                <col>
                <col>
                <col>
                <col class="w-12">
            </colgroup>
            <thead>
                <tr class="border border-black">
                    <th class="border border-black">No</th>
                    <th class="border border-black">Keterangan</th>
                    <th class="border border-black">Dibuat Oleh</th>
                    <th class="border border-black">Tanggal</th>
                    <th class="border border-black">Jumlah</th>
                    <th class="border border-black">Action</th>
                </tr>
            </thead>
            <tbody class="" style="min-height:calc(80dvh - 9rem);">
                <?php
                if (is_array($incomes) && count(
                    $incomes
                ) > 0) {
                    foreach ($incomes as $index => $income) :
                ?>
                        <tr>
                            <td class="border border-black text-center"> <?= esc($index + 1) ?> </td>
                            <td class="border border-black"> <?= esc($income['desc']) ?> </td>
                            <td class="border border-black"> <?= esc($income['created_by']) ?> </td>
                            <td class="border border-black"> <?= date('d/m/Y H:i', strtotime(esc($income['created_at']))) ?></td>
                            <td class="border border-black"> <span class="font-semibold"><?= $fmt->formatCurrency(esc($income['amount']), 'IDR') ?></span></td>
                            <td class="border border-black">
                                <div class="flex gap-2">
                                    <a href="<?= base_url('a/admin/finances/edit/') . $income['id'] ?>" data-type="button" class="bg-sky-300 inline-block p-1">
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#000">
                                                <path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z" />
                                            </svg>
                                            <span class="text-sm">edit</span>
                                        </div>
                                    </a>
                                    <a href="<?= base_url('a/admin/finances/delete/') . $income['id'] ?>" data-type="button" class="bg-red-400 inline-block p-1">
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
                    <tr class="border border-black">
                        <td colspan="6">Total</td>
                        <td class="border border-black text-left" colspan="2">
                            <span class="font-bold text-green-500">
                                <?= $fmt->formatCurrency(esc($total_income), 'IDR') ?>
                            </span>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">
                            <h1 class="text-center">Tidak ada data</h1>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
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
</section>
<?= $this->endSection() ?>