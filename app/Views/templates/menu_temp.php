 <!-- Categories -->
<section>
    <div id="categories" class="flex flex-row flex-nowrap gap-1 pb-3 text-center justify-evenly overflow-scroll md:overflow-hidden">
        <template id="categoryTemplate">
            <div class="basis-1/5 md:basis-28 shrink-0 grow-0">
                <input type="radio" name="categories" id="" value="" class="categories opacity-0 w-0 h-0"/>
                <!-- opacity not working with peer-checked -->
                <label class="cursor-pointer opacity-50 " for="">
                    <img class="w-4/6 m-auto mb-1" src=""  alt="">
                </label>
                <h5 class=""></h5>
            </div>
        </template>
    </div>
    <section id="items" class="p-3 flex flex-col md:flex-row gap-3 flex-wrap md:w-4/6 m-auto">
        <template id="itemContainerTemplate">
            <div class="flex-col gap-4 hidden justify-evenly md:flex-row mt-5 flex-grow flex-wrap">
                <?php include 'components/item_card.php' ?>
            </div>
        </template>
    </section>
</section>

<?php include 'components/item_details.php' ?>

<dialog id="cart" class="modal">
    <div class="modal-box p-10">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold mb-5 text-accent text-xl">Your cart</h3>
        <section class="flex flex-col gap-3 md:text-lg md:flex-row md:flex-wrap">
            <?php if (isset($categories)): ?>
                <?php foreach ($items as $item): ?>
                    <?php include 'components/item_card.php' ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        <div class="flex flex-row items-center justify-between mt-5">
            <p class="text-lg">Total: $20</p>
            <button class="btn btn-accent">Check out</button>
        </div>
    </div>
</dialog>