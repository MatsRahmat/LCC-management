<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?php
$fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
?>

<?= $this->section('content') ?>
<section>
    <div class="border-b border-black mb-1">
        <h3 class="text-xl font-semibold text-center">Profile</h3>
    </div>
    <div class="border rounded-md grid grid-cols-4 gap-2 p-2">
        <?php foreach ($user as $key => $val):
            if ($key == "id") {
                continue;
            }
        ?>
            <div class="capitalize"><?= $key ?> </div>
            <div class="col-span-3">: <?= esc($val) ?? "-" ?></div>
        <?php endforeach ?>
    </div>
    <div class="flex gap-2 items-center my-2">
        <?= view_cell('BtnAnchorCell', ['url' => previous_url(), 'text' => 'Kembali', 'class' => 'px-1 bg-sky-300 border font-medium hover:text-white']) ?>
        <?= view_cell('BtnAnchorCell', ['url' => '/a/admin/users/edit/' . $user['id'], 'text' => 'Update', 'class' => 'px-1 bg-emerald-400 border font-medium hover:text-white']) ?>
    </div>
</section>
<?= $this->endSection() ?>