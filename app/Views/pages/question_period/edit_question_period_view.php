<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$errors = session()->getFlashdata(App\Enums\StateEnum::ERRORS) ?? [];
?>
<div class="space-y-3">
    <div class="border-b border-black p-3">
        <?= $this->include('partial/back_btn.php') ?>
    </div>
    <div class="border border-black rounded-md px-4 py-2">
        <?= form_open($page['page_path'] . "/update/" . $question['id'], ['class' => 'space-y-4']) ?>
        <div class="flex gap-2">
            <div class="w-full">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" required value="<?= esc($question['start_date']) ?>">
                <?= isset($errors['start_date']) ? view_cell('HelperTextCell', ['message' => $errors['start_date'], 'type' => 'error']) : null ?>
            </div>
            <div class="w-full">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" required value="<?= esc($question['end_date']) ?>">
                <?= isset($errors['end_date']) ? view_cell('HelperTextCell', ['message' => $errors['end_date'], 'type' => 'error']) : null ?>
            </div>
        </div>
        <div class="">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="w-full cursor-text" required placeholder="Masukan Judul" value="<?= esc($question['title']) ?>">
            <?= isset($errors['title']) ? view_cell('HelperTextCell', ['message' => $errors['title'], 'type' => 'error']) : null ?>
        </div>
        <div>
            <label for="status">Status</label>
            <input type="checkbox" name="status" id="status" <?= esc($question['status']) == "1" ? "checked" : "" ?>>
            <?= view_cell('HelperTextCell', ['message' => 'Secara default akan aktif', 'type' => 'helper']) ?>
        </div>
        <div class="flex justify-end px-2">
            <button type="submit" data-type="submit">Simpan</button>
        </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>