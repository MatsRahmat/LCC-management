<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php if (session()->getFlashdata('error')): ?>
        <p>
            <?= session()->getFlashdata('error') ?>
        </p>
    <?php endif ?>

    <?php if (session()->get('alert')): ?>
        <p>
            <?= session()->get('alert'); ?>
        </p>
    <?php endif ?>

    <form action="<?= base_url("auth/pushLogin") ?>" method="post">
        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <button type="submit">
                Login
            </button>
        </div>
    </form>

</body>

</html>