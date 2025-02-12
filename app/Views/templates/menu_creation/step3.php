<template id="step3Template">
    <section>
        <h3 class="text-xl text-center font-bold mb-5 lg:text-2xl">
            Review menu <?= esc($menu['name']) ?>
        </h3>
        <section id="items">
            <div role="tablist" class="tabs tabs-lifted mr-3"></div>
        </section>
    </section>
    
</template>

<template id="tabTemplate">
    <input type="radio" name="category" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="" checked/>
    <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 rounded-box p-6 z-10">
        <section></section>
    </div>
</template>