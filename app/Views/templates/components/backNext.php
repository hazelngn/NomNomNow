<div class="flex flex-row justify-evenly">
    <a class="<?= $step - 1 <= 0 ? 'pointer-events-none' : '' ?>"   href="<?= $backStep = $step - 1; base_url('signup/' . $backStep);  ?>">
        <i class="text-accent text-3xl fa-solid fa-circle-arrow-left <?= $step - 1 <= 0 ? 'text-neutral' : '' ?>" ></i>
    </a>
    <a href="<?= $nextStep = $step + 1; base_url('signup/' . $nextStep)  ?>">
        <i class="text-accent text-3xl fa-solid fa-circle-arrow-right" ></i>
    </a>
</div>