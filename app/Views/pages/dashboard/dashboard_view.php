<?= $this->extend('layouts/base_layout.php') ?>

<?= $this->section('nav') ?>
<?= $this->include('partial/user_navbar.php') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="scroll-smooth snap-y snap-mandatory overflow-y-auto" style="height: calc(100dvh - 4rem);">
    <section style="height: calc(100dvh - 4.2rem);" class="bg-orange-400 snap-start snap-always">
        <div>
            Lorem ipsum dolor sit amet.
        </div>
    </section>
    <section style="height: calc(100dvh - 5rem);" class="bg-green-400 snap-start snap-always">
        <div>
            Lorem ipsum dolor sit amet.
        </div>
    </section>
    <section style="height: calc(100dvh - 5rem);" class="bg-slate-400 snap-start snap-always">
        <div>
            Lorem ipsum dolor sit amet.
        </div>
    </section>
    <section style="height: calc(100dvh - 5rem);" class="bg-stone-600 snap-start snap-always">
        <div>
            Lorem ipsum dolor sit amet.
        </div>
    </section>
</main>
<?= $this->endSection() ?>