<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section>
    <div>
        <a href="<?= current_url() . "/add" ?>" data-type="button" class="bg-green-400 inline-block p-2">
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000">
                    <path d="M444-444H240v-72h204v-204h72v204h204v72H516v204h-72v-204Z" />
                </svg>
            </div>
        </a>
    </div>
    <div>
        <div class="flex justify-end my-2">
            <div class="">
                <?php
                if ($pagination['prev_page'] != null) {
                    $href = current_url() . "?page=" . $pagination['prev_page'];
                    echo '<a href="{$href}" data-type="button" class="bg-sky-500 inline-block p-1">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                            <path d="M640-80 240-480l400-400 71 71-329 329 329 329-71 71Z" />
                        </svg>
                    </div>
                </a>';
                }

                echo '<div class="font-medium">';

                if ($pagination['prev_page'] != null) {
                    echo "<span>{$pagination['prev_page']}</span>";
                }

                echo "<span>{$pagination['curent_page']}</span>";

                if ($pagination['next_page'] != null) {
                    echo "<span>{$pagination['next_page']}</span>";
                }

                if ($pagination['total_page'] > 3) {
                    echo "<span>...</span>
                    <span>{$pagination['total_data']}</span>";
                }

                echo "</div>";
                if ($pagination['next_page'] != null) {
                    $href = current_url() . "?page=" . $pagination['next_page'];
                    echo '<a href="{$href}" data-type="button" class="bg-sky-500 inline-block p-1">
                    <div class="rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                            <path d="M640-80 240-480l400-400 71 71-329 329 329 329-71 71Z" />
                        </svg>
                    </div>
                </a>';
                }
                ?>
            </div>
        </div>
        <div class="space-y-2 overflow-y-auto border rounded-md p-1" style="height: calc(80dvh - 4rem);">
            <?php foreach ($data as $attch): ?>
                <div data-card="adasd" class="border border-black rounded-md flex justify-between p-1">
                    <div>
                        <h4><?= $attch['desc'] ?></h4>
                        <p class="italic btn-detail text-violet-500 underline" data-detail-url="<?= $attch['url'] ?>" data-file-name="<?= $attch['original_name'] ?>"><?= $attch['original_name'] ?></p>
                        <?= view_cell('HelperTextCell', ['message' => "Dibuat oleh: " . $attch['created_by'] . " - " . date('d/m/Y H:i', strtotime($attch['created_at'])), 'type' => 'helper']) ?>
                    </div>
                    <div class="flex-none border-l border-black flex gap-2 py-1 px-2 items-center">
                        <button class="bg-lime-300 p-1 hover:scale-105 rounded-md border-0 cursor-pointer btn-detail" data-detail-url="<?= $attch['url'] ?>" data-file-name="<?= $attch['original_name'] ?>">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#000">
                                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                                </svg>
                                <span class="text-sm">Lihat</span>
                            </div>
                        </button>
                        <a href="<?= current_url() . "/edit/" . $attch["id"] ?>" data-type="button" class="bg-sky-300 inline-block p-1">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#000">
                                    <path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z" />
                                </svg>
                                <span class="text-sm">edit</span>
                            </div>
                        </a>
                        <a href="<?= current_url() . "/delete/" . $attch['id'] ?>" data-type="button" class="bg-red-400 inline-block p-1">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#b91c1c">
                                    <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z" />
                                </svg>
                                <span class="text-sm">hapus</span>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div id="modal-detail" class="fixed top-0 right-0 bottom-0 left-0 bg-black bg-opacity-70 grid scale-0 place-items-center">
        <div class="bg-white rounded-md" style="width: calc(100dvw - 10rem); height: calc(100dvh - 7rem);">
            <div class="border-b border-black flex justify-between items-center py-3 px-4">
                <h4 id="image-title" class="text-xl font-semibold"></h4>
                <button style="border: none" id="close-modal-btn">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000">
                            <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                        </svg>
                    </div>
                </button>
            </div>
            <div class="grid place-content-center " style="height: calc(100dvh - 12rem);">
                <a href="" id="detail-anchor" target="_blank" rel="noreferrer" class="inline-block  h-[inherit] w-[inherit]">
                    <img src="" alt="" id="detail-img" class="aspect-square object-contain w-full h-full">
                </a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('script_js') ?>
<script>
    $(document).ready(function() {
        const modalDetail = $('#modal-detail');

        $('.btn-detail').on('click', function() {
            modalDetail.removeClass('scale-0');
            modalDetail.addClass('scale-100');
            // modalDetail.fadeIn(800)

            const url = $(this).attr('data-detail-url');
            const fileName = $(this).attr('data-file-name');

            $('img#detail-img').attr('src', url).attr('alt', fileName);
            $('#detail-anchor').attr('href', url);
            $('#image-title').text(fileName);
        });

        $('#close-modal-btn').on('click', function() {
            modalDetail.removeClass('scale-100');
            modalDetail.addClass('scale-0');
        });
    });
</script>
<?= $this->endSection() ?>