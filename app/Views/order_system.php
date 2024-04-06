<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
<div role="tablist" class="tabs tabs-lifted mt-5 w-full md:w-4/6 m-auto">
    <!-- colors -->
    <input type="radio" name="order_status" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Not started" checked/>
    <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10">
        <section class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <?php for ($i = 0; $i < 5; $i++): ?>
                <?php include 'templates/components/order_item_card.php' ?>
            <?php endfor; ?>
        </section>
    </div>
    <input type="radio" name="order_status" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="In progress"/>
    <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10">
        <section class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <?php for ($i = 0; $i < 3; $i++): ?>
                <?php include 'templates/components/order_item_card.php' ?>
            <?php endfor; ?>
        </section>
    </div>
    <input type="radio" name="order_status" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Complete"/>
    <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10">
        <section class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <?php include 'templates/components/order_item_card.php' ?>
            <?php endfor; ?>
        </section>
    </div>
</div>

<dialog id="status_md" class="modal">
    <div class="modal-box p-5">
        <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold mb-5 text-accent text-xl">Update item status</h3>
        <p class="mb-5 text-secondary">Note: Some notes</p>
        <div class="flex flex-row gap-2">
            <button class="btn btn-sm btn-neutral">Not started</button>
            <button class="btn btn-sm btn-accent">In progress</button>
            <button class="btn btn-sm btn-success">Complete</button>
        </div>
    </div>
</dialog>
<?= $this->endSection(); ?>