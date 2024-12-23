<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div>
    <div class="my-2">
        <a href="<?= current_url() . "/add" ?>" role="button">Add Question</a>
    </div>
    <table width="80%" class="table-auto border-collapse table-border">
        <thead>
            <tr>
                <th>id</th>
                <th>Question</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td> <?= esc($question['id']) ?></td>
                    <td> <?= esc($question['question']) ?></td>
                    <td> <?= esc($question['status']) ? "Active" : "Inactive" ?></td>
                    <td>
                        <?= anchor(current_url() . "/edit/" . $question['id'], 'edit') ?>
                        <!-- <?= anchor(current_url() . "/delete/" . $question['id'], 'delete') ?> -->
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8">
                    <div class="w-full flex justify-between">
                        <div class="flex items-center">
                            <h4 class="font-semibold text-lg">Pagination</h4>
                        </div>
                        <?= $this->include('partial/pagination_action.php') ?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<?= $this->endSection() ?>