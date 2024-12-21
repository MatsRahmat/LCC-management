<?= $this->extend('/layouts/base_layout.php') ?>

<?= $this->section('content') ?>
<div>
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            --webkit-appearance: none;
            margin: 0;
        }
    </style>

    <div>
        <?php if (session()->getFlashdata('error')): ?>
            <div>
                <?php if (is_array(session()->getFlashdata('error'))): ?>
                    <?php foreach (session()->getFlashdata('error') as $error): ?>
                        <p>
                            <?= esc($error) ?>
                        </p>
                    <?php endforeach ?>
                <?php else: ?>
                    <p>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </p>
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>

    <div>
        <label for="role">Tipe</label>
        <select name="type" id="role">
            <option value="outsider" selected>Outsider</option>
            <option value="mahasiswa">Mahasiwa</option>
        </select>
    </div>

    <!-- Form when type mahasiswa -->
    <form action="<?= base_url("auth/pushRegister") ?>" method="post" data-type-form="mahasiswa">
        <input type="hidden" name="role_id" value="4">
        <div>
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" placeholder="full name" required>
        </div>

        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" placeholder="**********" required>
        </div>
        <div>
            <label for="birth-date">Tangal Lahir</label><br>
            <input type="date" name="birth_date" id="birth-date" min="1990-01-01" max="2007-12-31" required>
        </div>
        <div>
            <label for="nim">Nim</label><br>
            <input type="number" inputmode="verbatim" name="nim" id="nim" placeholder="Please insert NIM" required>
        </div>
        <div>
            <label for="phone">Phone</label><br>
            <input type="number" name="phone" id="phone" placeholder="08323242" required>
        </div>
        <div>
            <label for="prodi">Prodi</label>
            <select name="study_id" id="prodi">
                <option disabled selected>-- Select Type --</option>
                <?php foreach ($prodies as $prodi): ?>
                    <option value="<?= $prodi['id'] ?>"> <?= $prodi['name'] ?> - <?= $prodi["code"] ?> </option>
                <?php endforeach ?>
            </select>
        </div>
        <div>
            <button type="submit">
                Register
            </button>
        </div>
    </form>

    <!-- Form when type mahasiswa -->
    <form action="<?= base_url("auth/pushRegister") ?>" method="post" data-type-form="outsider">
        <input type="hidden" name="role_id" value="5">
        <div>
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" placeholder="full name" required>
        </div>
        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" placeholder="**********" required>
        </div>
        <div>
            <button type="submit">
                Register
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('script_js') ?>
<script>
    $(document).ready(function() {

        // Hide when initial render
        $('[data-type-form="mahasiswa"]').hide();
        // $('[data-type-form="outsider"]').hide();

        $('[name="type"]').on('change', function() {
            const value = $(this).val();
            if (value == "mahasiswa") {
                $('[data-type-form="mahasiswa"]').show();
                $('[data-type-form="outsider"]').hide();
                $('[data-type-form="outsider"]')[0].reset();
                
            } else if (value == "outsider") {
                $('[data-type-form="outsider"]').show();
                $('[data-type-form="mahasiswa"]').hide();
                $('[data-type-form="mahasiswa"]')[0].reset();
            }
        })
    })
</script>

<?= $this->endSection() ?>