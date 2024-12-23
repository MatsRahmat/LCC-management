<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="m-2 space-y-3">
    <div>
        <a href="<?= previous_url() ?>" class="inline-block underline px-2 py-1 text-blue-500">
            Kembali
        </a>
    </div>
    <div class="border border-black rounded-md p-2">
        <?= form_open('a/admin/master/questions/update/' . $question['id']) ?>
        <div class="">
            <label for="question">Pertanyaan</label>
            <input type="text" name="question" id="question" class="w-full cursor-text" placeholder="Apakah anda ..." value="<?= $question['question'] ?>">
            <!-- <?= view_cell('HelperTextCell', ['message' => 'testing', 'type' => 'error']) ?> -->
        </div>
        <div>
            <label for="status">Status</label>
            <input type="checkbox" name="status" id="status" <?= $question['status'] ? "checked" : "" ?>>
        </div>
        <div>
            <button type="submit">Simpan</button>
        </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>