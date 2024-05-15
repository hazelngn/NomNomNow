<!-- Template for the modal for item details when customer view a menu -->

<template id="itemDetailModalTemplate">
    <dialog id="item_detail" class="modal" role="dialog" aria-labelledby="itemDialogTitle" aria-describedby="itemDialogContent">
        <div class="modal-box p-7 md:p-10">
            <form method="dialog">
                <button id="closeModal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">&#10005;</button>
            </form>
            <section>
                <section>
                    <img class="w-1/3 m-auto" src="" alt="" aria-hidden="true">
                </section>
                <section id="mainContent" class="flex flex-col gap-2 md:text-lg">
                    <div class="flex flex-col font-body font-bold mt-2 text-xl md:text-2xl">
                        <section class="flex flex-row justify-between">
                            <h3 class="text-accent" aria-label="Menu item name">Food</h3>
                            <p class="text-accent" aria-label="Price">$10</p>
                        </section>
                        <?php if (isset($customer_view)): ?>
                            <div class="flex flex-row gap-2 items-center m-auto mt-2 ">
                                <i id="lessBtn" class="text-accent text-base  fa-solid fa-circle-minus md:text-2xl" aria-label="Decrease Quantity"></i>
                                <p id="quantity" aria-label="Quantity">0</p>
                                <i id="moreBtn" class="text-accent text-base fa-solid fa-circle-plus md:text-2xl" aria-label="Increase Quantity"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <hr class="border-base-content">
                    <p id="desc" class="text-accent" aria-label="Description">Description</p>
                    <p id="ingre" class="text-accent" aria-label="Ingredients">Ingredients</p>
                    
                    <?php if (isset($customer_view)): ?>
                        <!-- <label for="notes" class="text-accent" >Notes to staffs:</label>
                        <textarea name="notes" id="notes" class="textarea textarea-accent" ></textarea> -->
                        <button id="addCartBtn" class="btn btn-accent btn-sm mt-2 md:btn-md" aria-label="Update Cart">Update cart</button>
                    <?php endif; ?>
                </section>
            </section>
        </div>
    </dialog>
</template>


