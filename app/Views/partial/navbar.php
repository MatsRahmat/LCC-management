<div class="flex items-center px-2 h-full justify-between">
    <h1 class="font-medium text-lg text-white"> <?= esc($page['title'] ?? "Dasboard") ?></h1>
    <div>
        <div class="flex items-center gap-3">
            <img src="<?= base_url('icons/noprofile.gif') ?>" alt="Profile" class="rounded-full size-8">
            <div class="text-white font-semibold">
                <?= anchor(base_url('a/admin/profile'), session()->get('username') ?? 'Admin', ['class' => 'hover:underline']) ?>
            </div>
        </div>
    </div>
</div>