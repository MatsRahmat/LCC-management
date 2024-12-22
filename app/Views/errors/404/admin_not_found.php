<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('content') ?>
<div>
    <?= esc(session()->getFlashdata('error')) ?>
</div>
<?= $this->endSection() ?>