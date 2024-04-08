 <!-- Categories -->
<section>
    <div class="flex flex-row flex-nowrap gap-1 pb-3 text-center justify-evenly overflow-scroll md:overflow-hidden">
        <?php foreach ($categories as $category): ?>
            <div class="basis-1/5 md:basis-28 shrink-0 grow-0">
                <input type="radio" name="categories" id="<?= $category['id'] ?>" value="<?= $category['id'] ?>" class="categories opacity-0 w-0 h-0" checked/>
                <!-- opacity not working with peer-checked -->
                <label class="cursor-pointer opacity-50 " for="<?= $category['id'] ?>">
                    <img class="w-4/6 m-auto mb-1" src="<?= base_url($category['iconUrl']) ?>"  alt="">
                    <?= $category['name'] ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <section class="p-3 flex flex-col md:flex-row gap-3 flex-wrap md:w-4/6 m-auto">
        <?php foreach ($categories as $category): ?>
            <div class="mt-5 hidden" id="content-<?=$category['id'] ?>">
                <?php foreach ($items as $item): ?>
                    <?php if ($item["category_id"] == $category['id']):  ?>
                        <span >
                            <?php include 'components/item_card.php' ?>
                        </span>

                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </section>
</section>

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

<dialog id="cart" class="modal">
    <div class="modal-box p-10">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold mb-5 text-accent text-xl">Your cart</h3>
        <section class="flex flex-col gap-3 md:text-lg md:flex-row md:flex-wrap">
            <?php foreach ($items as $item): ?>
                <?php include 'components/item_card.php' ?>
            <?php endforeach; ?>
        </section>
        <div class="flex flex-row items-center justify-between mt-5">
            <p class="text-lg">Total: $20</p>
            <button class="btn btn-accent">Check out</button>
        </div>
    </div>
</dialog>

<script>
    let categoryInputs = document.getElementsByClassName('categories');
    categoryInputs[0].nextSibling.nextElementSibling.style.opacity = 1;
    document.getElementById(`content-1`).style.display = 'block';
    for (let i = 0; i < categoryInputs.length; i++) {
        categoryInputs[i].addEventListener('change', function() {
            if (categoryInputs[i].checked) {
                categoryInputs[i].nextSibling.nextElementSibling.style.opacity = 1;
                document.getElementById(`content-${i+1}`).style.display = 'block';
            }
            for (let j = 0; j < categoryInputs.length; j++) {
                if (i != j) {
                    categoryInputs[j].nextSibling.nextElementSibling.style.opacity = 0.5;
                    document.getElementById(`content-${j+1}`).style.display = 'none';
                }
            }
        })
    }
</script>