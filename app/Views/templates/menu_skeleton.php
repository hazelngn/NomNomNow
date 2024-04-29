<section id="main_content" class="flex flex-row mt-3 md:flex-col md:w-4/6 lg:flex-col lg:w-4/6 m-auto">
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
        } elseif ($step == 3) {
            include "menu_creation/step3.php";
            include "components/item_card.php";
        }
        include "components/item_card.php";
        include "components/item_form_details.php";
    ?>
    
</section>

<script>
    const mainContent = document.querySelector('#main_content');
    const prevBtn = document.querySelector("#prevBtn");
    const nextBtn = document.querySelector("#nextBtn");
    const menuId = "<?= isset($menu['id']) ? esc($menu['id']) : "" ?>";
    const menu = document.getElementById('menu_creation').children[0];
    let step = <?= $step ?>;
    let stepTemplate, itemDetailsTemplate;


    window.onload = (event) => {
        itemDetailsTemplate = document.querySelector('#itemFormTemplate');
        if (step == 1) {
            stepTemplate = document.querySelector('#step1Template').content.cloneNode(true);
            menu.appendChild(stepTemplate)
        } else if (step == 2) {
            stepTemplate = document.querySelector('#step2Template').content.cloneNode(true);
            menu.appendChild(stepTemplate);
            displayItems();
        } else if (step == 3) {
            stepTemplate = document.querySelector('#step3Template').content.cloneNode(true);
            const items = stepTemplate.children[0]
            menu.append(items);
            displayItems();
        }
    };
    

    nextBtn.addEventListener("click", async (e) => {
        if (step == 1) {
            const form = document.getElementById("step-1");
            let result = undefined;
            if (form.reportValidity()) {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                if (!menuId) {
                    result = await add("menus", data)
                } else {
                    result = await update("menus", data)
                }
                window.location.replace(`<?= base_url("menu/addedit") ?>/${result ? result.id : menuId}/${step + 1}`);
                return;
            } else {
                return;
            }
        }
        step += 1;
       window.location.replace(`<?= base_url("menu/addedit") ?>/${menuId}/${step}`);
    })

    prevBtn.addEventListener("click", () => {
        step -= 1;
        window.location.replace(`<?= base_url("menu/addedit") ?>/${menuId}/${step}`);
    })

    async function displayItems() {
        
        const menuItems = await fetchItems();
        const placeholderImg = "https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg";

        if (step == 2) {
            const itemsContainer = document.querySelector("#items");
            // CLEAR OR OR ADD NEW BUT JUST CLEAR ALL
            itemsContainer.innerHTML = "";

            if (menuItems.length == 0) {
                console.log("empty")
                const emptyText = document.createElement("p");
                emptyText.id = "empty_text";
                emptyText.innerText = "No items created yet."
                emptyText.classList.add("text-center");
                itemsContainer.append(emptyText);
            } else {
                const emptyText = document.querySelector("#empty_text");
                if (emptyText) emptyText.remove();
                menuItems.forEach(item => {
                    // duplication menu_view
                    const itemCard = document.querySelector("#item-card").content.cloneNode(true).children[0];
                    const imageSrc = item.item_img ? `data:image/jpeg;base64,${item.item_img}` : placeholderImg;
                    itemCard.id = item.id;
                    itemCard.querySelector("#item-img").src = imageSrc;
                    itemCard.querySelector("#item-name").innerText = item.name;
                    itemCard.querySelector("#item-price").innerText = `$${item.price}`;
                    itemCard.querySelector("#item-name").nextElementSibling.addEventListener("click", () => showItemDetails(item.id));
                    itemsContainer.append(itemCard);
                })
            }
        } else {
            let menuCategories = menuItems.map(item => item.category_id);
            menuCategories = new Set(menuCategories);
            let categories = await get("categories");
            const tablist = document.querySelector("#items>div");
            menuCategories.forEach(async cat_id => {
                const category = categories.filter(cat => cat.id == cat_id)[0]
                const items = menuItems.filter(item => item.category_id == cat_id);
                const tabTemplate = document.querySelector("#tabTemplate").content.cloneNode(true);
                const input = tabTemplate.querySelector("input");
                const tabPanel = tabTemplate.querySelector("div");
                input.setAttribute("aria-label", category.name);
                
                items.forEach(item => {
                    const itemCard = document.querySelector("#item-card").content.cloneNode(true).children[0];
                    const imageSrc = item.item_img ? `data:image/jpeg;base64,${item.item_img}` : placeholderImg;
                    // add margin at the bottom of the card
                    itemCard.classList.add("mb-3")
                    itemCard.id = item.id;
                    itemCard.querySelector("#item-img").src = imageSrc;
                    itemCard.querySelector("#item-name").innerText = item.name;
                    itemCard.querySelector("#item-price").innerText = `$${item.price}`;
                    itemCard.querySelector("#item-name").nextElementSibling.remove();
                    tabPanel.append(itemCard);
                })
                tablist.append(input);
                tablist.append(tabPanel);

            })
        }
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

    async function showItemDetails(id) {
        // modals
        const itemDetail = itemDetailsTemplate.content.cloneNode(true).children[0];
        mainContent.append(itemDetail);
        const detailForm = itemDetail.querySelector("#detail_form");
        const modalHeading = detailForm.querySelector("h3>span");
        const name = detailForm.querySelector("#name");
        const category = detailForm.querySelector("#category_id");
        const description = detailForm.querySelector("#description");
        const ingredients = detailForm.querySelector("#ingredients");
        const notes = detailForm.querySelector("#notes");
        const price = detailForm.querySelector("#price");
        const item_img = detailForm.querySelector("#item_img");
        const item_id = detailForm.querySelector("#id");
        if (!id) {
            // Add
            modalHeading.innerText = "Add";
            document.getElementById("detail_form").reset();
            detailForm.querySelector("#submitBtn").addEventListener("click", (e) => addEditItem(e));
        } else {
            // Edit
            const menuItems = await fetchItems();
            modalHeading.innerText = "Edit";

            const item = menuItems.filter(item => item.id == id)[0];

            // Updating the modal
            name.value = item.name;
            category.value = item.category_id;
            description.value = item.description;
            ingredients.value = item.ingredients;
            notes.value = item.notes ? item.notes : "No notes provided"; 
            price.value = item.price;
            item_id.value = item.id
            detailForm.querySelector("#submitBtn").addEventListener("click", (e) => addEditItem(e, item.id));

            
            // Show that a file has been uploaded
            if (item.item_img) {
                const successUpload = document.createElement("p");
                const replaceImage = document.createElement("p");
                const parent = item_img.parentElement;
                successUpload.innerText = "An image has been uploaded.";
                successUpload.classList.add("text-success", "md:text-sm", "italic", "text-xs");
                replaceImage.innerText = "Change image";
                parent.insertBefore(successUpload, item_img);
                parent.insertBefore(replaceImage, item_img);
            }
            
        }

        itemDetail.querySelector("#close_modal").addEventListener("click", () => itemDetail.remove())
        
        item_detail.showModal();
    }

    async function addEditItem(e,id) {
        e.preventDefault();
        const itemDetail = document.querySelector("#item_detail");
        const detailForm = document.querySelector("#detail_form");
        let result = undefined;

        if (detailForm.reportValidity()) {
            const formData = new FormData(detailForm);
            const data = Object.fromEntries(formData.entries());
            data['menu_id'] = menuId;

            // upload image
            const file = detailForm.querySelector("#item_img").files[0];

            if (file) {
                const uploadFile = new FormData();
                uploadFile.append('file', file)

                await fetch("<?= base_url('upload/') ?>", {
                    method: "POST",
                    body: uploadFile
                })
                .then(res => res.json())
                .then(json => data['item_img'] = json['data'])
            } else {
                delete data['item_img']
            }


            if (!id) {
                // add
                result = await add("menu_items", data)
            } else {
                // edit
                result = await update("menu_items", data)
            }

            itemDetail.close();
            itemDetail.remove();
            displayItems();
        };

    }

    // let test = {
    //     id: 7,
    //     diet_pr_id: 3
    // }
    // update("diet_pref_items", test)
    // .then(data => console.log(data))    

</script>