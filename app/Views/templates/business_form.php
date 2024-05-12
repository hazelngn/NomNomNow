<template id="close_modal_form">
    <form method="dialog">
        <button id="close_modal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">&#10005;</button>
    </form>
</template>
<form id="business_form" class="flex flex-col gap-5" action="POST" aria-label="Business Form">
    <h4 aria-label="Business Information"></h4>
    <div class="flex flex-col gap-2">
        <label for="name">Business name</label>
        <input type="text" name="name" id="name" class="p-2 rounded-lg readonly:" placeholder="Enter your business name" value="<?= isset($business) ? esc($business['name']) : "" ?>" <?= isset($business) ? 'disabled' : '' ?> required aria-required="true" aria-label="Business Name">
    </div>
    <div class="flex flex-col gap-2">
        <label for="table_num">Number of tables available</label>
        <input type="number" name="table_num" id="table_num" class="p-2 rounded-lg" required value="<?= isset($business) ? esc($business['table_num']) : "" ?>" <?= isset($business) ? 'disabled' : '' ?> aria-label="Number of Tables" aria-required="true">
    </div>
    <div class="flex flex-col gap-2">
        <label for="description">Short description of your business</label>
        <textarea 
            id="description" 
            name="description" 
            class="textarea textarea-accent" 
            placeholder="Description"  
            <?= isset($business) ? 'disabled' : '' ?>
            aria-label="Business Description"
        ><?= isset($business) ? esc($business['description']) : "" ?></textarea>
    </div>
    <div class="flex flex-col gap-2">
        <label for="logo">Logo of your business</label>
        <?php if (isset($business)): ?>
            <?php if (!empty($business['logo'])): ?>
                <p class="text-success md:text-sm italic text-xs" aria-label="File Uploaded">A file has been uploaded</p>
            <?php endif; ?>
        <?php endif; ?>
        <input type="file" id="logo" name="logo" class="file-input file-input-bordered file-input-accent w-full max-w-xs file-input-sm lg:file-input-md" <?= isset($business) ? 'disabled' : '' ?> aria-label="Business Logo">
    </div>
    <div class="flex flex-col gap-2">
        <label for="address">Your business's address</label>
        <input type="text" name="address" id="address" class="p-2 rounded-lg" placeholder="Enter your business address" required value="<?= isset($business) ? esc($business['address']) : "" ?>" <?= isset($business) ? 'disabled' : '' ?> aria-label="Business Address">
    </div>
    <div class="flex flex-col gap-2">
        <label for="weekday_hours">Your business's weekday working hours</label>
        <input type="text" name="weekday_hours" id="weekday_hours" class="p-2 rounded-lg" placeholder="HH:mm-HH:mm" required value="<?= isset($business) ? esc($business['weekday_hours']) : "" ?>" <?= isset($business) ? 'disabled' : '' ?> aria-label="Weekday Working Hours">
    </div>
    <div class="flex flex-col gap-2">
        <label for="weekend_hours">Your business's weekend working hours</label>
        <input type="text" name="weekend_hours" id="weekend_hours" class="p-2 rounded-lg" placeholder="HH:mm-HH:mm" required value="<?= isset($business) ? esc($business['weekend_hours']) : "" ?>" <?= isset($business) ? 'disabled' : '' ?> aria-label="Weekend Working Hours">
    </div>
    <input type="hidden" id="businessId" name="id" value="<?= isset($business) ? esc($business['id']) : ""?>" aria-hidden="true">
</form>