<style>
    .text-helper {
        font-size: small;
        font-weight: 600;
        color: <?= $type == "error" ? "#dc2626" : "#000" ?>;
    }
</style>

<p class="text-helper" style="color: <?= $type == "error" ? "#dc2626" : "#000" ?> ;"><?= $message ?></p>