 <!-- A template to view items in a menu (for business owner) and to order items (for customer) -->
<section  id="loading" class="fixed left-0 w-full h-full flex justify-center bg-base-100 z-10"><span class="loading loading-spinner text-accent loading-lg"></span></section>
<section>
    <!-- Display all categories in a menu -->
    <div id="categories" class="flex flex-row flex-nowrap gap-1 pb-3 text-center justify-evenly overflow-scroll md:overflow-hidden">
        <template id="categoryTemplate">
            <div class="basis-1/5 md:basis-28 shrink-0 grow-0">
                <input type="radio" name="categories" id="" value="" class="categories opacity-0 w-0 h-0"/>
                <!-- opacity not working with peer-checked -->
                <label class="cursor-pointer opacity-50 " for="" aria-label="Category">
                    <img class="w-4/6 m-auto mb-1" src=""  alt="">
                </label>
                <h5></h5>
            </div>
        </template>
    </div>
    <!-- Display the corresponding items based on category -->
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
    
    // An array containing all menu_item objects that the customer has ordered
    let orderItems = [];

    window.onload = async (event) => {
        categoryTemplate = document.querySelector("#categoryTemplate");
        categoriesContainer = document.querySelector("#categories");
        itemContainerTemplate = document.querySelector("#itemContainerTemplate");
        itemDetailModalTemplate = document.querySelector("#itemDetailModalTemplate");
        await displayCategories();
        await renderItems();
        styleCategories();
        // Remove the loading thing when everything is fully renderred
        document.querySelector("#loading").classList.add('hidden')

    };


    /**
     * Fetches categories and menu items, then displays categories.
     */
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

            // console.log(categoryClone)
            categoriesContainer.appendChild(categoryClone)
        })

    }

    /**
     * Fetches menu items and renders them based on categories.
     */
    async function renderItems() {
        const items = await get("menu_items");
        const menuItems = items.filter(item => item.menu_id == <?= $menu['id'] ?>);
        const itemsContainer = document.querySelector("#items");

        menuCategories.forEach(cat => {
            // Create a containing containing all associated items for each category
            const itemContainer = itemContainerTemplate.content.cloneNode(true).children[0];

            // This id allows us to know which container to show when a category is clicked
            itemContainer.id = `content-${cat.id}`;
            itemsContainer.appendChild(itemContainer)
        })

        menuItems.forEach(item => {
            const itemContainer = itemsContainer.querySelector(`#content-${item.category_id}`);

            // duplication menu_skeleton
            const itemCard = itemContainer.querySelector("#item-card").content.cloneNode(true).children[0];
            const imageSrc = item.item_img ? `data:image/jpeg;base64,${item.item_img}` : "";
            itemCard.id = item.id;
            itemCard.querySelector("#item-img").src = imageSrc;
            itemCard.querySelector("#item-img").alt = `An image of the dish ${item.name}`;
            itemCard.querySelector("#item-name").innerText = item.name;
            itemCard.querySelector("#item-price").innerText = `$${item.price}`;

            // When an item is clicked, open a modal containing the item details
            itemCard.addEventListener("click", () => showItemDetails(item.id));

            itemContainer.appendChild(itemCard);
        })

    }

    /**
     * Displays details of a menu item in a modal.
     * @param {number} id - The ID of the menu item.
     */
    async function showItemDetails(id) {
        // Populate the menu item data to the modal
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

        const desc = itemDetails.querySelector("#desc");
        const itemDescription = document.createElement("p");
        
        itemDescription.innerText = item.description;
        desc.after(itemDescription);

        const ingre = itemDetails.querySelector("#ingre");
        const itemIngredients = document.createElement("p");
        itemIngredients.innerText = item.ingredients;
        ingre.after(itemIngredients);

        <?php if (isset($customer_view)):  ?>
            // Handle the logic when adding an item to cart
            let quantity = 0;
            const quantityElem = itemDetails.querySelector("#quantity");
            const lessBtn = itemDetails.querySelector("#lessBtn");
            const moreBtn = itemDetails.querySelector("#moreBtn");
            const addToCartBtn = itemDetails.querySelector("#addCartBtn");

            // Check if the item that is currently viewed has already existed in cart
            const itemOrdered = orderItems.find(i => i.menu_item_id == item.id);

            // If it does, updates the quantity of the modal respectively
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

            addToCartBtn.onclick = () => {
                addToCart(item.id, quantity)
            };

        <?php endif;  ?>

        closeModalBtn.onclick = () => item_detail.remove();
        console.log(itemDetails)
        item_detail.showModal();

    }

    /**
     * Adds or updates an item in the cart based on the given ID and quantity.
     * @param {number} id - The ID of the menu item.
     * @param {number} quantity - The quantity of the menu item to add or update.
     */
    function addToCart(id, quantity) {
        // The number above the cart for cart status
        const totalQuantity = document.querySelector("#totalQuantity");

        // Create an order item object
        const orderItem = {
            menu_item_id: id,
            quantity: quantity,
        }

        if (quantity > 0) {
            // This item has been added to cart
            const unchangedItems = orderItems.filter(item => item.menu_item_id != id );

            orderItems = [...unchangedItems, orderItem];
        } else {
            // Removed from cart
            orderItems = orderItems.filter(item => item.menu_item_id != id);
        }

        const sumQuantity = orderItems.map(item => item.quantity).reduce((accumulator, currentValue) => {
                                return accumulator + currentValue
                            },0);
        
        totalQuantity.innerText = sumQuantity;
        item_detail.close();
        item_detail.remove();

    }

    /**
     * Displays the cart with the list of items and their details.
     * Calculates the total price of all items in the cart and displays it.
     */
    function showCart() {
        const cart = document.querySelector("#cart");
        const cartItems = document.querySelector("#cartItems");
        const total = document.querySelector("#total");
        let totalPrice = 0;
        cartItems.innerHTML = "";

        orderItems.forEach(async item => {
            // Populate the cart
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

            // console.log(totalPrice)
        })


        cart.showModal();
    }

    /**
     * Initiates the checkout process by sending the order items to the server.
     * If there are order items, sends a POST request to the checkout endpoint with the order data.
     * After successful submission, redirects the user to the checkout page.
     */
    async function checkout() {
        let data = [
            // Construct the needed IDs for the controller
            {
                menuId: <?= $menu['id'] ?>,
                businessId: <?= $business['id'] ?>,
                tableNum: "<?= isset($tableNum) ? $tableNum : null ?>"
            },
            ...orderItems,
        ]

        // Build the data object that contains csrf
        data = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
            content: data
        }


        if (orderItems.length > 0) {
            await fetch("<?= base_url("checkout") ?>", {
                method: "POST",
                body: JSON.stringify(data)
            })
            .then(data => location.replace("<?= base_url("checkout") ?>"));
        }

        
    }

    /**
     * Styles the categories and controls the display of corresponding items based on user selection.
     */
    function styleCategories() {
        let categoryInputs = categoriesContainer.querySelectorAll('.categories');

        // tyles the categories and controls the display of corresponding items based on user selection.
        categoryInputs[0].checked = true;
        categoryInputs[0].nextSibling.nextElementSibling.style.opacity = 1;
        categoryInputs[0].nextElementSibling.nextElementSibling.classList.add("text-accent");
        document.getElementById(`content-${categoryInputs[0].id}`).style.display = 'flex';

        for (let i = 0; i < categoryInputs.length; i++) {
            categoryInputs[i].addEventListener('change', function() {

                if (categoryInputs[i].checked) {
                    // Style the selected category and display its corresponding content
                    categoryInputs[i].nextSibling.nextElementSibling.style.opacity = 1;
                    document.getElementById(`content-${categoryInputs[i].id}`).style.display = 'flex';
                    categoryInputs[i].nextElementSibling.nextElementSibling.classList.add("text-accent");
                }
                for (let j = 0; j < categoryInputs.length; j++) {
                    // Iterate over all category inputs to update styles based on user selection
                    if (i != j) {
                        // Reset styles for unselected categories and hide their corresponding content
                        categoryInputs[j].nextSibling.nextElementSibling.style.opacity = 0.5;
                        document.getElementById(`content-${categoryInputs[j].id}`).style.display = 'none';
                        categoryInputs[j].nextElementSibling.nextElementSibling.classList.remove("text-accent");
                    }
                }
            })
        }
    }

</script>