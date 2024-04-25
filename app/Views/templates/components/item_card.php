<template id="item-card">
    <section class="flex flex-row p-3 md:p-6 rounded-3xl bg-neutral items-center md:flex-col md:w-4/12 md:grow-0" >
        <section class="w-6/12 h-fit md:w-full sm:p-3">
            <img id="item-img" class="w-2/3 m-auto md:w-2/5" alt="">
        </section>
        <section class="flex flex-col gap-3 w-full md:text-lg">
            <h2 class="flex justify-between font-bold text-md md:mt-5 gap-1">
                <p id="item-name"></p>
                <?php if (!isset($menu_viewing)): ?>
                    <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square self-baseline"></i>
                <?php endif; ?>
            </h2>
            <div class="flex flex-row justify-between">
                <p id="item-price"></p>
                <?php if (isset($customer_view)): ?>
                    <div class="flex flex-row gap-2 items-center">
                        <i class="text-accent text-base fa-solid fa-circle-minus"></i>
                        <p>0</p>
                        <i class="text-accent text-base fa-solid fa-circle-plus"></i>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </section>
</template>