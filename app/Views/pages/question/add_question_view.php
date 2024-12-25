<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="">
    <div class="border-b border-black p-3 mb-2">
            <?= $this->include('partial/back_btn.php') ?>
    </div>
    <div class="border border-black rounded-md p-2">
        <?= form_open('a/admin/master/questions/insert', ['class' => 'space-y-4']) ?>
        <div class="">
            <label for="question">Pertanyaan</label>
            <input type="text" name="question" id="question" class="w-full cursor-text" placeholder="Apakah anda ...">
            <!-- <?= view_cell('HelperTextCell', ['message' => 'testing', 'type' => 'error']) ?> -->
        </div>
        <div class="flex justify-end px-2">
            <button type="submit" data-type="submit">Simpan</button>
        </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>