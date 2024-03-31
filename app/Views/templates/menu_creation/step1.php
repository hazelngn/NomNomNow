<h3 class="text-base text-center font-bold mb-5">Choose categories for your menu</h3>
<form class="flex flex-row flex-wrap justify-evenly">
    <?php foreach ($categories as $cat => $url): ?>
        <div class="grow-0 basis-5/12 mb-3 text-center">
            <img class="max-w-16 mb-3 m-auto" src="<?= base_url($url) ?>" alt="<?= $cat ?>">
            <div class="flex flex-row items-center gap-2 justify-center">
                <input type="checkbox" class="checkbox" id="<?= $cat ?>" name="<?= $cat ?>" value="<?= $cat ?>">
                <label for="<?= $cat ?>"><?= $cat ?></label>
            </div>
        </div>
    <?php endforeach; ?>
</form>