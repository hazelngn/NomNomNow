<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section class="flex flex-col lg:flex-row flex-wrap justify-evenly mt-5">
        <div class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12">
            <input type="radio" name="my-accordion-2" checked="checked" /> 
            <div class="collapse-title text-xl font-medium flex flex-row gap-3">
                <i class="inline-block text-accent text-3xl fa-solid fa-book-open"></i>
                <h3 class="text-xl lg:text-3xl">Menus</h3>
            </div>
            <div class="collapse-content bg-neutral"> 
                <ul>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Regular</li>
                        <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square"></i>
                    </div>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Drinks</li>
                        <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square"></i>
                    </div>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Specials</li>
                        <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square"></i>
                    </div>
                    <!-- lg:tooltip doesn't work -->
                    <div class="w-full flex justify-center pt-3 tooltip tooltip-accent" data-tip="Add new menu">
                        <i class="text-accent text-lg lg:text-2xl fa-solid fa-circle-plus"></i>
                    </div>
                </ul>
            </div>
        </div>
        <div class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12">
            <input type="radio" name="my-accordion-2" /> 
            <div class="collapse-title text-xl font-medium flex flex-row gap-3 w-full">
                <i class="inline-block text-accent text-3xl fa-solid fa-circle-info"></i>
                <h3 class="text-xl lg:text-3xl">Business Information</h3>
            </div>
            <div class="collapse-content  bg-neutral flex flex-col gap-3"> 
                <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square text-end mt-3"></i>
                <form class="flex flex-col gap-5">
                    <?= $editMode = FALSE; include "templates/business_form.php"; ?>
                </form>
            </div>
        </div>
        <div class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12">
            <input type="radio" name="my-accordion-2" /> 
            <div class="collapse-title text-xl font-medium flex flex-row gap-3 w-full">
                <i class="inline-block text-accent text-3xl fa-solid fa-qrcode"></i>
                <h3 class="text-xl lg:text-3xl">QR Codes</h3>
            </div>
            <div class="collapse-content bg-neutral"> 
                <ul>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Table 1</li>
                        <i class="text-info text-base lg:text-xl fa-solid fa-up-right-and-down-left-from-center"></i>
                    </div>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Table 2</li>
                        <i class="text-info text-base lg:text-xl fa-solid fa-up-right-and-down-left-from-center"></i>
                    </div>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Table 3</li>
                        <i class="text-info text-base lg:text-xl fa-solid fa-up-right-and-down-left-from-center"></i>
                    </div>
                </ul>
            </div>
        </div>
        <div class="bg-base-200 lg:grow-0 lg:basis-5/12">
            <div class="collapse-title text-xl font-medium flex flex-row gap-3 w-full">
                <i class="inline-block text-accent text-3xl fa-solid fa-gears"></i>
                <h3 class="text-xl lg:text-3xl">Order System</h3>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>