<h3 class="text-xl text-center font-bold mb-5 lg:text-2xl">Create your menu</h3>
<form id="menu_creation" method="post" action="<?= base_url('menu/' . $business['id'] . '/' . ($step + 1)) ?>" class="flex flex-col p-5 w-full gap-5">
    <div class="flex flex-col gap-2">
        <label for="name">Menu Name</label>
        <input type="text" name="name" id="name" class="p-2 rounded-lg" required>
    </div>
    <div class="flex flex-col gap-2">
        <label for="start_date">The start date of this menu</label>
        <input type="date" name="start_date" id="start_date" class="p-2 rounded-lg" required>
    </div>
    <div class="flex flex-col gap-2">
        <label for="start_date">The end date of this menu</label>
        <input type="date" name="start_date" id="start_date" class="p-2 rounded-lg">
    </div>
    <div class="flex flex-row justify-evenly mt-5">
        <a class="<?= $step - 1 <= 0 ? 'pointer-events-none' : '' ?>"   href="<?= base_url('menu/' . $business['id'] . '/' . ($step - 1) );  ?>">
            <i class="text-accent text-3xl fa-solid fa-circle-arrow-left <?= $step - 1 <= 0 ? 'text-neutral' : '' ?>" ></i>
        </a>
        <button type="submit">
            <i class="text-accent text-3xl fa-solid fa-circle-arrow-right" ></i>
        </button>
    </div>
</form>