<?= $this->extend('layouts/admin_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="space-y-2">
    <div class="flex justify-between items-center border-b py-2 shadow-sm">
        <div>
            <?php

            use App\Enums\RoleEnum;

            $role = session()->get('role');

            if ($role == RoleEnum::ADMINISTRATOR || $role == RoleEnum::SUPER_ADMIN): ?>
                <a href="<?= "posts/add" ?>" data-type="button" class="bg-green-400 inline-block p-2">
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000">
                            <path d="M444-444H240v-72h204v-204h72v204h204v72H516v204h-72v-204Z" />
                        </svg>
                    </div>
                </a>
            <?php endif ?>
        </div>
        <div class="flex gap-3">
            <p>
                Total post: <?= isset($total_post) ? $total_post : 0 ?>
            </p>
            <div class="">
                <p>Pagination: </p>
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
    </div>
    <div class="overflow-y-auto py-2 grid gap-3 place-items-center bg-primary" style="height: calc(80dvh - 5rem);">
        <?php
        foreach ($posts as $post):
        ?>
            <div data-card="" class="bg-slate-200 border rounded-md shadow-md p-3 w-[30rem] space-y-3">
                <div class="flex justify-between items-center border-b border-black">
                    <div>
                        <h3 class="font-medium"><?= $post['created_by_name'] ?? "Admin" ?></h3>
                        <p class="text-sm"><?= date('d-m-Y H:i', strtotime($post['created_at'])) ?></p>
                    </div>
                    <div>
                        <a href="<?= current_url() . "/edit/" . $post['id'] ?>" data-type="button" class="bg-sky-300 inline-block p-1">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#000">
                                    <path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l498-498q11-11 23.84-16 12.83-5 27-5 14.16 0 27.16 5t24 16l51 51q11 11 16 24t5 26.54q0 14.45-5.02 27.54T795-642L297-144H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z" />
                                </svg>
                            </div>
                        </a>
                        <button class="border-none bg-red-400 rounded-md" data-delete="<?= $post['id'] ?>">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#b91c1c">
                                    <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="">
                        <p class="text-justify"> <?= $post['title'] ?> </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <?php
                        foreach ($post['attachments'] as $attach):
                        ?>
                            <div style="flex: 1 1 calc(33.333% - 10px); box-sizing: border-box;">
                                <img src="<?= $attach['url'] ?>" alt="<?= $attach['original_name'] ?>" class="w-full h-auto block">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- CARD -->
        <!-- <div data-card="" class="bg-slate-200 border rounded-md shadow-md p-3 w-[30rem] space-y-3">
            <div class="flex justify-between items-center border-b border-black">
                <div>
                    <h3 class="font-medium">Rahmat</h3>
                    <p class="text-sm">date</p>
                </div>
                <div>
                    action btn
                </div>
            </div>
            <div class="space-y-2">
                <div class="">
                    <p class="text-justify ">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde delectus in magni doloribus repudiandae magnam omnis labore esse, quisquam soluta eaque ducimus sequi, iure beatae veniam cumque amet totam consequatur cupiditate incidunt cum! Quo quaerat consequuntur dolores, vero, fugiat asperiores, cum similique saepe obcaecati consequatur ratione? Deserunt, amet? Eum, ipsa!</p>
                </div>
                <div>
                    image
                </div>
            </div>
        </div> -->
        <!-- END CARD  -->

    </div>
    <div></div>
</section>
<?= $this->endSection() ?>
<?= $this->section('script_js') ?>

<script>
    $(document).ready(function() {
        $('button[data-delete]').on('click', async function() {
            const confirm = await Prompts.confirm('Apakah anda yakin ingin menghapus post ini?');
            if (confirm) {
                const id = $(this).attr('data-delete');
                const currentUrl = window.location.href;
                const anchor = $('<a>').attr('href', currentUrl.concat('/delete/', id)).addClass('hidden');
                $(this).append(anchor);
                anchor[0].click();
            } else {

            }
        });
    });
</script>
<?= $this->endSection() ?>