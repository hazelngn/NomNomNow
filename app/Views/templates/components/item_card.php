<template id="item-card">
    <section class="flex flex-row p-3 gap-3 md:p-4 rounded-3xl bg-neutral items-center md:flex-col md:w-5/12 lg:w-4/12 md:grow-0" >
        <section class="w-6/12 h-fit md:w-full sm:p-3">
            <img id="item-img" class="w-full m-auto" alt="">
        </section>
        <section class="flex flex-col gap-3 w-full md:text-lg">
            <section class="flex flex-row items-baseline justify-between">
                <h2 class="flex justify-between font-bold text-md md:mt-5 gap-2 flex-col">
                    <p id="item-name"></p>
                </h2>
                <section class="flex flex-row justify-between">
                    <p id="item-price"></p>
                </section>
            </section>
            <?php if (!isset($menu_viewing)): ?>
                <section class="flex gap-2 md:place-content-center">
                        <i id="editBtn" class="cursor-pointer text-cyan-400 text-base lg:text-xl fa-solid fa-pen-to-square"></i>
                        <i id="deleteBtn" class="cursor-pointer text-red-500 text-base lg:text-xl fa-solid fa-trash-can"></i>
                </section>
            <?php endif; ?>
            <?php if (isset($customer_view)): ?>
                <button id="orderBtn" class="btn btn-sm btn-base w-1/2 md:w-full self-end">Order</button>
            <?php endif; ?>
        </section>
    </section>
</template>