<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to tailwindcss in public directory -->
    <link rel="stylesheet" href="<?= base_url("styles/style.css") ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <?= $this->renderSection('header') ?>
    <title>
        <?= $this->renderSection('title') ?? "LCC Activity Platform" ?>
    </title>
</head>

<body>
    <div class="grid grid-cols-6 bg-[#064470]">
        <div class="px-2 py-3">
            <div class=" space-y-3">
                <div>
                    <img src="logo" alt="Logo">
                </div>
                <div>
                    <h2>LCC Actifity Platform</h2>
                    <h3>Admin Panel</h3>
                </div>
            </div>
            <nav class="mt-5">
                <div>
                    <ul>
                        <li class="">
                            <?= anchor(base_url('/a/admin/users'), 'Dashboard') ?>
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
</body>

</html>