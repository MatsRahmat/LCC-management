<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('content') ?>
<div>
    <?= form_open('a/admin/master/questions/insert') ?>
    <div>
        <label for="question">Pertanyaan</label>
        <input type="text" name="question" id="question">
    </div>
    <div>
        <button type="submit">Simpan</button>
    </div>
    </form>
</div>
<?= $this->endSection() ?>