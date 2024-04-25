<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <section class="flex gap-2 mt-5 p-2 items-baseline md:w-4/6 md:m-auto md:mt-11">
        <a href="<?= base_url("") ?>"><i class="text-neutral-content text-lg md:text-2xl fa-solid fa-chevron-left"></i></a>
        <h3 class="text-lg md:text-2xl">
            View menu <?= $menu['name'] ?>
        </h3>
        <a href="<?= base_url("menu/addedit/1") ?>"><i class="text-accent text-lg md:text-2xl fa-solid fa-pen-to-square"></i></a>
    </section>

    <?php include 'templates/menu_temp.php' ?>
    <?php include 'helpers/api_calls.php' ?>
    
    <script>
        let categoryTemplate, categoriesContainer, itemContainerTemplate, itemDetailModalTemplate, menuCategories;

        window.onload = async (event) => {
            categoryTemplate = document.querySelector("#categoryTemplate");
            categoriesContainer = document.querySelector("#categories");
            itemContainerTemplate = document.querySelector("#itemContainerTemplate");
            itemDetailModalTemplate = document.querySelector("#itemDetailModalTemplate");
            await displayCategories();
            await renderItems();
            styleCategories();

        };


        async function displayCategories() {
            const categories = await get("categories");
            const items = await get("menu_items");

            const menuItems = items.filter(item => item.menu_id == <?= $menu['id'] ?>);
            menuCategories = menuItems.map(item => item.category_id);
            menuCategories = categories.filter(cat => menuCategories.includes(cat.id));

            menuCategories.forEach(cat => {
                let categoryClone = categoryTemplate.content.cloneNode(true).children[0];
                let input = categoryClone.querySelector("input");
                let label = categoryClone.querySelector("label");
                let img = categoryClone.querySelector("label>img");
                let categoryName = categoryClone.querySelector("h5");

                input.id = cat.id;
                input.value = cat.id;
                label.setAttribute('for', cat.id);
                img.src = `<?= base_url() ?>/${cat.iconUrl}`;
                img.alt = `${cat.name}`;
                categoryName.innerText = `${cat.name}`;

                categoriesContainer.appendChild(categoryClone)
            })

        }

        async function renderItems() {
            const items = await get("menu_items");
            const menuItems = items.filter(item => item.menu_id == <?= $menu['id'] ?>);
            const itemsContainer = document.querySelector("#items");
            const placeholderImg = "https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg";

            menuCategories.forEach(cat => {
                const itemContainer = itemContainerTemplate.content.cloneNode(true).children[0];
                itemContainer.id = `content-${cat.id}`;
                itemsContainer.appendChild(itemContainer)
            })

            menuItems.forEach(item => {
                const itemContainer = itemsContainer.querySelector(`#content-${item.category_id}`);

                // duplication menu_skeleton
                const itemCard = itemContainer.querySelector("#item-card").content.cloneNode(true).children[0];
                const imageSrc = item.item_img ? `data:image/jpeg;base64,${item.item_img}` : placeholderImg;
                itemCard.id = item.id;
                itemCard.querySelector("#item-img").src = imageSrc;
                itemCard.querySelector("#item-name").innerText = item.name;
                itemCard.querySelector("#item-price").innerText = `$${item.price}`;
                // itemCard.querySelector("#item-name").nextElementSibling.addEventListener("click", () => showItemDetails(item.id));

                itemCard.addEventListener("click", () => showItemDetails(item.id)) ;

                itemContainer.appendChild(itemCard);
            })

        }

        async function showItemDetails(id) {

            const itemDetails = itemDetailModalTemplate.content.cloneNode(true).children[0];
            document.querySelector("body").appendChild(itemDetails);
            const closeModalBtn = itemDetails.querySelector("#closeModal");
            const placeholderImg = "https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg";
            const mainContent = itemDetails.querySelector("#mainContent");
            
            const item = await get("menu_items", id);

            const itemImg = itemDetails.querySelector("img");
            const imageSrc = item.item_img ? `data:image/jpeg;base64,${item.item_img}` : placeholderImg;
            itemImg.src = imageSrc;
            itemImg.alt = `The image of dish called ${item.name}`;

            const itemName = itemDetails.querySelector("h3");
            itemName.innerText = item.name;

            const itemPrice = itemName.nextElementSibling;
            itemPrice.innerText = `$${item.price}`;

            const prefsContainer = itemDetails.querySelector("#prefs");

            const itemPrefs = await get("diet_pref_items", id);
            if (itemPrefs) {
                itemPrefs.forEach(async pref => {
                    const prefElem = document.createElement("div");
                    prefElem.className = "badge badge-accent badge-outline shrink-0 md:text-md md:p-3";
                    const prefDetail = await get("diet_pref", pref.diet_pr_id);
                    prefElem.innerText = prefDetail.name;

                    prefsContainer.appendChild(prefElem);
                })
            }

            const desc = itemDetails.querySelector("#desc");
            const itemDescription = document.createElement("p");
            
            itemDescription.innerText = item.description;
            desc.after(itemDescription);

            const ingre = itemDetails.querySelector("#ingre");
            const itemIngredients = document.createElement("p");
            itemIngredients.innerText = item.ingredients;
            ingre.after(itemIngredients);

            closeModalBtn.onclick = () => item_detail.remove();
            item_detail.showModal();

        }


        function styleCategories() {
            let categoryInputs = categoriesContainer.querySelectorAll('.categories');

            categoryInputs[0].checked = true;
            categoryInputs[0].nextSibling.nextElementSibling.style.opacity = 1;
            categoryInputs[0].nextElementSibling.nextElementSibling.classList.add("text-accent");
            document.getElementById(`content-${categoryInputs[0].id}`).style.display = 'flex';

            for (let i = 0; i < categoryInputs.length; i++) {
                categoryInputs[i].addEventListener('change', function() {
                    if (categoryInputs[i].checked) {
                        categoryInputs[i].nextSibling.nextElementSibling.style.opacity = 1;
                        document.getElementById(`content-${categoryInputs[i].id}`).style.display = 'flex';
                        categoryInputs[i].nextElementSibling.nextElementSibling.classList.add("text-accent");
                    }
                    for (let j = 0; j < categoryInputs.length; j++) {
                        if (i != j) {
                            categoryInputs[j].nextSibling.nextElementSibling.style.opacity = 0.5;
                            document.getElementById(`content-${categoryInputs[j].id}`).style.display = 'none';
                            categoryInputs[j].nextElementSibling.nextElementSibling.classList.remove("text-accent");
                        }
                    }
                })
            }
        }

    </script>
<?= $this->endSection(); ?>

