<!-- Template for the item card in the order system -->

<template id="order-item">
    <section class="indicator w-full flex flex-row p-5 mb-5 md:p-5 rounded-3xl bg-neutral items-center md:flex-col md:basis-5/12 md:grow-0 lg:basis-3/12" role="region" aria-label="Order Details">
        <span class="indicator-item badge badge-secondary badge-sm" aria-hidden="true"></span>
        <section id="details" class="cursor-pointer flex flex-col gap-3 w-10/12 md:w-full md:text-lg">
            <h2 class="flex justify-between font-bold text-md" aria-label="Menu item name">
                Greek Salad
            </h2>
            <section class="flex flex-row justify-between">
                <p aria-label="Order table number">Table: 1</p>
            </section>
        </section>
    </section>
</template>



