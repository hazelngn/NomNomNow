<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
   <?php include "templates/menu_temp.php" ?>
   <?php include "helpers/api_calls.php" ?>
<?= $this->endSection(); ?>