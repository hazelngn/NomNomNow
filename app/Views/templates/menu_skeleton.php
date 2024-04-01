<section class="flex flex-row mt-3">
    <ul class="steps steps-vertical pl-5 overflow-hidden w-1/5">
        <li class="step text-transparent <?= $step >= 1 ? 'step-secondary text-secondary' : '' ?> ">User Information</li>
        <li class="step text-transparent <?= $step >= 2  ? 'step-secondary text-secondary' : '' ?>">Credentials</li>
        <li class="step text-transparent <?= $step >= 3 ? 'step-secondary text-secondary' : '' ?>">Business Information</li>
    </ul>
    <section class="w-4/5">
        <section class="flex flex-col justify-between mb-3 <?= $step == 1 ? '' : 'hidden' ?>">
            <?php include "menu_creation/step1.php" ?>
        </section>
        <section class="flex flex-col justify-between mb-3 <?= $step == 2 ? '' : 'hidden' ?>">
            <?php include "menu_creation/step2.php" ?>
        </section>
    </section>
</section>
