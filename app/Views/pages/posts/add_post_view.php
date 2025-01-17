<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?php

use App\Enums\StateEnum;

$errors = session()->getFlashdata(StateEnum::ERRORS) ?? []; ?>

<?= $this->section('content') ?>
<section class="space-y-2">
    <?= form_open_multipart('a/admin/posts/insert', ['class' => '', 'id' => 'form']) ?>
    <div>
        <label for="title">Judul</label>
        <textarea name="title" id="title" class="w-full border focus:outline-blue-500 focus:bg-slate-100 transition-colors border-black rounded-md p-2"><?= old('title') ?? null ?></textarea>
        <?= isset($errors['title']) ? view_cell('HelperTextCell', ['type' => 'error', 'message' => $errors['title']]) : null ?>
    </div>
    <div class="flex items-center gap-2">
        <label for="">Sisipkan</label>
        <input type="file" id="attachments" , accept=".jpeg, .jpg, .png, .gif" name="attachments[]" class="hidden">
        <label for="attachments">
            <div class="cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000">
                    <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm40-80h480L570-480 450-320l-90-120-120 160Zm-40 80v-560 560Z" />
                </svg>
            </div>
        </label>
    </div>
    <div>
        <?php
        if (isset($errors['attachments']) && is_array($errors['attachments'])) {
            foreach ($errors['attachments'] as $errAttch) {
                echo view_cell('HelperTextCell', ['type' => 'error', 'message' => $errAttch['attachments']]);
            }
        } ?>
    </div>
    <div>
        <div class="flex flex-wrap gap-2 overflow-y-auto border rounded-md p-1" id="parent-grid" style="max-height: calc(80dvh - 10rem);">
        </div>
    </div>
    <div class="flex justify-end px-2 my-2">
        <button data-type="submit" class="">Simpan</button>
    </div>
    </form>
</section>
<?= $this->endSection() ?>
<?= $this->section('script_js') ?>
<script>
    $(document).ready(function() {
        const INPUT_NAMES = {
            TITLE: "title",
            ATTACH: "attachments"
        }
        const parentGridPrev = $('#parent-grid');
        const inputFile = $('input[type=file]');
        const formData = new FormData(document.getElementById('form'));
        // formData.append(INPUT_NAMES.TITLE, '');
        formData.append(INPUT_NAMES.ATTACH, []);

        function formatFileSize(sizeInByte) {
            const sizeInKB = sizeInByte / 1024;
            const sizeInMB = sizeInKB / 1024;

            if (sizeInMB >= 1) {
                return sizeInMB.toFixed(2) + ' MB';
            } else {
                return sizeInKB.toFixed(2) + ' KB';
            }
        }

        function createUrl(file) {
            return window.URL.createObjectURL(file)
        }

        function removeFile() {
            const elem = $(this);
            const index = elem.attr('data-index-file');

            const dt = new DataTransfer();
            const input = document.getElementById('attachments');
            const { files } = input;

            for(let i = 0; i < files.length; i++){
                if(Number(index) != i){
                    dt.items.add(files[i]);
                }
            }
            input.files = dt.files;
            $('div[data-index-file="' + index + '"]').remove();
        }

        /** 
         * @param {File} file
         * @param {number} index
         */
        function createPrevElem(file, index) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const div = $('<div>')
                    .addClass('relative grid-item')
                    .attr('data-index-file', index)
                    .css({flex: "1 1 200px", 'margin-bottom': '10px'}); // .attr('style', 'flex:1 1 200px; margin-bottom:10px;')
                const img = $('<img>')
                    .attr('src', e.target.result);
                const removeBtn = $('<button>')
                    .attr('type', 'button')
                    .attr('data-index-file', index)
                    .text("X")
                    .on('click', removeFile)
                    .addClass('absolute top-2 right-2 size-7 grid place-items-center p-0 bg-black bg-opacity-50 text-white remove');
                div.append(img).append(removeBtn);
                parentGridPrev.append(div)
            }
            reader.readAsDataURL(file);
        }

        // ============= FOR WATCH TRIGGER BTN ================ NOT USE
        $('button.trigger').on('click', function() {
            try {
                let triggerId = $(this).attr('data-trigger');
                $(`input[type=file]#${triggerId}`).click();
            } catch (error) {
                console.error('Element not found,', error)
            }
        });

        //=================== HANDLE INPUT FILE CHANGE ==============

        $('#attachments').on('change', function(event) {
            const filesList = event.target.files;
            parentGridPrev.empty();

            for (const [index, file] of Object.entries(filesList)) {
                createPrevElem(file, index);
            }
        });

        //=================== HANDLE TEXTAREA CHANGE ==============
        // console.log($('#title'));
        // $('#title').on('input', function() {
        //     const val = $(this).val();
        //     formData.set(INPUT_NAMES.TITLE, val);
        // });

        // $('button[data-type=submit]').on('click', function() {
        //     formData.forEach((val, key) => {
        //         console.log({
        //             val,
        //             key
        //         });
        //     })
        //     console.log(formData.getAll(INPUT_NAMES.ATTACH));
        // })
    });
</script>
<?= $this->endSection() ?>