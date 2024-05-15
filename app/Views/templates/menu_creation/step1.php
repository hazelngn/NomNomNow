<template id="step1Template">
    <h3 class="text-xl text-center font-bold mb-5 lg:text-2xl">
        <?= !isset($menu) ? 'Create your menu' : 'Edit menu ' . esc($menu['name']) ?>
    </h3>
    <form id="step-1" class="flex flex-col p-5 w-full gap-5" aria-label="Menu Information">
        <div class="flex flex-col gap-2">
            <label for="name">Menu name</label>
            <input type="text" name="name" id="name" class="p-2 rounded-lg" required
                value="<?= !isset($menu) ? '' : esc($menu['name']) ?>"
                aria-labelledby="nameLabel"
                
            >
        </div>
        <div class="flex flex-col gap-2">
            <label for="start_date">Start date</label>
            <input type="date" name="start_date" id="start_date" class="p-2 rounded-lg" required
                value="<?= !isset($menu) ? '' : esc($menu['start_date']) ?>"
                aria-labelledby="startDateLabel"
            >
        </div>
        <div class="flex flex-col gap-2">
            <label for="end_date">End date</label>
            <input type="date" name="end_date" id="end_date" class="p-2 rounded-lg"
                value="<?= !isset($menu) ? '' : esc($menu['end_date']) ?>"
                aria-labelledby="endDateLabel"
            >
        </div>
        <input type="hidden" value="<?= session()->get('userId') ?>" id="userId" name="last_edited_by">
        <input type="hidden" value="<?= $business['id'] ?>" id="businessId" name="business_id"> 
        <input type="hidden" id="menuId" name="id" value="<?= !isset($menu) ? '' : esc($menu['id']) ?>">
        <?= csrf_field() ?>
    </form>
</template>
