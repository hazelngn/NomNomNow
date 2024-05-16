<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section class="flex flex-col lg:flex-row flex-wrap justify-evenly mt-5 ">
        <section class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12" role="tabpanel" aria-labelledby="menu-heading">
            <input type="radio" name="my-accordion-2" id="menu-accordion" checked="checked" /> 
            <section class="collapse-title text-xl font-medium flex flex-row gap-3" id="menu-heading">
                <i class="inline-block text-accent text-3xl fa-solid fa-book-open"></i>
                <h3 class="text-xl lg:text-3xl">Menus</h3>
            </section>
            <section class="collapse-content bg-neutral"> 
                <ul id="menus_container">
                    <section></section>
                    <!-- lg:tooltip doesn't work -->
                    <section class="w-full flex justify-center pt-3 tooltip tooltip-accent" data-tip="Add new menu">
                        <a href="<?= base_url("/menu/addedit") ?>" aria-label="Add new menu">
                            <i class="text-accent text-lg lg:text-2xl fa-solid fa-circle-plus"></i>
                        </a>
                    </section>
                </ul>
            </section>
        </section>
        <section class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12" role="tabpanel" aria-labelledby="business-info-heading">
            <input type="radio" name="my-accordion-2" id="business-info-accordion" /> 
            <section class="collapse-title text-xl font-medium flex flex-row gap-3 w-full" id="business-info-heading">
                <i class="inline-block text-accent text-3xl fa-solid fa-circle-info"></i>
                <h3 class="text-xl lg:text-3xl">Business Information</h3>
            </section>
            <section id="business_info" class="collapse-content  bg-neutral flex flex-col gap-3"> 
                <i onclick="businessFormModal.showModal()" class="text-info text-base lg:text-xl fa-solid fa-pen-to-square text-end mt-3"></i>
                <?php include "templates/business_form.php"; ?>
            </section>
        </section>
        <section class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12" role="tabpanel" aria-labelledby="qr-codes-heading">
            <input type="radio" name="my-accordion-2" id="qr-codes-accordion" /> 
            <section class="collapse-title text-xl font-medium flex flex-row gap-3 w-full" id="qr-codes-heading">
                <i class="inline-block text-accent text-3xl fa-solid fa-qrcode"></i>
                <h3 class="text-xl lg:text-3xl">QR Codes</h3>
            </section>
            <section class="collapse-content bg-neutral"> 
                <section class="pt-3 flex flex-col gap-5">
                    <?php if (isset($menus)): ?>
                        <section>
                            <label class="pt-3 font-bold" for="menuId">Choose menu to generate QR code</label>
                            <select class="block w-1/2 text-center p-2 rounded-lg bg-neutral-content/20 text-accent mt-2" name="menuId" id="menuId">
                                <?php foreach ($menus as $menu): ?>
                                    <option value="<?= esc($menu['id']) ?>"><?= esc($menu['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </section>
                        
                        <section>
                            <label for="tableNum" class="pt-3 font-bold">Table number</label>
                            <input name="tableNum" id="tableNum" type="number" min="1" class="block w-1/2 text-center p-2 rounded-lg bg-neutral-content/20 text-accent mt-2">
                        </section>

                        <section class="flex flex-col text-center">
                            <button id="getQRCodeBtn" class="btn w-full btn-sm m-auto btn-accent md:w-8/12 md:btn-md">
                                Get QR code for 1 table
                            </button>
                        </section>

                    <?php else: ?>
                        <p>No menus created.</p>
                    <?php endif; ?>
                </section>
                <section id="qr-codes">
                    <ul></ul>
                </section>
            </section>
        </section>
        <section class="bg-base-200 lg:grow-0 lg:basis-5/12">
            <section class="collapse-title text-xl font-medium flex flex-row gap-3 w-full">
                <i class="inline-block text-accent text-3xl fa-solid fa-gears"></i>
                <a href="<?= base_url('ordersystem') ?>" class="text-xl lg:text-3xl text-info underline underline-offset-4">Order System</a>
            </section>
        </section>
    </section>
    <section>
        <section class="container md:w-4/6 m-auto mt-11 md:text-md">
            <?php if (session()->getFlashdata('success')): ?>
                <section role="alert" class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </section>
            <?php elseif (session()->getFlashdata('error')): ?>
                <section role="alert"  class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </section>
            <?php endif; ?>
        </section>
    </section>
    <!-- You can open the modal using ID.showModal() method -->
    <dialog id="qr" class="modal" aria-labelledby="qr-heading">
        <section class="modal-box p-10">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <section class="flex justify-between">
                <h3 id="qr-heading">Table</h3>
                <i class="fa-solid fa-print text-lg md:text-2xl"></i>
            </section>
            <section id="qrcode"></section>
        </section>
    </dialog>

    <script>
        const businessInfo = document.querySelector("#business_info")
        const businessFormTemplate = document.querySelector("#business_form");
        const businessForm = businessFormTemplate.cloneNode(true);
        let pageNum = 1;
        businessForm.id = "businessForEdit";

      // Waiting for all PHP files are loaded before calling the functions
        window.onload = () => {
            renderMenus();
        }

        /**
         * Fetches and renders the menus for the current business
         * as well as loading the pagination
         */
        async function renderMenus() {
            const menusContainer = document.querySelector("#menus_container>section");
            const businessMenus = await get('menus', null, pageNum, <?= esc($business['id']) ?>).catch(err => console.log("An error occurred when fetching menus. Error: ", err));
            console.log(businessMenus)

            if (businessMenus.length == 0) {
                // When the page required goes over the total number
                // of page available
                pageNum -= 1;
                return;
            }

            if (businessMenus) {
                menusContainer.innerHTML = "";

                // Populate the menu exists
                businessMenus.forEach(menu => {
                    const menuElement = `<section class="flex flex-row justify-between items-center pt-3" role="listitem">
                                            <li>
                                                <a href="<?= base_url("menu/") ?>/${menu.id}" aria-label="View menu ${menu.name}">
                                                    ${menu.name}
                                                </a>
                                            </li>
                                            <section class="flex gap-2 md:place-content-center items-baseline">
                                                <a href="<?= base_url("menu/addedit/")?>/${menu.id}" aria-label="Edit menu ${menu.name}">
                                                    <i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <i onclick="deleteMenu(${menu.id})" class="cursor-pointer text-red-500 text-base lg:text-xl fa-solid fa-trash-can" aria-label="Delete menu ${menu.name}"></i>
                                            </section>
                                        </section>`

                    menusContainer.innerHTML += menuElement;
                })
            }

            const pagination = `<section class="grid grid-cols-2 join m-auto mt-11 mb-5 w-1/2 md:w-2/6">
                                    <button onclick="getPreviousPage()" class="join-item btn btn-outline btn-sm md:btn-md" aria-label="Go to previous page">Previous</button>
                                    <button onclick="getNextPage()"  class="join-item btn btn-outline btn-sm md:btn-md" aria-label="Go to next page">Next</button>
                                </section>`;
            menusContainer.innerHTML += pagination
        }

        /**
         * Navigates to the previous page and renders the menus.
         */
        function getPreviousPage() {
            if (pageNum > 1) {
                pageNum -= 1;
                renderMenus();
            } 
        }

        /**
         * Navigates to the next page and renders the menus.
         */
        function getNextPage() {
            pageNum += 1;
            renderMenus();
        }
        

        /**
         * Renders a modal for editing business information.
         */
        function renderModal() {
            const dialog = document.createElement("dialog");
            dialog.classList.add("modal");
            dialog.id = "businessFormModal";

            const formHeader = businessForm.querySelector("h4");
            formHeader.className = "text-center font-sub-header text-accent text-xl md:text-2xl";
            formHeader.innerText = "Edit your business information";

            const modalContainer = document.createElement("section");
            modalContainer.className = "modal-box md:6/1 md:max-w-xl lg:w-8/12 lg:max-w-3xl p-7";

            const saveBtn = document.createElement("input");
            saveBtn.id = "saveBtn";
            saveBtn.classList.add("btn", "btn-accent");
            saveBtn.type = "submit";
            saveBtn.value = "Save"
            saveBtn.addEventListener("click", (e) => editForm(e))
            businessForm.append(saveBtn);

            const closeModalForm = document.querySelector("#close_modal_form").content.cloneNode(true).children[0];
            modalContainer.appendChild(closeModalForm);
            modalContainer.appendChild(businessForm);
            

            const formInputs = modalContainer.querySelectorAll("input");
            const formTextarea = modalContainer.querySelector("textarea");
            formInputs.forEach(input => input.removeAttribute("disabled"))
            formTextarea.removeAttribute("disabled");

            dialog.appendChild(modalContainer);
            businessInfo.appendChild(dialog);
        }

        /**
         * Handles the submission of the business edit form.
         * 
         * @param {Event} e - The form submission event.
         */
        async function editForm(e) {
            e.preventDefault();
            const businessFormModal = document.querySelector("#businessFormModal");

            if (businessForm.reportValidity()) {
                const formData = new FormData(businessForm);
                const data = Object.fromEntries(formData.entries());
                const file = businessFormModal.querySelector("#logo").files[0];

                if (file) {
                    // if user uploads a file, upload it and use the filename 
                    // to put into the database
                    const uploadFile = new FormData();
                    uploadFile.append('file', file)

                    await fetch("<?= base_url('upload/') ?>", {
                        method: "POST",
                        body: uploadFile
                    })
                    .then(res => res.json())
                    .then(json => data['logo'] = json['data'])
                } else {
                    // otherwise, remove that field
                    delete data['logo']
                }

                const result = await update("businesses", data)
                console.log(result);

                businessFormModal.close();
                // client side rendering not implemented so reload
                // the webpage to update the data
                location.reload();
            };
        }

        async function renderQrCodes() {
            const qrCodeContainer = document.querySelector('#qr-codes>ul')
            const businessId = <?= $business['id'] ?>;
            const business = await get('businesses', 3);
            const tableNum = business.table_num;
            let count = 1;

            
            while (count <= tableNum) {
                const qrcodeHTML = 
                    `<section class="flex flex-row justify-between items-center pt-3">
                        <h5 aria-label="Table number ${count}">Table ${count}</h5>
                        <i onclick="renderQRcodeModal(${count})" class="cursor-pointer text-info text-base lg:text-xl fa-solid fa-up-right-and-down-left-from-center" aria-label="Open QR code modal for table ${count}"></i>
                    </section>`

                count += 1;
                qrCodeContainer.innerHTML += qrcodeHTML;
            }
            
        }

        /**
         * Renders QR codes modal for each table in the business.
         */
        function renderQRcodeModal(menuId,tableNum) {
            const qrDialog = document.querySelector('#qr');
            const qrCodeContainer = qrDialog.querySelector('#qrcode');
            const print = qrDialog.querySelector("i");
            
            qrCodeContainer.innerHTML = "";

            // Modal header
            qrDialog.querySelector("h3").innerText = `Table ${tableNum}`;

            fetch(`<?= base_url('qrcode_gen/') ?>${menuId}/${tableNum}`)
            .then(data => data.text())
            .then(elem => qrCodeContainer.innerHTML += elem);

            print.onclick = () => {
                window.print();
            }

            qr.showModal();
        }

        /**
         * Deletes a menu by its ID and refreshes the menu list.
         * @param {number} menuId - The ID of the menu to delete.
         */
        async function deleteMenu(id) {
            if (confirm('Are you sure you want to delete this menu?')) {
                await deleteItem('menus', id)
                .then(data => { 
                    alert("Menu deleted successfully");
                    // Going back to the first page
                    pageNum = 1;
                    renderMenus();
                })
                .catch(err => console.log(err))
            }
        }

        document.querySelector("#getQRCodeBtn").onclick = () => {
            // Get the QR code input and render the QR code modal for that table
            const menuId = document.querySelector("#menuId").value;
            const tableNum = document.querySelector("#tableNum").value;
            if (tableNum > <?= $business['table_num'] ?>) {
                alert("This business only has <?= $business['table_num'] ?> tables")
            } else {
                tableNum ? renderQRcodeModal(menuId, tableNum) : alert('Please enter table number');
            }
        }
        
        renderModal();

    </script>
<?= $this->endSection() ?>