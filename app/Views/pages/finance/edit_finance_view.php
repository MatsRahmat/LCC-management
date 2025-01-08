<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?php
$fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
$errors = session()->getFlashdata(App\Enums\StateEnum::ERRORS) ?? [];
?>

<?= $this->section('content') ?>
<section>
    <div class="p-2 border-b border-black mb-3">
        <?= $this->include("partial/back_btn") ?>
    </div>
    <?= form_open($page['page_path'] . '/update/' . $trans['id'], ['class' => '']) ?>
    <div class="border rounded-md p-2 space-y-2">
        <div>
            <label for="type">Type</label>
            <select name="type_id" id="type" class="w-full text-center" disabled>
                <option selected disabled> -- Pilih Tipe --</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type['id'] ?>" <?= $trans['type_id'] == $type['id'] ? "selected" : "" ?>> <?= $type['name'] ?> </option>
                <?php endforeach ?>
            </select>
            <?= isset($errors['type_id']) ? view_cell('TextHelperCell', ['mesage' => $errors['type_id'], 'type' => 'error']) : null ?>
        </div>
        <div>
            <label for="amount">Jumlah</label>
            <input type="number" name="amount" id="amount" required value="<?= esc($trans['amount']) ?>">
            <?= isset($errors['amount']) ? view_cell('TextHelperCell', ['mesage' => $errors['amount'], 'type' => 'error']) : null ?>
        </div>
        <div>
            <label for="desc">Keterangan</label>
            <textarea name="desc" id="desc" required class="border border-black rounded-sm p-2 w-full" rows="4"><?= esc($trans['desc']) ?></textarea>
            <?= isset($errors['desc']) ? view_cell('TextHelperCell', ['mesage' => $errors['desc'], 'type' => 'error']) : null ?>
        </div>
        <div class="flex justify-end px-2">
            <button type="submit" data-type="submit">
                Simpan
            </button>
        </div>
    </div>
    </form>
</section>
<?= $this->endSection() ?>