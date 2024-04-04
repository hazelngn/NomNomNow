<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <section class="flex flex-row items-baseline gap-3 pl-3 pr-3  mb-5 ">
        <h3 class="font-body text-accent text-2xl text-center font-boldlg:text-2xl">
            <?= $menu['name'] ?>
        </h3>
        <a href="<?= base_url("menu/addedit/1") ?>"><i class="text-xl text-accent lg:text-2xl fa-solid fa-pen-to-square"></i></a>
    </section>
    <section class="p-3">
        <div role="tablist" class="tabs tabs-lifted">
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
                                </h2>
                                <p><?= $item['description'] ?></p>
                                <p>$<?= $item['price'] ?></p>
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
                                </h2>
                                <p><?= $item['description'] ?></p>
                                <p>$<?= $item['price'] ?></p>
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
                                </h2>
                                <p><?= $item['description'] ?></p>
                                <p>$<?= $item['price'] ?></p>
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
<?= $this->endSection(); ?>