<h3 class="text-xl text-center font-bold mb-5 lg:text-2xl">
    Review your menu
</h3>
<section>
    <div role="tablist" class="tabs tabs-lifted mr-3">
        <!-- colors -->
        <input type="radio" name="category" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Entree"/>
        <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 rounded-box p-6 z-10">
            <?php foreach ($items as $item): ?>
                <?php if ($item["category_id"] == 1):  ?>
                    <div class="card w-11/12 bg-neutral shadow-base m-auto md:w-5/12 lg:basis-4/12 md:basis-5/12 md:grow-0">
                        <figure><img src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="Shoes" /></figure>
                        <div class="card-body p-4 text-xs">
                            <h2 class="card-title text-sm font-bold flex justify-between">
                                <?= $item['name'] ?>
                                <button onclick="item_details.showModal()">
                                    <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square self-baseline"></i>
                                </button>
                            </h2>
                            <p><?= $item['description'] ?></p>
                            <p><?= $item['price'] ?></p>
                            <div class="card-actions justify-end">
                                <?php if (isset($item['dietaries'])): ?>
                                    <?php foreach ($item['dietaries'] as $dietary): ?>
                                        <div class="badge badge-outline badge-accent text-xs"><?= $dietary ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <input type="radio" name="category" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Dessert" checked/>
        <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 rounded-box p-6 z-10">
            <?php foreach ($items as $item): ?>
                <?php if ($item["category_id"] == 4):  ?>
                    <div class="card w-11/12 bg-neutral shadow-base m-auto lg:w-4/12 lg:basis-4/12 md:basis-5/12 md:grow-0">
                        <figure class="float-left" ><img src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="Shoes" /></figure>
                        <div class="card-body p-4 text-xs">
                            <h2 class="card-title text-sm font-bold flex justify-between">
                                <?= $item['name'] ?>
                                <button onclick="item_details.showModal()">
                                    <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square self-baseline"></i>
                                </button>
                            </h2>
                            <p><?= $item['description'] ?></p>
                            <p><?= $item['price'] ?></p>
                            <div class="card-actions justify-end">
                                <?php if (isset($item['dietaries'])): ?>
                                    <?php foreach ($item['dietaries'] as $dietary): ?>
                                        <div class="badge badge-outline badge-accent text-xs"><?= $dietary ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <input type="radio" name="category" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Coffee & Tea" />
        <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 rounded-box p-6 z-10">
            <?php foreach ($items as $item): ?>
                <?php if ($item["category_id"] == 6):  ?>
                    <div class="card w-11/12 bg-neutral shadow-base m-auto lg:w-4/12 lg:basis-4/12 md:basis-5/12 md:grow-0">
                        <figure class="float-left" ><img src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="Shoes" /></figure>
                        <div class="card-body p-4 text-xs">
                            <h2 class="card-title text-sm font-bold flex justify-between">
                                <?= $item['name'] ?>
                                <button onclick="item_details.showModal()">
                                    <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square self-baseline"></i>
                                </button>
                            </h2>
                            <p><?= $item['description'] ?></p>
                            <p><?= $item['price'] ?></p>
                            <div class="card-actions justify-end">
                                <?php if (isset($item['dietaries'])): ?>
                                    <?php foreach ($item['dietaries'] as $dietary): ?>
                                        <div class="badge badge-outline badge-accent text-xs"><?= $dietary ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="flex justify-end mr-3">
    <button class="btn btn-accent w-4/12 mt-11">Save</button>
</section>