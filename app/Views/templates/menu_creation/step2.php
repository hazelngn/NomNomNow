<h3 class="text-xl text-center font-bold mb-5 lg:text-2xl">
    Add items for your menu
    <button onclick="item_creation.showModal()"><i class="text-accent text-lg lg:text-2xl fa-solid fa-circle-plus"></i></button>
</h3>
<?php if (!isset($items)): ?>
    <p>No items created yet.</p>
<?php else: ?>
    <section class="flex flex-col justify-center gap-5 mr-5 md:flex-row md:flex-wrap">
        <?php foreach ($items as $item): ?>
            <?php include __DIR__ . '/../components/item_card.php' ?>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
<div class="flex flex-row justify-evenly mt-5 lg:mt-11">
    <a class="<?= $step - 1 <= 0 ? 'pointer-events-none' : '' ?>"   href="<?= base_url('menu/addedit/' . $menu['id'] . '/' . ($step - 1) );  ?>">
        <i class="text-accent text-3xl fa-solid fa-circle-arrow-left <?= $step - 1 <= 0 ? 'text-neutral' : '' ?>" ></i>
    </a>
    <a href="<?= base_url('menu/addedit/' . $menu['id'] . '/' . ($step + 1) ); ?>">
        <i class="text-accent text-3xl fa-solid fa-circle-check"></i>
    </a>
</div>

<dialog id="item_detail_edit" class="modal">
    <div class="modal-box md:6/1 md:max-w-xl lg:w-8/12 lg:max-w-3xl">
        <form method="dialog" >
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form method="" action="#" class="flex flex-col p-5 gap-4">
            <h3 class="lg:text-3xl text-center text-accent text-xl">Edit your item</h3>
            <div class="flex flex-col gap-2">
                <label for="name">Item name</label>
                <input type="text" name="name" id="name" class="p-2 rounded-lg" value="Test">
            </div>
            <div class="flex flex-col gap-2">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="p-2 rounded-lg" value="Test">
            </div>
            <div class="flex flex-col gap-2">
                <label for="ingredients">Ingredients</label>
                <input type="text" name="ingredients" id="ingredients" class="p-2 rounded-lg" value="Test">
            </div>
            <div class="flex flex-col gap-2">
                <label for="notes">Notes</label>
                <input type="text" name="notes" id="notes" class="p-2 rounded-lg" value="Test">
            </div>
            <div class="flex flex-col gap-2">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="p-2 rounded-lg" value=10>
            </div>
            <div class="flex flex-col gap-2">
                <label for="image_img">Image</label>
                <input type="file" id="image_img" name="image_img" class="file-input file-input-bordered file-input-accent w-full max-w-xs file-input-sm lg:file-input-md" />
            </div>
            <input class="btn btn-accent" type="submit" value="Save">
        </form>
    </div>
</dialog>

<dialog id="item_creation" class="modal">
    <div class="modal-box md:6/1 md:max-w-xl lg:w-8/12 lg:max-w-3xl">
        <h3 class="lg:text-3xl text-center text-accent text-xl">Add a new item</h3>
        <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <form method="" action="#" class="flex flex-col p-5 gap-4">
            <div class="flex flex-col gap-2">
                <label for="name">Item name</label>
                <input type="text" name="name" id="name" class="p-2 rounded-lg" required>
            </div>
            <div>
                <label for="category_id">What category is this item?</label>

                <select class="p-2 rounded-lg" name="category_id" id="category_id">
                    <option value="1">Entrees</option>
                    <option value="2">Sides</option>
                    <option value="3">Main Dishes</option>
                    <option value="4">Desserts</option>
                    <option value="5">Alcoholic Beverages</option>
                    <option value="6">Coffee & Tea</option>
                    <option value="7">Soft Drinks</option>
                </select>
            </div>


            <div class="flex flex-col gap-2">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="p-2 rounded-lg" required>
            </div>
            <div class="flex flex-col gap-2">
                <label for="ingredients">Ingredients</label>
                <input type="text" name="ingredients" id="ingredients" class="p-2 rounded-lg" required>
            </div>
            <div class="flex flex-col gap-2">
                <label for="notes">Notes</label>
                <input type="text" name="notes" id="notes" class="p-2 rounded-lg">
            </div>
            <div class="flex flex-col gap-2">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="p-2 rounded-lg">
            </div>
            <div class="flex flex-col gap-2">
                <label for="image_img">Image</label>
                <input type="file" id="image_img" name="image_img" class="file-input file-input-bordered file-input-accent w-full max-w-xs file-input-sm lg:file-input-md" />
            </div>
            <input class="btn btn-accent" type="submit" value="Save">
        </form>
    </div>
</dialog>