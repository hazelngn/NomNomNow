<template id="step1Template">
    <h3 class="text-xl text-center font-bold mb-5 lg:text-2xl">
        <?= !isset($menu) ? 'Create your menu' : 'Edit menu ' . $menu['name'] ?>
    </h3>
    <form id="step-1" class="flex flex-col p-5 w-full gap-5">
        <div class="flex flex-col gap-2">
            <label for="name">Menu name</label>
            <input type="text" name="name" id="name" class="p-2 rounded-lg" required
                value="<?= !isset($menu) ? '' : $menu['name'] ?>"
            >
        </div>
        <div class="flex flex-col gap-2">
            <label for="start_date">The start date of this menu</label>
            <input type="date" name="start_date" id="start_date" class="p-2 rounded-lg" required
                value="<?= !isset($menu) ? '' : $menu['start_date'] ?>"
            >
        </div>
        <div class="flex flex-col gap-2">
            <label for="end_date">The end date of this menu</label>
            <input type="date" name="end_date" id="end_date" class="p-2 rounded-lg"
                value="<?= !isset($menu) ? '' : $menu['end_date'] ?>"
            >
        </div>
        <input type="hidden" value=<?= session()->get('userId') ?> id="userId" name="last_edited_by">
        <input type="hidden" value="<?= $business['id'] ?>" id="businessId" name="business_id"> 
        <input type="hidden" id="menuId" name="id" value="<?= !isset($menu) ? '' : $menu['id'] ?>">

    </form>
</template>
