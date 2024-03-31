<div class="flex flex-col gap-2">
    <label for="business_name">Business name</label>
    <input type="text" name="business_name" id="business_name" class="p-2 rounded-lg readonly:" placeholder="Enter your business name" required <?= $editMode ? '' : 'disabled' ?> value="Example">
</div>
<div class="flex flex-col gap-2">
    <label for="tables">Number of tables available</label>
    <input type="number" name="tables" id="tables" class="p-2 rounded-lg" required <?= $editMode ? '' : 'disabled' ?> value="20">
</div>
<div class="flex flex-col gap-2">
    <label for="desc">Short description of your business</label>
    <textarea id="desc" name="desc" class="textarea textarea-accent" placeholder="Description" <?= $editMode ? '' : 'disabled' ?> value="A restaurant serving Korean food"></textarea>
</div>
<div class="flex flex-col gap-2">
    <label for="logo">Logo of your business</label>
    <input type="file" id="logo" name="logo" class="file-input file-input-bordered file-input-accent w-full max-w-xs file-input-sm lg:file-input-md" <?= $editMode ? '' : 'disabled' ?>/>
</div>
<div class="flex flex-col gap-2">
    <label for="address">Your business's address</label>
    <input type="text" name="address" id="address" class="p-2 rounded-lg" placeholder="Enter your business address" required <?= $editMode ? '' : 'disabled' ?> value="Brisbane CBD">
</div>