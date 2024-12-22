<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div>
    <div>
        <?php
        if (session()->getFlashdata('error')) {
            echo "<h4>Error</h4>";
            $errorResponse = session()->getFlashdata('error');
            if (is_array($errorResponse)) {
                foreach ($errorResponse as $err) {
                    echo "<p>{$err}<p>";
                }
            } else {
                echo "<p>{$errorResponse}</p>";
            }
        }
        ?>
    </div>
    <div>
        <label for="role">Role</label>
        <select name="role" id="role" class="role-select" disabled>
            <!-- <option selected disabled>-- Pilih Role --</option> -->
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>" <?= $role['id'] == $user['role_id'] ? "selected" : "" ?>> <?= $role['name'] ?> </option>
            <?php endforeach ?>
        </select>
    </div>

    <?php if ($user['role_id'] == 4): ?>
        <section id="section-mahasiswa">
            <?= form_open(base_url('a/admin/users/update/') . $user['id'], ['method' => 'POST', 'class' => '', 'id' => '']) ?>
            <input type="hidden" name="role" value="4">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required placeholder="Masukan username" value="<?= esc($user['username']) ?>">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="contoh_email@mail.com" value="<?= esc($user['email']) ?>">
            </div>
            <div>
                <label for="phone">Phone</label><br>
                <input type="number" name="phone" id="phone" placeholder="+62 ..." required value="<?= esc($user['phone']) ?>">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="">
            </div>
            <div>
                <label for="nim">Nim</label><br>
                <input type="number" name="nim" id="nim" placeholder="masukan NIM anda" required value="<?= esc($user['nim']) ?>">
            </div>
            <div>
                <label for="birth_date">Tanggal Lahir</label><br>
                <input type="date" name="birth_date" id="birth_date" placeholder="+62 ..." required value="<?= esc($user['birth_date']) ?>">
            </div>
            <div>
                <label for="prodi">Prodi</label>
                <select name="prodi" id="prodi">
                    <option selected disabled>-- Pilih Prodi --</option>
                    <?php foreach ($prodies as $prodi): ?>
                        <option value="<?= $prodi['id'] ?>" <?= $prodi['id'] == $user['study_id'] ? "selected" : "" ?>> <?= esc($prodi['name']) ?> <span>-</span> <?= esc($prodi['code']) ?> </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div>
                <button type="submit">
                    Simpan
                </button>
            </div>
            </form>
        </section>
    <?php
    else:
    ?>
        <section id="section-other">
            <?= form_open(base_url('a/admin/users/update/') . $user['id'], ['method' => 'POST', 'class' => '', 'id' => '']) ?>
            <input type="hidden" name="role" value="<?= esc($user['role_id']) ?>">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required placeholder="Masukan username" value="<?= esc($user['username']) ?>">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="contoh_email@mail.com" value="<?= esc($user['email']) ?>">
            </div>
            <div>
                <label for="phone">Phone</label><br>
                <input type="number" name="phone" id="phone" placeholder="+62 ..." required value="<?= esc($user['phone']) ?>">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="" title="isi field password untuk mengubah password atau biarakan kosong untuk tetap menggunakan yang sudah ada">
            </div>
            <div>
                <button type="submit">
                    Simpan
                </button>
            </div>
            </form>
        </section>
    <?php endif ?>
</div>
<?= $this->endSection() ?>
<?= $this->section('script_js') ?>
<script>
    $(document).ready(function() {
        const mahasiswaSection = $('#section-mahasiswa');
        const otherSection = $('#section-other');

        /** Hide when initial render */
        // mahasiswaSection.hide();
        // otherSection.hide();

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