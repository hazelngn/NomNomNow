<section class="flex flex-row mt-3 md:flex-col md:w-4/6 lg:flex-col lg:w-4/6 m-auto">
    <ul class="steps steps-vertical pl-5 overflow-hidden w-1/5 md:w-full md:mb-11 lg:w-full lg:mb-11">
        <li class="step text-transparent md:text-current <?= $step >= 1 ? 'step-secondary' : '' ?> ">Menu Overview</li>
        <li class="step text-transparent md:text-current <?= $step >= 2  ? 'step-secondary' : '' ?>">Adding Items</li>
        <li class="step text-transparent md:text-current <?= $step >= 3 ? 'step-secondary' : '' ?>">Review</li>
    </ul>
    <section class="w-4/5 m-auto lg:w-10/12">
        <section class="flex flex-col justify-between mb-3 <?= $step == 1 ? '' : 'hidden' ?>">
            <?php include "menu_creation/step1.php" ?>
        </section>
        <section class="flex flex-col justify-between mb-3 <?= $step == 2 ? '' : 'hidden' ?>">
            <?php include "menu_creation/step2.php" ?>
        </section>
        <section class="flex flex-col justify-between mb-3 <?= $step == 3 ? '' : 'hidden' ?>">
            <?php include "menu_creation/step3.php" ?>
        </section>
    </section>
</section>
