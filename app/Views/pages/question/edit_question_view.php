<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('content') ?>
<div>
    <?= form_open('a/admin/master/questions/update/' . $id) ?>
    <div>
        <label for="question">Pertanyaan</label>
        <input type="text" name="question" id="question" value="<?= $question ?>">
    </div>
    <div>
        <label for="status">Status</label>
        <input type="checkbox" name="status" id="status" <?= $status ? "checked" : "" ?>>
    </div>
    <div>
        <button type="submit">Simpan</button>
    </div>
    </form>
</div>
<?= $this->endSection() ?>