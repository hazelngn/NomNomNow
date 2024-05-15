<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
<section role="tablist" class="tabs tabs-lifted mt-5 w-full md:w-4/6 m-auto overflow-x-hidden">
    <!-- Not started tab -->
    <input type="radio" name="order_status" role="tab" id="not-started-tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-controls="not-started-panel" aria-label="Not started" checked/>
    <section id="not-started-panel" role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10 md:p-10" aria-labelledby="not-started-tab">
        <section id="not-started" class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <!-- Content for not started tab -->
        </section>
    </section>
    
    <!-- In progress tab -->
    <input type="radio" name="order_status" role="tab" id="in-progress-tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-controls="in-progress-panel" aria-label="In progress"/>
    <section id="in-progress-panel" role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10 md:p-10" aria-labelledby="in-progress-tab">
        <section id="in-progress" class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <!-- Content for in progress tab -->
        </section>
    </section>
    
    <!-- Complete tab -->
    <input type="radio" name="order_status" role="tab" id="complete-tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-controls="complete-panel" aria-label="Complete"/>
    <section id="complete-panel" role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10 md:p-10" aria-labelledby="complete-tab">
        <section id="ready" class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <!-- Content for complete tab -->
        </section>
    </section>
</section>

<dialog id="status_md" class="modal" aria-label="Update status modal">
    <section class="modal-box p-5">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close modal">x</button>
        </form>
        <h3 class="font-bold mb-5 text-accent text-xl">Update item status</h3>
        <p class="mb-5 text-secondary">Note: Some notes</p>
        <p class="mb-5 text-content">Click on the below button to update item status</p>
        <section id="updateStatus" class="flex flex-row gap-2 justify-center" role="group" aria-label="Update status">
            <button class="btn btn-sm btn-neutral">Not started</button>
            <button class="btn btn-sm btn-accent">In progress</button>
            <button class="btn btn-sm btn-success">Ready</button>
        </section>
    </section>
</dialog>


<?php include 'templates/components/order_item_card.php' ?>

<script>
    let orderItemTemplate;

    // let todayDate = new Date();
    // todayDate.setHours(00,00);
    
    // Waiting for all PHP files are loaded before calling the functions
    window.onload = () => {
        orderItemTemplate = document.querySelector("#order-item");
        // Render items and re-render every 2 seconds 
        // This is to ensure live updates of order status
        renderItems()
        setInterval(() => {
            renderItems()
        }, 2000);
    }

    /**
     * Render items based on their status.
     * 
     * Fetches necessary data for the current user, menus, menu items, orders, and order items.
     * Filters and displays order items in appropriate sections based on their status.
     */
    async function renderItems() {
        // Get the staff's details
        const staff = await get('users', <?= session()->get('userId') ?>).catch(err => console.log("An error occurred when fetching staff details"));

        // Fetch only the menus associated with the business this staff is in
        let menus = await get("menus").catch(err => console.log("An error occurred when fetching menus"));
        menus = menus.filter(menu => menu.business_id == staff.business_id);
        menuIds = menus.map(menu => menu.id)

        // Fetch all menu items' IDs that belongs to the associated menus
        let menuItems = await get('menu_items').catch(err => console.log("An error occurred when fetching menu items"));
        menuItemIds = menuItems.filter(item => menuIds.includes(item.menu_id)).map(item => item.id)

        // Fetch all orders placed today from 00:00
        let orders = await get('orders').catch(err => console.log("An error occurred when fetching orders"));
        // orders = orders.filter(order => {
        //     let orderDate = new Date(order.order_at);
        //     return todayDate < orderDate;
        // })

        let orderItems = await get('order_items').catch(err => console.log("An error occurred when fetching order items"));
        // Fetch all the order items that it the items in the current menus
        orderItems = orderItems.filter(item => menuItemIds.includes(item.menu_item_id))
                                .map(item => {
                                    // Adding menu item's details in with the order items for ease of use 
                                    // on the later step
                                    return {
                                        ...menuItems.find(menuItem => menuItem.id == item.menu_item_id),
                                        ...item
                                    }
                                })

        const notStartedSection = document.querySelector("#not-started")
        const inProgressSection = document.querySelector("#in-progress")
        const readySection = document.querySelector("#ready")

        notStartedSection.innerHTML = ""
        inProgressSection.innerHTML = ""
        readySection.innerHTML = ""

        const notStartedOrders = orders.filter(order => order.status == "not started");
        const inProgressOrders = orders.filter(order => order.status == "in progress");
        const readyOrders = orders.filter(order => order.status == "ready");

        // interval for real-time updates
        renderItemOnStatus(notStartedSection, notStartedOrders, orderItems)
        renderItemOnStatus(inProgressSection, inProgressOrders, orderItems)
        renderItemOnStatus(readySection, readyOrders, orderItems)
    }

    /**
     * Render items based on their status.
     * 
     * @param {HTMLElement} section - The section element to append items to.
     * @param {Array} orders - The list of orders filtered by status.
     * @param {Array} orderItems - The list of order items associated with the orders.
     */
    async function renderItemOnStatus(section, orders, orderItems) {
        // Get the order items with required status
        let orderIds = orders.map(order => order.id);
        let orderItemsOnStatus = orderItems.filter(item => orderIds.includes(item.order_id));

        orderItemsOnStatus.forEach(item => {
            const orderItemClone = orderItemTemplate.content.cloneNode(true).children[0];
            const order = orders.find(order => order.id == item.order_id)

            // Populate the order item details
            orderItemClone.querySelector("h2").innerText = `${item.name} (${item.quantity})`;
            orderItemClone.querySelector("section>p").innerText = `Table ${order.table_num}`;
            orderItemClone.querySelector("span").innerText = `ID ${item.id}`;
            orderItemClone.querySelector("#details").onclick = () => {
                status_md.showModal();
                const updateStatusBtns = status_md.querySelectorAll("#updateStatus>button")
                const [notStartedBtn, inProgressBtn, completeBtn] = updateStatusBtns

                // Update status depending on the button clicked
                notStartedBtn.onclick = async () => {
                    data = {
                        ...order,
                        status: 'not started',
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    }
                    await update("orders", data)
                    .then(data => console.log(data))
                    .catch(err => console.log("Error occurred when updating order status. Error: ", err))
                    status_md.close();
                    renderItems();
                }

                inProgressBtn.onclick = async () => {
                    data = {
                        ...order,
                        status: 'in progress',
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    }
                    await update("orders", data)
                    .then(data => console.log(data))
                    .catch(err => console.log("Error occurred when updating order status. Error: ", err))
                    status_md.close();
                    renderItems();
                }

                completeBtn.onclick = async () => {
                    data = {
                        ...order,
                        status: 'ready',
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    }
                    await update("orders", data)
                    .then(data => console.log(data))
                    .catch(err => console.log("Error occurred when updating order status. Error: ", err))
                    status_md.close();
                    renderItems();
                }
            }

            section.appendChild(orderItemClone);
        })
    }


</script>
<?= $this->endSection(); ?>