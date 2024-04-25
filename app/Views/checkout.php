<?= $this->extend('template_customer'); ?>
<?= $this->section('content'); ?>
   <?= json_encode($order_items) ?>

   <?php include "helpers/api_calls.php" ?>
   <script>

   </script>
<?= $this->endSection(); ?>