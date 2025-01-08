<?= $this->extend('layouts/base_layout') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/user_navbar'); ?>
<?= $this->endSection(); ?>

<?php

use App\Enums\StateEnum;

$error = session()->getFlashdata(StateEnum::ERROR);
?>
<?= $this->section('content') ?>
<section class=" grid place-items-center bg-gradient-radial from-purple-700 to-[#05304E]" style="height: calc(100dvh - 4rem);">
    <div class="glass rounded-md border border-black w-[30rem] p-5">
        <h3 class="text-center text-3xl font-bold py-2">Login</h3>
        <form action="<?= base_url("auth/pushLogin") ?>" method="post" class="">
            <div class="px-2 space-y-4 py-2">
                <?php if (isset($error)): ?>
                    <div class="border rounded-md bg-rose-200 p-3">
                        <p class="font-medium text-red-500"><?= esc($error) ?></p>
                    </div>
                <?php endif ?>
                <div class="">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" required class="focus:outline-purple-700" style="border-radius: 5px;" value="<?= esc(old('username')) ?>">
                </div>
                <div class="">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="password" required class="focus:outline-purple-700" style="border-radius: 5px;">
                </div>
                <div class="py-1">
                    <p>Belum punya akun? <a href="<?= base_url('auth/register') ?>" class="text-blue-700 underline">Buat akun baru</a></p>
                </div>
                <div class="">
                    <button data-type="submit" class="w-full hover:scale-100" type="submit">
                        Login
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection(); ?>