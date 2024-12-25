<div class="flex items-center px-2 h-full justify-between">
    <div>
        <h1 class="font-medium text-lg text-white"> <?= esc($page['title'] ?? "Dasboard") ?></h1>
        <div class="text-white">
            <?php
            if (isset($page) && isset($page['path']) && is_array($page['path'])) {
                foreach ($page['path'] as $index => $path) {
                    if ($index + 1 < count($page['path'])) {
                        echo "<span> {$path} </span> >";
                    } else {
                        echo "<span class='underline underline-offset-4'> {$path} </span>";
                    }
                }
            }
            ?>
        </div>
    </div>
    <div>
        <div class="flex items-center gap-3">
            <img src="<?= base_url('icons/noprofile.gif') ?>" alt="Profile" class="rounded-full size-8">
            <div class="text-white font-semibold">
                <?= anchor(base_url('a/admin/profile'), session()->get('username') ?? 'Admin', ['class' => 'hover:underline']) ?>
            </div>
        </div>
    </div>
</div>