<template id="itemDetailModalTemplate">
    <dialog id="item_detail" class="modal">
        <div class="modal-box p-10">
            <form method="dialog">
                <button id="closeModal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <section>
                <section>
                    <img class="w-1/3 m-auto" src="" alt="">
                </section>
                <section id="mainContent" class="flex flex-col gap-2 md:text-lg">
                    <div class="flex flex-row font-body font-bold justify-between mt-2 text-xl md:text-2xl">
                        <h3 class="text-accent">Food</h3>
                        <p class="text-accent">$10</p>
                    </div>
                    <hr class="border-base-content">
                    <p id="desc" class="text-accent">Description</p>
                    <p id="ingre" class="text-accent">Ingredients</p>
                    <div id="prefs" class="flex flex-row gap-2 flex-wrap">
                    </div>
                    <?php if (isset($customer_view)): ?>
                        <button class="btn btn-accent btn-sm mt-2 md:btn-md">Add to cart</button>
                    <?php endif; ?>
                </section>
            </section>
        </div>
    </dialog>
</template>