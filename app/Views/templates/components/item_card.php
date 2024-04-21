<template id="item-card">
    <section class="flex flex-row p-3 md:p-6 rounded-3xl bg-neutral items-center md:flex-col md:basis-5/12 md:grow-0 md:w-5/12 lg:w-4/12
        <?=
            (service('router')->getMatchedRoute()[0] == 'onlineorder/([0-9]+)') ||
            (service('router')->getMatchedRoute()[0] == 'menu') ?
            'cursor-pointer' :
            '';
        ?>" onclick="item_detail.showModal()" >
        <section class="w-6/12 h-fit md:w-full">
            <img id="item-img" class="mask mask-hexagon-2 w-full" src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="">
        </section>
        <section class="flex flex-col gap-3 w-full md:text-lg">
            <h2 class="flex justify-between font-bold text-md md:mt-5">
                <p id="item-name"></p>
                <button onclick="item_detail_edit.showModal()">
                    <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square self-baseline"></i>
                </button>
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