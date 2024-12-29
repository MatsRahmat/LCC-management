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
    <?= form_open($page['page_path'] . '/insert', ['class' => '']) ?>
    <div class="border rounded-md p-2 space-y-2">
        <div>
            <label for="type">Type</label>
            <select name="type_id" id="type" class="w-full text-center">
                <option selected disabled> -- Pilih Tipe --</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type['id'] ?>"> <?= $type['name'] ?> </option>
                <?php endforeach ?>
            </select>
            <?= isset($errors['type_id']) ? view_cell('TextHelperCell', ['mesage' => $errors['type_id'], 'type' => 'error']) : null ?>
        </div>
        <div>
            <label for="amount">Jumlah</label>
            <input type="number" name="amount" id="amount" required>
            <?= isset($errors['amount']) ? view_cell('TextHelperCell', ['mesage' => $errors['amount'], 'type' => 'error']) : null ?>
        </div>
        <div>
            <label for="desc">Keterangan</label>
            <textarea name="desc" id="desc" required class="border border-black rounded-sm p-2 w-full" rows="4"></textarea>
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