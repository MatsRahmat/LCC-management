<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?php
$fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
?>

<?= $this->section('content') ?>
<section class="overflow-auto grid grid-rows-4" style="height: calc(88dvh - 5rem);">
    <div class="py-2">
        <h1 class="text-center font-semibold text-6xl underline underline-offset-8 hover:text-blue-600 transition-all">
            <a href="<?= current_url() . "/more/all" ?>">
                Saldo: <?= $fmt->formatCurrency(esc($balance['total']), 'IDR') ?>
            </a>
        </h1>
    </div>
    <div class="row-span-3 grid grid-cols-2 gap-2">
        <div class="bg-green-300 h-full rounded-md p-2">
            <h1 class="text-center text-2xl font-bold ">Income/Pemasukan</h1>
            <div class="flex justify-between my-1 items-center">
                <h3 class="font-medium">Riwayat Terakhir</h3>
                <div>
                    <a href="<?= current_url() . "/add" ?>" data-type="button" class="bg-green-400 inline-block py-1 px-2">
                        <span class="text-sm">tambah</span>
                    </a>
                    <a href="<?= current_url() . "/more/income" ?>" data-type="button" class="bg-sky-500 inline-block py-1 px-2">
                        <span class="text-sm">detail</span>
                    </a>

                </div>
            </div>
            <div class="overflow-auto rounded-md p-2 bg-slate-100" style="height: calc(52dvh - 4rem);">
                <table class="w-full border border-black">
                    <thead>
                        <tr class="border border-black">
                            <th class="border border-black">Keterangan</th>
                            <th class="border border-black">Tanggal</th>
                            <th class="border border-black">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_array($incomes) && count(
                            $incomes
                        ) > 0) {

                            foreach ($incomes as $income) :
                        ?>
                                <tr>
                                    <td class="border border-black"> <?= esc($income['desc']) ?> </td>
                                    <td class="border border-black"> <?= date('d/m/Y', strtotime(esc($income['created_at']))) ?></td>
                                    <td class="border border-black"> <span class=""><?= $fmt->formatCurrency(esc($income['amount']), 'IDR') ?></span></td>
                                </tr>
                            <?php endforeach ?>
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
                            <td colspan="2">
                                <span class="font-semibold">Total</span>
                            </td>
                            <td colspan="" class="font-bold text-green-500">
                                <?= $fmt->formatCurrency(esc($total_income[0]['amount']) ?? 0, 'IDR') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="bg-rose-300 h-full rounded-md p-2">
            <h1 class="text-center text-2xl font-bold ">Outcome/Pengeluaran</h1>
            <div class="flex justify-between my-1 items-center">
                <h3 class="font-medium">Riwayat Terakhir</h3>
                <div>
                    <a href="<?= current_url() . "/add" ?>" data-type="button" class="bg-green-400 inline-block py-1 px-2">
                        <span class="text-sm">tambah</span>
                    </a>
                    <a href="<?= current_url() . "/more/outcome" ?>" data-type="button" class="bg-sky-500 inline-block py-1 px-2">
                        <span class="text-sm">detail</span>
                    </a>

                </div>
            </div>
            <div class="overflow-auto rounded-md p-2 bg-slate-100" style="height: calc(52dvh - 4rem);">
                <table class="w-full border border-black">
                    <thead>
                        <tr class="border border-black">
                            <th class="border border-black">Keterangan</th>
                            <th class="border border-black">Tanggal</th>
                            <th class="border border-black">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_array($outcomes) && count(
                            $outcomes
                        ) > 0) {

                            foreach ($outcomes as $outcome) :
                        ?>
                                <tr>
                                    <td class="border border-black"> <?= esc($outcome['desc']) ?> </td>
                                    <td class="border border-black"> <?= date('d/m/Y', strtotime(esc($outcome['created_at']))) ?></td>
                                    <td class="border border-black"> <span class=""><?= $fmt->formatCurrency(esc($outcome['amount']), 'IDR') ?></span></td>
                                </tr>
                            <?php endforeach ?>
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
                            <td colspan="2">
                                <span class="font-semibold">Total</span>
                            </td>
                            <td colspan="" class="">
                                <span class="font-bold text-red-500">
                                    <?= $fmt->formatCurrency(esc($total_outcome[0]['amount']) ?? 0, 'IDR') ?>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>