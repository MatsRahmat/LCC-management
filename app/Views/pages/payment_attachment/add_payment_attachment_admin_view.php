<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?php

use App\Enums\StateEnum;

$errors = session()->getFlashdata(StateEnum::ERRORS) ?? [] ?>
<?= $this->section('content') ?>
<section class="p-2">
    <div class="border-b border-black mb-2 py-2 hover:cursor-pointer">
        <?= $this->include('partial/back_btn') ?>
    </div>
    <?= form_open_multipart($page['page_path'] . '/insert', ['class' => 'class1 class2 class3s', 'id' => 'form-login', 'data-form-login' => 'adasdsadasd']) ?>
    <div>
        <label for="desc">Keterangan</label>
        <textarea name="desc" id="desc" class="w-full border border-black rounded-md p-2"><?= old('desc') ?? null ?></textarea>
        <?= isset($errors['desc']) ? view_cell('HelpetTextCell', ['type' => 'error', 'message' => $errors['desc']]) : null ?>
    </div>
    <div>
        <label for="">Bukti pembayaran</label>
        <input type="file" id="attachment" , accept=".jpeg, .jpg, .png" name="attachment" class="hidden">
        <div class="border border-black rounded-md w-full flex justify-between items-center">
            <div class="flex-none p-0.5">
                <button
                    type="button"
                    data-trigger="attachment"
                    class="trigger border-none border-0 bg-sky-500 text-white cursor-pointer">
                    Pilih file
                </button>
            </div>
            <div class="flex-1 border-l border-black px-1">
                <p data-section="info-attachment">-</p>
            </div>
        </div>
        <?= isset($errors['attachment'])  ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['attachment']]) : null ?>
    </div>
    <div class="flex justify-end p-2">
        <button type="submit" data-type="submit">Save</button>
    </div>
    </form>
</section>
<?= $this->endSection() ?>
<?= $this->section('script_js') ?>
<script>
    $(document).ready(function() {

        function formatFileSize(sizeInByte) {
            const sizeInKB = sizeInByte / 1024;
            const sizeInMB = sizeInKB / 1024;

            if (sizeInMB >= 1) {
                return sizeInMB.toFixed(2) + ' MB';
            } else {
                return sizeInKB.toFixed(2) + ' KB';
            }
        }

        // ============= FOR WATCH TRIGGER BTN ================
        $('button.trigger').on('click', function() {
            try {
                let triggerId = $(this).attr('data-trigger');
                $(`input[type=file]#${triggerId}`).click();
            } catch (error) {
                console.error('Element not found,', error)
            }
        });

        //=================== HANDLE INPUT FILE CHANGE ==============
        const infoElem = $('[data-section=info-attachment]');
        $('#attachment').on('change', function() {
            const files = $(this).prop('files');
            if (files instanceof FileList && files.length > 0) {
                const file = files[0];
                const textToShow = `Nama: ${file.name} - Ukuran: ${formatFileSize(file.size)}`;
                infoElem.text(textToShow);
                // console.log({
                //     mime: file.type,
                //     file
                // })
            }
        })
    })
</script>
<?= $this->endSection() ?>