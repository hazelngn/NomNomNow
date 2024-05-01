<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <section class="flex gap-2 mt-5 p-2 items-baseline md:w-4/6 md:m-auto md:mt-11">
        <a href="<?= base_url("") ?>"><i class="text-neutral-content text-lg md:text-2xl fa-solid fa-chevron-left"></i></a>
        <h3 class="text-lg md:text-2xl">
            View menu <?= $menu['name'] ?>
        </h3>
        <a href="<?= base_url("menu/addedit/" . $menu['id']) ?>"><i class="text-accent text-lg md:text-2xl fa-solid fa-pen-to-square"></i></a>
    </section>

    <?php include 'templates/menu_temp.php' ?>
    
<?= $this->endSection(); ?>

