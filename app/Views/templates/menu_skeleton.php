<section class="flex flex-row mt-3 md:flex-col md:w-4/6 lg:flex-col lg:w-4/6 m-auto">
    <ul class="steps steps-vertical pl-5 overflow-hidden w-1/5 h-96 md:h-fit md:w-full md:mb-11 lg:w-full lg:mb-11">
        <li class="step text-transparent md:text-current <?= $step >= 1 ? 'step-secondary' : '' ?> ">Menu Overview</li>
        <li class="step text-transparent md:text-current <?= $step >= 2  ? 'step-secondary' : '' ?>">Adding Items</li>
        <li class="step text-transparent md:text-current <?= $step >= 3 ? 'step-secondary' : '' ?>">Review</li>
    </ul>
    <section id="menu_creation" class="w-4/5 m-auto lg:w-10/12">
        <section class="flex flex-col justify-between mb-3">
        </section>

        <div class="flex flex-row justify-evenly mt-5">
            <i id="prevBtn" class="text-accent text-3xl fa-solid fa-circle-arrow-left <?= $step - 1 <= 0 ? 'text-neutral pointer-events-none' : '' ?>" ></i>
            <i id="nextBtn" class="text-accent text-3xl fa-solid fa-circle-arrow-right" ></i>
        </div>   
    </section>
    <?php 
        if ($step == 1) {
            include "menu_creation/step1.php";
        } elseif ($step == 2) {
            include "menu_creation/step2.php";
            include "components/item_card.php";
        } elseif ($step == 3) {
            include "menu_creation/step3.php";
        }
    ?>
    
</section>

<?php include __DIR__ . '/../helpers/api_calls.php' ?>
<script>
    let step = <?= $step ?>;
    let stepTemplate;
    const prevBtn = document.querySelector("#prevBtn");
    const nextBtn = document.querySelector("#nextBtn");
    const menuId = <?= esc($menu['id']) ? esc($menu['id']) : undefined ?>;

    const menu = document.getElementById('menu_creation').children[0];

    if (step == 1) {
        stepTemplate = document.querySelector('#step1Template').content.cloneNode(true);
    } else if (step == 2) {
        stepTemplate = document.querySelector('#step2Template').content.cloneNode(true);
        displayItems().then(data => console.log("result", data));
    } else if (step == 3) {
        stepTemplate = document.querySelector('#step3Template').content.cloneNode(true);
    }
    menu.append(stepTemplate);


    nextBtn.addEventListener("click", async () => {
        if (step == 1) {
            const form = document.getElementById("step-1");
            let result = undefined;
            if (form.reportValidity()) {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                if (!menu) {
                    await add("menus", data)
                    .then(data => result = data);
                }
                step += 1;
                console.log(menu);
                window.location.replace(`<?= base_url("menu/addedit") ?>/${result ? result.id : menuId}/${step}`);
            };
        } else if (step == 2) {
        }
    })

    async function displayItems() {
        const itemsContainer = stepTemplate.querySelector("#items");
        const menuItems = await fetchItems();

        menuItems.forEach(item => {
            const itemCard = document.querySelector("#item-card").content.cloneNode(true).children[0];
            console.log(itemCard)
            itemCard.id = item.id;
            // itemCard.querySelector("#item-img").innerText = item.name;
            itemCard.querySelector("#item-name").innerText = item.name;
            itemCard.querySelector("#item-price").innerText = item.price;
            itemsContainer.append(itemCard);
        })
        
    }

    async function fetchItems() {
        let menuItems = await get("menu_items");

        menuItems = menuItems.filter(item => item.menu_id == menuId);
        menuItems = Promise.all(menuItems.map(async item => {
            let dietIds = await get("diet_pref_items", item.id);
            let dietaries = [];
            const menuItem = {
                ...item
            }
            if (dietIds) {
                dietIds = dietIds.map(item => item.diet_pr_id);
                dietIds.forEach(async dietId => {
                    dietPref = await get("diet_pref", dietId);
                    dietaries.push(dietPref.name);
                });
                menuItem['dietaries'] = dietaries;
            }

            return menuItem;
        }))

        return menuItems;
    }


</script>