<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to tailwindcss in public directory -->
    <link rel="stylesheet" href="<?= base_url("styles/style.css") ?>">
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
    <!-- Local JQUERY -->
    <script src="<?= base_url('js/jquery-3.4.1.min.js') ?>"></script>
    <?= $this->renderSection('header') ?>
    <title>
        <?= $this->renderSection('title') || "LCC Activity Platform" ?>
    </title>
</head>

<body>
    <?= $this->renderSection('nav') ?>
    <?= $this->renderSection('content') ?>
    <?= $this->renderSection('footer') ?>
    <?= $this->renderSection('script_js') ?>
    <?= $this->include('partial/alert_message.php') ?>
</body>

</html>