<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to tailwindcss in public directory -->
    <link rel="stylesheet" href="<?= base_url("styles/style.css") ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <?= $this->renderSection('header') ?>
    <title>
        <?= $this->renderSection('title') ?? "LCC Activity Platform" ?>
    </title>
</head>

<body>
    <div class="grid grid-cols-6 bg-[#064470]">
        <div class="px-2 py-3">
            <div class=" space-y-3">
                <div class="flex justify-center">
                    <img src="<?= base_url('logo/lcc_logo.jpg') ?>" alt="Logo" class="size-16">
                </div>
                <div class="text-center text-white">
                    <h2 class="font-bold text-lx">LCC Actifity Platform</h2>
                    <h3 class="font-semibold text-lg">Admin Panel</h3>
                </div>
            </div>
            <nav class="mt-5">
                <div>
                    <ul>
                        <li class="">
                            <?= view_cell('LinkSidebarCell', ['target_url' => base_url('a/admin/'), 'title' => 'Dashboard']) ?>
                        </li>
                        <li class="">
                            <?= view_cell('LinkSidebarCell', ['target_url' => base_url('a/admin/users'), 'title' => 'Users']) ?>
                        </li>
                        <li class="">
                            <?= view_cell('LinkSidebarCell', ['target_url' => base_url('a/admin/finances'), 'title' => 'Keuangan']) ?>
                        </li>
                        <li class="">
                            <?= view_cell('LinkSidebarCell', ['target_url' => base_url('a/admin/question-periods'), 'title' => 'Question Period']) ?>
                        </li>
                        <li>
                            <div class="expand-item" role="button" data-expand="testing">
                                <div class="py-2 px-1.5 text-white transition-all hover:bg-slate-200 hover:text-black truncate">
                                    <span class="font-semibold">
                                        Master
                                    </span>
                                </div>
                                <div data-expand-target="testing" class="pl-4" style="display: none;">
                                    <ul>
                                        <li>
                                            <?= view_cell('LinkSidebarCell', ['target_url' => base_url('a/admin/master/questions'), 'title' => 'Question Feedback']) ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="h-screen col-span-5 grid grid-rows-11">
            <div>
                <?= $this->renderSection('nav') ?>
            </div>
            <div class="row-span-10 bg-slate-200 p-2 rounded-md">
                <div class="bg-white rounded-md p-2">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>

        </div>
    </div>
    <?= $this->renderSection('footer') ?>
    <?= $this->renderSection('script_js') ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {
            $('.expand-item').each(function() {
                $(this).on('click', function() {
                    const expandName = $(this).attr('data-expand');
                    // alert(expandName);
                    $(`[data-expand-target=${expandName}]`).toggle();
                })
            })
        })
    </script>
    <!-- Alert message for show error and success  -->
    <?= $this->include('partial/alert_message.php') ?>
</body>

</html>