<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
<div role="tablist" class="tabs tabs-lifted mt-5 w-full md:w-4/6 m-auto overflow-x-hidden">
    <!-- colors -->
    <input type="radio" name="order_status" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Not started" checked/>
    <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10">
        <section id="not-started" class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <?php for ($i = 0; $i < 5; $i++): ?>
                <?php include 'templates/components/order_item_card.php' ?>
            <?php endfor; ?>
        </section>
    </div>
    <input type="radio" name="order_status" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="In progress"/>
    <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10">
        <section id="in-progress"  class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <?php for ($i = 0; $i < 3; $i++): ?>
                <?php include 'templates/components/order_item_card.php' ?>
            <?php endfor; ?>
        </section>
    </div>
    <input type="radio" name="order_status" role="tab" class="tab checked:[--tab-border-color:text-purple-400] checked:text-purple-400" aria-label="Complete"/>
    <div role="tabpanel" class="tab-content bg-base-100 border-purple-400 !col-span-3 rounded-box p-7 z-10">
        <section id="ready" class="flex flex-col md:flex-row gap-1 flex-wrap justify-between">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <?php include 'templates/components/order_item_card.php' ?>
            <?php endfor; ?>
        </section>
    </div>
</div>

<dialog id="status_md" class="modal">
    <div class="modal-box p-5">
        <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold mb-5 text-accent text-xl">Update item status</h3>
        <p class="mb-5 text-secondary">Note: Some notes</p>
        <div id="updateStatus" class="flex flex-row gap-2">
            <button class="btn btn-sm btn-neutral">Not started</button>
            <button class="btn btn-sm btn-accent">In progress</button>
            <button class="btn btn-sm btn-success">Complete</button>
        </div>
    </div>
</dialog>

<script>
    let orderItemTemplate;
    
    window.onload = () => {
        orderItemTemplate = document.querySelector("#order-item");
        setInterval(() => {
            renderItems()
        }, 2000);
        
    }

    async function renderItems() {
        const staff = await get('users', <?= session()->get('userId') ?>).catch(err => console.log("An error occurred when fetching staff details"));


        let menus = await get("menus").catch(err => console.log("An error occurred when fetching menus"));
        menus = menus.filter(menu => menu.business_id == staff.business_id);
        menuIds = menus.map(menu => menu.id)

        let menuItems = await get('menu_items').catch(err => console.log("An error occurred when fetching menu items"));
        menuItemIds = menuItems.filter(item => menuIds.includes(item.menu_id)).map(item => item.id)

        // get all orders
        let orders = await get('orders').catch(err => console.log("An error occurred when fetching orders"));

        let orderItems = await get('order_items').catch(err => console.log("An error occurred when fetching order items"));
        orderItems = orderItems.filter(item => menuItemIds.includes(item.menu_item_id))
                                .map(item => {
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

    async function renderItemOnStatus(section, orders, orderItems) {
        let orderIds = orders.map(order => order.id);
        let orderItemsOnStatus = orderItems.filter(item => orderIds.includes(item.order_id));

        orderItemsOnStatus.forEach(item => {
            const orderItemClone = orderItemTemplate.content.cloneNode(true).children[0];
            const order = orders.find(order => order.id == item.order_id)

            orderItemClone.querySelector("h2").innerText = `${item.name} (${item.quantity})`;
            orderItemClone.querySelector("section>p").innerText = `Table ${order.table_num}`;
            orderItemClone.querySelector("span").innerText = `ID ${item.id}`;
            orderItemClone.querySelector("#details").onclick = () => {
                status_md.showModal();
                const updateStatusBtns = status_md.querySelectorAll("#updateStatus>button")
                const notStartedBtn = updateStatusBtns[0]
                const inProgressBtn = updateStatusBtns[1]
                const completeBtn = updateStatusBtns[2]

                notStartedBtn.onclick = async () => {
                    data = {
                        ...order,
                        status: 'not started'
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
                        status: 'in progress'
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
                        status: 'ready'
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