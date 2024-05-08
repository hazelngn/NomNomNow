<template id="close_modal_form">
    <form method="dialog">
        <button id="close_modal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
</template>
<form id="business_form" class="flex flex-col gap-5" action="POST">
    <!-- Add some context where this shows and not, using aria-label,.... -->
    <h4></h4>
    <div class="flex flex-col gap-2">
        <label for="name">Business name</label>
        <input type="text" name="name" id="name" class="p-2 rounded-lg readonly:" placeholder="Enter your business name" value="<?= isset($business) ? $business['name'] : "" ?>" <?= isset($business) ? 'disabled' : '' ?> required>
    </div>
    <div class="flex flex-col gap-2">
        <label for="table_num">Number of table available</label>
        <input type="number" name="table_num" id="table_num" class="p-2 rounded-lg" required value=<?= isset($business) ? $business['table_num'] : "" ?> <?= isset($business) ? 'disabled' : '' ?> >
    </div>
    <div class="flex flex-col gap-2">
        <label for="description">Short description of your business</label>
        <textarea 
            id="description" 
            name="description" 
            class="textarea textarea-accent" 
            placeholder="Desription"  
            <?= isset($business) ? 'disabled' : '' ?>
        ><?= isset($business) ? $business['description'] : "" ?></textarea>
    </div>
    <div class="flex flex-col gap-2">
        <label for="logo">Logo of your business</label>
        <?php if (isset($business)): ?>
            <?php if (!empty($business['logo'])): ?>
                <p class="text-success md:text-sm italic text-xs">A file has been uploaded</p>
            <?php endif; ?>
        <?php endif; ?>
        <input type="file" id="logo" name="logo" class="file-input file-input-bordered file-input-accent w-full max-w-xs file-input-sm lg:file-input-md" <?= isset($business) ? 'disabled' : '' ?> />
    </div>
    <div class="flex flex-col gap-2">
        <label for="address">Your business's address</label>
        <input type="text" name="address" id="address" class="p-2 rounded-lg" placeholder="Enter your business address" required value="<?= isset($business) ? $business['address'] : "" ?>" <?= isset($business) ? 'disabled' : '' ?> >
    </div>
    <div class="flex flex-col gap-2">
        <label for="weekday_hours">Your business's weekday working hours</label>
        <input type="text" name="weekday_hours" id="weekday_hours" class="p-2 rounded-lg" placeholder="HH:mm-HH:mm" required value="<?= isset($business) ? $business['weekday_hours'] : "" ?>" <?= isset($business) ? 'disabled' : '' ?> >
    </div>
    <div class="flex flex-col gap-2">
        <label for="weekend_hours">Your business's weekend working hours</label>
        <input type="text" name="weekend_hours" id="weekend_hours" class="p-2 rounded-lg" placeholder="HH:mm-HH:mm"required value="<?= isset($business) ? $business['weekend_hours'] : "" ?>" <?= isset($business) ? 'disabled' : '' ?> >
    </div>
    <input type="hidden" id="businessId" name="id" value="<?= isset($business) ? $business['id']: ""?>">
</form>