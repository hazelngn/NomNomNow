<!-- Template for the modal to add/edit a item in the menu -->

<template id="itemFormTemplate">
    <dialog id="item_form_detail" class="modal" aria-labelledby="itemFormDetailDialogTitle" aria-describedby="itemFormDetailDialogContent">
        <div class="modal-box md:6/1 md:max-w-xl lg:w-8/12 lg:max-w-3xl">
            <form method="dialog">
                <button id="close_modal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">&#10005;</button>
            </form>
            <form id="detail_form" class="flex flex-col p-5 gap-4" aria-label="Item Details Form">
                <h3 id="itemFormDetailDialogTitle" class="lg:text-3xl text-center text-accent text-xl"><span></span> your item</h3>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="name">Item name</label>
                    <input type="text" name="name" id="name" class="p-2 rounded-lg" required aria-required="true" aria-label="Item Name">
                </div>
                <div>
                    <label class="font-bold" for="category_id">What category is this item?</label>
                    <select class="p-2 rounded-lg" name="category_id" id="category_id" required aria-required="true" aria-label="Category">
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
                    <label class="font-bold" for="description">Description</label>
                    <textarea type="text" name="description" id="description" class="p-2 rounded-lg" required aria-required="true" aria-label="Description"></textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="ingredients">Ingredients</label>
                    <textarea type="text" name="ingredients" id="ingredients" class="p-2 rounded-lg" required aria-required="true" aria-label="Ingredients"></textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="notes">Notes</label>
                    <textarea type="text" name="notes" id="notes" class="p-2 rounded-lg" aria-label="Notes"></textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="price">Price</label>
                    <input type="number" min="0" step="any" name="price" id="price" class="p-2 rounded-lg" required aria-required="true" aria-label="Price">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="item_img">Image</label>
                    <input type="file" id="item_img" name="item_img" class="file-input file-input-bordered file-input-accent w-full max-w-xs file-input-sm lg:file-input-md" aria-label="Item Image">
                </div>
                <input id="submitBtn" class="btn btn-accent" type="submit" value="Save" aria-label="Save Button">
                <input type="hidden" id="id" name="id">
                <?= csrf_field() ?>
            </form>
        </div>
    </dialog>
</template>