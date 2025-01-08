<nav class="bg-primary h-[4rem] shadow-md">
    <div class="flex justify-between py-2 px-3">
        <div class="text-white flex gap-2 items-center">
            <img src="<?= base_url('logo/lcc_logo.jpg') ?>" alt="Lcc Logo" class="object-contain size-10">
            <h4 class="text-2xl">LCC Actifity Platform</h4>
        </div>
        <div class="px-3 text-white flex items-center gap-2">
            <a href="<?= base_url('auth/login') ?>" class="inline-block px-4 py-2 underline underline-offset-2 hover:bg-sky-800">
                <span class="text-lg font-medium">
                    Login
                </span>
            </a>
            <a href="<?= base_url('auth/register') ?>" class="inline-block px-4 py-2 underline underline-offset-2 hover:bg-sky-800">
                <span class="text-lg font-medium">
                    Register
                </span>
            </a>
        </div>
    </div>
</nav>