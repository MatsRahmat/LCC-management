<?= $this->extend('layouts/base_layout') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/user_navbar'); ?>
<?= $this->endSection(); ?>

<?php

use App\Enums\RoleEnum;
use App\Enums\StateEnum;

$errors = session()->getFlashdata(StateEnum::ERRORS) ?? [];
$type = session()->getFlashdata('type') ?? null;
?>
<?= $this->section('content') ?>
<input type="hidden" id="form-type" value="<?= $type != null ? $type : null ?>">
<section style="height: calc(100dvh - 4rem);" class="grid grid-cols-2 bg-gradient-radial from-purple-700 to-[#05304E]">
    <div>
    </div>
    <div class="h-full bg-slate-100 flex flex-col gap-2 justify-center items-center">
        <div class="flex flex-col items-center">
            <img src="<?= base_url('logo/lcc_logo.jpg') ?>" alt="LCC Logo" class="size-24">
            <h2 class="font-semibold text-2xl">LCC Activity Platform</h2>
        </div>
        <div class="grid grid-rows-2 p-4 space-y-2 " style="width: calc(50dvw - 25%);">
            <div>
                <h2 class="text-center font-semibold text-2xl">Registrasi</h2>
            </div>
            <div>
                <div class="flex justify-between border rounded-md">
                    <div class="border-black border-r w-full">
                        <label for="mahasiswa" class="inline-block px-3 py-2 w-full text-center cursor-pointer bg-gradient-to-t from-sky-500 to-blue-100 transition-all">Mahasiswa</label>
                        <input type="radio" name="type" id="mahasiswa" value="mahasiswa" class="hidden ">
                    </div>
                    <div class="border-black border-l w-full">
                        <label for="outsider" class="inline-block p px-3 py-2 w-full text-center cursor-pointer">Outsider</label>
                        <input type="radio" name="type" id="outsider" value="outsider" class="hidden ">
                    </div>
                </div>
            </div>
            <div class=" overflow-y-auto" style="height: calc(60dvh - 4rem);">
                <div data-form-section="mahasiswa" class="rounded-md px-1">
                    <form action="<?= base_url("auth/pushRegister") ?>" method="post" class="space-y-2">
                        <input type="hidden" name="role_id" value="<?= RoleEnum::MAHASISWA ?>">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="col-span-2">
                                <label for="username-mhs">Username</label>
                                <input type="text" name="username" id="username-mhs" placeholder="full name" value="<?= esc(old('username')) ?>" required>
                                <?= isset($errors['username']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['username']]) : null ?>
                            </div>
                            <div class="col-span-2">
                                <label for="email-mhs">Email</label>
                                <input type="email" name="email" id="email-mhs" placeholder="example@gmail.com" value="<?= esc(old('email')) ?>" required>
                                <?= isset($errors['email']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['email']]) : null ?>
                            </div>
                            <div class="col-span-2">
                                <label for="password-mhs">Password</label>
                                <input type="password" name="password" id="password-mhs" placeholder="**********" required>
                                <?= isset($errors['password']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['password']]) : null ?>
                            </div>
                            <div class="col-span-2">
                                <label for="phone-mhs">Phone</label>
                                <input type="number" name="phone" id="phone-mhs" placeholder="+62 ..." value="<?= esc(old('phone')) ?>" required>
                                <?= isset($errors['phone']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['phone']]) : null ?>
                            </div>
                            <div class="col-span-2">
                                <label for="nim">Nim</label>
                                <input type="number" inputmode="verbatim" name="nim" id="nim" placeholder="Nim" value="<?= esc(old('nim')) ?>" required>
                                <?= isset($errors['nim']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['nim']]) : null ?>
                            </div>
                            <div>
                                <label for="birth-date">Tangal Lahir</label>
                                <input type="date" name="birth_date" id="birth-date" min="1960-01-01" max="2020-12-31" value="<?= esc(old('birth_date')) ?>" required>
                                <?= isset($errors['birth_date']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['birth_date']]) : null ?>
                            </div>
                            <div>
                                <label for="prodi">Prodi</label>
                                <select name="study_id" id="prodi" class="w-full">
                                    <option disabled selected>-- Select Type --</option>
                                    <?php foreach ($prodies as $prodi): ?>
                                        <option value="<?= $prodi['id'] ?>" <?= old('study_id') == $prodi['id'] ? "selected" : "" ?>> <?= $prodi['name'] ?> - <?= $prodi["code"] ?> </option>
                                    <?php endforeach ?>
                                </select>
                                <?= isset($errors['study_id']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['study_id']]) : null ?>
                            </div>
                            <div class="my-3">
                                <button class="w-full" type="submit" data-type="submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div data-form-section="outsider" style="display: none;" class="px-1">
                    <form action="<?= base_url("auth/pushRegister") ?>" method="post" data-type-form="outsider" class="space-y-2">
                        <input type="hidden" name="role_id" value="5">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="col-span-2">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" placeholder="full name" value="<?= esc(old('username')) ?>" required>
                                <?= isset($errors['username']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['username']]) : null ?>
                            </div>
                            <div class="col-span-2">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" placeholder="example@gmail.com" value="<?= esc(old('email')) ?>" required>
                                <?= isset($errors['email']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['email']]) : null ?>
                            </div>
                            <div class="col-span-2">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="**********" required>
                                <?= isset($errors['password']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['password']]) : null ?>
                            </div>
                            <div class="col-span-2">
                                <label for="phone">Phone</label>
                                <input type="number" name="phone" id="phone" placeholder="+62 ..." value="<?= esc(old('phone')) ?>" required>
                                <?= isset($errors['phone']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['phone']]) : null ?>
                            </div>
                            <div class="my-3">
                                <button data-type="submit" class="w-full" type="submit">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<?= $this->section('script_js') ?>
<script>
    $(document).ready(function() {
        const mhsRadio = $('label[for=mahasiswa]');
        const outsiderRadio = $('label[for=outsider]');
        const mhsSection = $('[data-form-section=mahasiswa]');
        const outsideSection = $('[data-form-section=outsider]');
        /**
         * Gradien Class:
         * bg-gradient-to-t from-sky-500 to-blue-100
         */

        function toggleGradient() {
            mhsRadio.hide();
            mhsRadio.toggleClass('bg-gradient-to-t from-sky-500 to-blue-100');
            mhsRadio.show();
            outsiderRadio.hide();
            outsiderRadio.toggleClass('bg-gradient-to-t from-sky-500 to-blue-100');
            outsiderRadio.show();
        };
        $('input[name=type]').on('change', function() {
            if ($(this).is(':checked')) {
                const val = $(this).val();
                if (val == "mahasiswa") {
                    toggleGradient();
                    outsideSection.hide();
                    mhsSection.fadeIn(500, function() {
                        $(this).show();
                    })
                } else if (val == "outsider") {
                    toggleGradient();
                    mhsSection.hide();
                    outsideSection.fadeIn(500, function() {
                        $(this).show();
                    })
                }
            }
        });

        const formType = $('#form-type').val();
        if (formType === "mahasiwa") {
            outsideSection.hide();
            mhsSection.show();
        } else if (formType === "outsider") {
            toggleGradient();
            mhsSection.hide();
            outsideSection.show();
        }
    })
</script>

<?= $this->endSection() ?>