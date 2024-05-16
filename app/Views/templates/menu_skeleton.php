<section id="main_content" class="flex flex-row mt-3 md:flex-col md:w-4/6 lg:flex-col lg:w-4/6 m-auto" aria-label="Menu Creation">
    <ul class="steps steps-vertical pl-5 overflow-hidden w-1/5 h-96 md:h-fit md:w-full md:mb-11 lg:w-full lg:mb-11" role="navigation" aria-label="Steps Navigation">
        <li class="step <?= esc($step) >= 1 ? 'step-secondary' : '' ?>"><span class="hidden">Menu Overview</span></li>
        <li class="step <?= esc($step) >= 2 ? 'step-secondary' : '' ?>"><span class="hidden">Adding Items</span></li>
        <li class="step <?= esc($step) >= 3 ? 'step-secondary' : '' ?>"><span class="hidden">Review</span></li>
    </ul>
    <section id="menu_creation" class="w-4/5 m-auto lg:w-10/12" aria-labelledby="menuCreationTitle">
        <section class="flex flex-col justify-between mb-3">
        </section>

        <div class="flex flex-row justify-evenly mt-5" role="navigation" aria-label="Navigation Buttons">
            <i id="prevBtn" class="text-accent text-3xl fa-solid fa-circle-arrow-left cursor-pointer <?= esc($step) - 1 <= 0 ? 'text-neutral pointer-events-none' : '' ?>" aria-label="Previous Step" ></i>
            <i id="nextBtn" class="text-accent text-3xl fa-solid fa-circle-arrow-right cursor-pointer" aria-label="Next Step"></i>
        </div>   
    </section>
    <?php 
        if (esc($step) == 1) {
            include "menu_creation/step1.php";
        } elseif (esc($step) == 2) {
            include "menu_creation/step2.php";
        } elseif (esc($step) == 3) {
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
    let step = <?= esc($step) ?>;
    let stepTemplate, itemDetailsTemplate;

    // Waiting for all PHP files are loaded before calling the functions
    window.onload = (event) => {
        // Deciding which PHP template of the menu creation process to include
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
    

    // Handles the next navigation on each step
    nextBtn.addEventListener("click", async (e) => {
        if (step == 1) {
            const form = document.getElementById("step-1");
            let result = undefined;
            if (form.reportValidity()) {
                // Creating or Updating a menu
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                if (!menuId) {
                    result = await add("menus", data)
                } else {
                    result = await update("menus", data)
                }
                // Navigate to the next step
                window.location.replace(`<?= base_url("menu/addedit") ?>/${result ? result.id : menuId}/${step + 1}`);
                return;
            } else {
                // Do nothing when form is invalid
                return;
            }
        }
        step += 1;
        // Navigate to the next step
        window.location.replace(`<?= base_url("menu/addedit") ?>/${menuId}/${step}`);
    })


    // Handles the previous navigation on each step
    prevBtn.addEventListener("click", () => {
        step -= 1;
        window.location.replace(`<?= base_url("menu/addedit") ?>/${menuId}/${step}`);
    })

    /**
     * Asynchronously fetches menu items and displays them based on the current step.
     * If the step is 2, displays all items in a container.
     * If the step is not 2, organizes items by categories and displays them in tabs.
     */
    async function displayItems() {
        
        const menuItems = await fetchItems();

        if (step == 2) {
            const itemsContainer = document.querySelector("#items");
            // CLEAR OR OR ADD NEW BUT JUST CLEAR ALL
            itemsContainer.innerHTML = "";

            if (menuItems.length == 0) {
                // Display a message indicating no items are available
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
                    const imageSrc = item.item_img ? `data:image/jpeg;base64,${item.item_img}` : '';
                    itemCard.id = item.id;
                    itemCard.querySelector("#item-img").src = imageSrc;
                    itemCard.querySelector("#item-img").alt = `Image of the dish ${item.name}`;
                    itemCard.querySelector("#item-name").innerText = item.name;
                    itemCard.querySelector("#item-price").innerText = `$${item.price}`;
                    itemCard.querySelector("#editBtn").addEventListener("click", () => showItemDetails(item.id));
                    itemCard.querySelector("#deleteBtn").addEventListener("click", async () => {
                        if (window.confirm(`Delete ${item.name}?`)) {
                            await deleteItem("menu_items", item.id)
                            .then(data => displayItems())
                            .catch(err => console.log(err))
                        }

                    });
                    itemsContainer.append(itemCard);
                })
            }
        } else {
            // If step is not 2, organize items by categories and display them in tabs
            let menuCategories = menuItems.map(item => item.category_id);

            // Get the unique categories from the current menu
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
                    itemCard.querySelector("#editBtn").remove();
                    itemCard.querySelector("#deleteBtn").remove();
                    tabPanel.append(itemCard);
                })
                tablist.append(input);
                tablist.append(tabPanel);

            })
        }
    }

    /**
     * Asynchronously fetches menu items from the server.
     * Filters the fetched items based on the specified menu ID.
     * 
     * @returns {Promise<Array>} A promise that resolves to an array of menu items.
     */
    async function fetchItems() {
        let menuItems = await get("menu_items");

        menuItems = menuItems.filter(item => item.menu_id == menuId);

        return menuItems;
    }

    /**
     * Displays item details in a modal dialog.
     * 
     * If no item ID is provided, clears the modal for adding a new item.
     * If an item ID is provided, retrieves the item details and populates the modal for editing.
     * 
     * @param {number} id - The ID of the item to display/edit.
     */
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
        
        item_form_detail.showModal();
    }

    /**
     * Handles the submission of the item form for adding or editing an item.
     * 
     * @param {Event} e - The event object generated by the form submission.
     * @param {number} [id - The ID of the item to be edited (optional).
     */
    async function addEditItem(e,id) {
        e.preventDefault();
        const itemDetail = document.querySelector("#item_form_detail");
        const detailForm = document.querySelector("#detail_form");
        let result = undefined;

        if (detailForm.reportValidity()) {
            const formData = new FormData(detailForm);
            const data = Object.fromEntries(formData.entries());
            data['menu_id'] = menuId;

            // upload image
            const file = detailForm.querySelector("#item_img").files[0];

            // When file is invalid or the user didn't upload any image, delete 'item_img' field
            if (file) {
                const uploadFile = new FormData();
                uploadFile.append('file', file)

                if (file.size < 1000000) {
                    await fetch("<?= base_url('upload/') ?>", {
                    method: "POST",
                    body: uploadFile
                    })
                    .then(res => res.json())
                    .then(json => data['item_img'] = json['data'])
                } else {
                    alert('File is too big, make sure file size is less than 1MB. Thank you :)')
                    delete data['item_img']
                }
                
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

</script>