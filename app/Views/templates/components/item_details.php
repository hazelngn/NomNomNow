<dialog id="item_detail" class="modal">
    <div class="modal-box p-10">
        <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <section>
            <section>
                <img class="mask mask-hexagon-2 h-28 w-full" src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="">
            </section>
            <section class="flex flex-col gap-2 md:text-lg">
                <div class="flex flex-row font-body font-bold justify-between mt-2 text-xl md:text-2xl">
                    <h3>Food</h3>
                    <p>$10</p>
                </div>
                <p>Some description</p>
                <p>Some ingrdients</p>
                <div class="flex flex-row gap-2 flex-wrap">
                    <div class="badge badge-accent badge-outline shrink-0 md:text-md md:p-3">Diet 1</div>
                    <div class="badge badge-accent badge-outline shrink-0 md:text-md md:p-3">Diet 2</div>
                </div>
                <?php if (service('router')->getMatchedRoute()[0] == 'onlineorder/([0-9]+)'): ?>
                    <button class="btn btn-accent btn-sm mt-2 md:btn-md">Add to cart</button>
                <?php endif; ?>
            </section>
        </section>
    </div>
</dialog>