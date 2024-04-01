<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <?php include 'templates/menu_skeleton.php' ?>
    <script>
        function submitForm() {
            document.getElementById("menu_creation").submit();
        }
    </script>
<?= $this->endSection(); ?>