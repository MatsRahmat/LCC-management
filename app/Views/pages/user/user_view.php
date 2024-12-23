<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div>
    <div class="my-2">
        <a href="<?= base_url('a/admin/users/add') ?>" role="button" >Add User</a>
    </div>
    <table width="80%" class="table-auto border-collapse table-border">
        <thead>
            <tr>
                <th>id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Nim</th>
                <th>Prodi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td> <?= esc($user['id']) ?></td>
                    <td> <?= esc($user['username']) ?></td>
                    <td> <?= esc($user['email']) ?></td>
                    <td> <?= esc($user['phone'] ?? "-") ?></td>
                    <td> <?= esc($user['role'] ?? "-") ?></td>
                    <td> <?= esc($user['nim'] ?? "-") ?></td>
                    <td> <?= esc($user['prodi'] ?? "-") ?></td>
                    <td>
                        <?= anchor(base_url('/a/admin/users/edit/') . $user['id'], 'edit') ?>
                        <?= anchor(base_url('/a/admin/users/delete/') . $user['id'], 'delete') ?>
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

    <?php //var_dump($pagination) 
    ?>
</div>
<?= $this->endSection() ?>