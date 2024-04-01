<h3 class="text-xl text-center font-bold mb-5">
    Add items for your menu
    <i class="text-accent text-lg lg:text-2xl fa-solid fa-circle-plus"></i>
</h3>
<?php if (!isset($items)): ?>
    <p>No items created yet.</p>
<?php else: ?>
    <section class="flex flex-col justify-center gap-5">
        <?php foreach ($items as $item): ?>
            <div class="card w-9/12 h-6/12 bg-neutral shadow-base m-auto">
                <figure><img src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="Shoes" /></figure>
                <div class="card-body p-4 text-xs">
                    <h2 class="card-title text-sm font-bold">
                        <?= $item['name'] ?>
                    </h2>
                    <p><?= $item['description'] ?></p>
                    <p><?= $item['price'] ?></p>
                    <div class="card-actions justify-end">
                        <?php if (isset($item['dietary'])): ?>
                            <?php foreach ($item['dietaries'] as $dietary): ?>
                                <div class="badge badge-outline"><?= $dietary ?></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>