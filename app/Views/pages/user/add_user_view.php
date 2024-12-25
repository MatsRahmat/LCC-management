<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$errors = session()->getFlashdata(App\Enums\StateEnum::ERRORS) ?? [];
?>

<div class="">
    <div class="border-b border-black p-3 mb-2">
        <?= $this->include('partial/back_btn.php') ?>
    </div>
    <div class="px-3">
        <div>
            <label for="role">Role</label>
        </div>
        <select name="role" id="role" class="role-select rounded-md p-1 w-full">
            <option selected disabled>-- Pilih Role --</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>"> <?= $role['name'] ?> </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="overflow-auto overscroll-auto" style="height: calc(80dvh - 5rem);">
        <section id="section-mahasiswa" class="border rounded-md p-2 my-2">
            <?= form_open(base_url('a/admin/users/insert'), ['method' => 'POST', 'class' => 'space-y-2', 'id' => '']) ?>
            <input type="hidden" name="role" value="4">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required placeholder="Masukan username">
                <?= isset($errors['username']) ? view_cell('HelperTextCell', ['message' => $errors['username'], 'type' => 'error']) : null ?>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="contoh_email@mail.com">
                <?= isset($errors['email']) ? view_cell('HelperTextCell', ['message' => $errors['email'], 'type' => 'error']) : null ?>
            </div>
            <div>
                <label for="phone">Phone</label>
                <input type="number" name="phone" id="phone" placeholder="+62 ..." required>
                <?= isset($errors['phone']) ? view_cell('HelperTextCell', ['message' => $errors['phone'], 'type' => 'error']) : null ?>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required placeholder="***********">
                <?= isset($errors['password']) ? view_cell('HelperTextCell', ['message' => $errors['password'], 'type' => 'error']) : null ?>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="nim">Nim</label>
                    <input type="number" name="nim" id="nim" placeholder="masukan NIM anda" required>
                    <?= isset($errors['nim']) ? view_cell('HelperTextCell', ['message' => $errors['nim'], 'type' => 'error']) : null ?>
                </div>
                <div>
                    <label for="birth_date">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" placeholder="+62 ..." required>
                    <?= isset($errors['birth_date']) ? view_cell('HelperTextCell', ['message' => $errors['birth_date'], 'type' => 'error']) : null ?>
                </div>
            </div>
            <div>
                <label for="prodi">Prodi</label>
                <select name="prodi" id="prodi" class="w-full">
                    <option selected disabled>-- Pilih Prodi --</option>
                    <?php foreach ($prodies as $prodi): ?>
                        <option value="<?= $prodi['id'] ?>"> <?= esc($prodi['name']) ?> <span>-</span> <?= esc($prodi['code']) ?> </option>
                    <?php endforeach ?>
                </select>
                <?= isset($errors['prodi']) ? view_cell('HelperTextCell', ['message' => $errors['prodi'], 'type' => 'error']) : null ?>
            </div>
            <div class="flex justify-end my-2">
                <button type="submit" data-type="submit">
                    Simpan
                </button>
            </div>
            </form>
        </section>
        <section id="section-other" class="border rounded-md p-2 my-2">
            <?= form_open(base_url('a/admin/users/insert'), ['method' => 'POST', 'class' => 'space-y-2', 'id' => '']) ?>
            <input type="hidden" name="role" value="">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required placeholder="Masukan username">
                <?= isset($errors['username']) ? view_cell('HelperTextCell', ['message' => $errors['username'], 'type' => 'error']) : null ?>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="contoh_email@mail.com">
                <?= isset($errors['email']) ? view_cell('HelperTextCell', ['message' => $errors['email'], 'type' => 'error']) : null ?>
            </div>
            <div>
                <label for="phone">Phone</label>
                <input type="number" name="phone" id="phone" placeholder="+62 ..." required>
                <?= isset($errors['email']) ? view_cell('HelperTextCell', ['message' => $errors['email'], 'type' => 'error']) : null ?>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required placeholder="***********">
                <?= isset($errors['email']) ? view_cell('HelperTextCell', ['message' => $errors['email'], 'type' => 'error']) : null ?>
            </div>
            <div class="flex justify-end my-3">
                <button type="submit" data-type="submit">
                    Simpan
                </button>
            </div>
            </form>
        </section>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script_js') ?>
<script>
    $(document).ready(function() {
        const mahasiswaSection = $('#section-mahasiswa');
        const otherSection = $('#section-other');

        /** Hide when initial render */
        mahasiswaSection.hide();
        otherSection.hide();

        //* Watch for value change
        $('.role-select').on('change', function() {
            const value = $(this).val();
            if (value == "4") {
                $(otherSection).find('form')[0].reset();
                mahasiswaSection.show();
                otherSection.hide();
            } else if (!isNaN(value)) {
                $(otherSection).find('[name="role"]').attr('value', value); // Set value for role to input type hidden
                $(mahasiswaSection).find('form')[0].reset(); // Reset value in form mahasiswa
                mahasiswaSection.hide();
                otherSection.show();
            }
        })
    })
</script>
<?= $this->endSection() ?>