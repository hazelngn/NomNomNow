 <!-- Categories -->
<section>
    <div id="categories" class="flex flex-row flex-nowrap gap-1 pb-3 text-center justify-evenly overflow-scroll md:overflow-hidden">
        <template id="categoryTemplate">
            <div class="basis-1/5 md:basis-28 shrink-0 grow-0">
                <input type="radio" name="categories" id="" value="" class="categories opacity-0 w-0 h-0"/>
                <!-- opacity not working with peer-checked -->
                <label class="cursor-pointer opacity-50 " for="">
                    <img class="w-4/6 m-auto mb-1" src=""  alt="">
                </label>
                <h5 class=""></h5>
            </div>
        </template>
    </div>
    <section id="items" class="p-3 flex flex-col md:flex-row gap-3 flex-wrap md:w-4/6 m-auto">
        <template id="itemContainerTemplate">
            <div class="flex-col gap-4 hidden justify-evenly md:flex-row mt-5 flex-grow flex-wrap">
                <?php include 'components/item_card.php' ?>
            </div>
        </template>
    </section>
</section>

<?php include 'components/item_details.php' ?>

<dialog id="cart" class="modal">
    <div class="modal-box p-10">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold mb-5 text-accent text-xl">Your cart</h3>
        <section class="flex flex-col gap-3 md:text-lg md:flex-wrap">
            <section class="flex flex-1 text-neutral-content">
                <section class="basis-1/2">
                    Product
                </section>
                <section class="basis-1/4 text-right">
                    Quantity
                </section>
                <section class="basis-1/4 text-right">
                    Price
                </section>
            </section>
            <section id="cartItems"></section>
        </section>
        <div class="flex flex-row items-center justify-between mt-5">
            <p class="text-lg text-accent">Total: $<span id="total">0</span></p>
            <button  onclick="checkout()" class="btn btn-accent">Check out</button>
        </div>
    </div>
</dialog>

<template id="cartItemTemplate">
    <section class="flex flex-1 text-neutral-content">
        <section id="product" class="basis-1/2">
            Product
        </section>
        <section id="quantity" class="basis-1/4 text-right">
            Quantity
        </section>
        <section id="price" class="basis-1/4 text-right">
            Price
        </section>
    </section>
</template>

<script>
    let categoryTemplate, categoriesContainer, itemContainerTemplate, itemDetailModalTemplate, menuCategories;
    let orderItems = [];

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

            console.log(categoryClone)
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

            itemCard.addEventListener("click", () => showItemDetails(item.id));

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

        <?php if (isset($customer_view)):  ?>
            let quantity = 0;
            const quantityElem = itemDetails.querySelector("#quantity");
            const lessBtn = itemDetails.querySelector("#lessBtn");
            const moreBtn = itemDetails.querySelector("#moreBtn");
            const addToCartBtn = itemDetails.querySelector("#addCartBtn");

            const itemOrdered = orderItems.find(i => i.menu_item_id == item.id);
            if (itemOrdered) {
                quantity = itemOrdered.quantity;
                quantityElem.innerText = quantity;
            }

            lessBtn.onclick = () => {
                if (quantity > 0) {
                    quantity -= 1;
                    quantityElem.innerText = quantity;
                }
            }

            moreBtn.onclick = () => {
                quantity += 1;
                quantityElem.innerText = quantity;
            }

            addToCartBtn.onclick = () => addToCart(item.id, quantity);

        <?php endif;  ?>

        closeModalBtn.onclick = () => item_detail.remove();
        item_detail.showModal();

    }

    function addToCart(id, quantity) {
        const totalQuantity = document.querySelector("#totalQuantity");

        const orderItem = {
            menu_item_id: id,
            quantity: quantity
        }

        if (quantity > 0) {
            const unchangedItems = orderItems.filter(item => item.menu_item_id != id);

            orderItems = [...unchangedItems, orderItem];
        } else {
            orderItems = orderItems.filter(item => item.menu_item_id != id);
        }

        const sumQuantity = orderItems.map(item => item.quantity).reduce((accumulator, currentValue) => {
                                return accumulator + currentValue
                            },0);
        
        totalQuantity.innerText = sumQuantity;
        item_detail.close();
        item_detail.remove();

    }

    function showCart() {
        const cart = document.querySelector("#cart");
        const cartItems = document.querySelector("#cartItems");
        const total = document.querySelector("#total");
        let totalPrice = 0;
        cartItems.innerHTML = "";

        orderItems.forEach(async item => {
            const itemContainer = cartItemTemplate.content.cloneNode(true).children[0];
            itemContainer.classList.remove('text-neutral-content')
            const product = itemContainer.querySelector("#product");
            const quantity = itemContainer.querySelector("#quantity");
            const price = itemContainer.querySelector("#price");

            const itemDetail = await get("menu_items", item.menu_item_id);

            product.innerText = itemDetail.name;
            quantity.innerText = item.quantity;
            price.innerText = `$${itemDetail.price}`;

            totalPrice += itemDetail.price * item.quantity;

            total.innerText = totalPrice;
            cartItems.appendChild(itemContainer);
        })

        cart.showModal();
    }

    async function checkout() {
        const data = [
            {
                menuId: <?= $menu['id'] ?>,
                businessId: <?= $business['id'] ?>,
                tableNum: "<?= isset($tableNum) ? $tableNum : null ?>"
            },
            ...orderItems,
        ]

        if (orderItems.length > 0) {

            await fetch("<?= base_url("checkout") ?>", {
                method: "POST",
                body: JSON.stringify(data)
            })
            .then(data => location.replace("<?= base_url("checkout") ?>"));
        }

        
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