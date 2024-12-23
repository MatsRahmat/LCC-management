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
                        <div class="flex">
                            <?php
                            $btnClass = 'btn-anchor bg-cyan-500 text-white font-semibold cursor-pointer';

                            $anchorPrev = anchor(current_url() . '?page=' . $pagination['prev_page'], 'Prev', ['class' => $btnClass]);
                            $anchorNext = anchor(current_url() . '?page=' . $pagination['next_page'], 'Next', ['class' => $btnClass]);

                            /** ----------- PRINT OUT -------------- */
                            if ($pagination['prev_page'] != null) {
                                echo $anchorPrev;
                            }

                            echo '<div class="px-2 flex items-center gap-3">';
                            if ($pagination['prev_page'] != null) {
                                echo "<span>{$pagination['prev_page']}</span>";
                            }
                            echo "<span class='text-purple-500 font-medium underline'>{$pagination['curent_page']}</span>";

                            if ($pagination['next_page'] != null) {
                                echo "<span>{$pagination['next_page']}</span>";
                            }
                            echo "</div>";

                            if ($pagination['next_page'] != null) {
                                echo $anchorNext;
                            }
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>

    <?php //var_dump($pagination) 
    ?>
</div>
<?= $this->endSection() ?>