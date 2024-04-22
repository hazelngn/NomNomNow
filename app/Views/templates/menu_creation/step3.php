<template id="step3Template">
    <h3 class="text-xl text-center font-bold mb-5 lg:text-2xl">
        <?= $menu['name'] ?>
    </h3>
    <section>
        <div role="tablist" class="tabs tabs-lifted mr-3">
            <!-- colors -->
            <input type="radio" name="category" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Ent~ree"/>
            <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 rounded-box p-6 z-10">
                <?php foreach ($items as $item): ?>
                    <?php if ($item["category_id"] == 1):  ?>
                        <?php include __DIR__ . '/../components/item_card.php' ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
    
            <input type="radio" name="category" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Dessert" checked/>
            <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 rounded-box p-6 z-10">
                <?php foreach ($items as $item): ?>
                    <?php if ($item["category_id"] == 4):  ?>
                        <?php include __DIR__ . '/../components/item_card.php' ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
    
            <input type="radio" name="category" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Coffee & Tea" />
            <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 rounded-box p-6 z-10">
                <?php foreach ($items as $item): ?>
                    <?php if ($item["category_id"] == 6):  ?>
                        <?php include __DIR__ . '/../components/item_card.php' ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section class="flex justify-end mr-3">
        <a  class="btn btn-accent w-4/12 mt-11" id="saveBtn">Save</a>
    
    </section>
</template>