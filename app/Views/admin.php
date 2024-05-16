<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section id="main-content" class="md:w-5/6 m-auto flex flex-col">
        <h3 class="text-3xl font-body mt-5 text-center font-bold">Administration</h3>

        <section class="flex flex-col text-cente gap-5 p-3 mt-8 md:mt-11 md:mb-11 md:text-lg">
            <section class="overflow-x-auto">
                <table class="table table-zebra border-collapse" aria-label="User List">
                    <thead class="hidden lg:table-header-group">
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>User Type</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Business name</th>
                            <th>Business ID</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="usersList" aria-live="polite">
                        <!-- Users data will be here -->

                    </tbody>
                    <template id="userDetailsTemplate">
                        <tr class="flex flex-wrap mb-8 md:mb-11 lg:mb-0 w-10/12 m-auto lg:w-full lg:table-row">
                            <td class="hidden lg:table-cell">
                                <i id="editBtn" class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-square-pen" aria-label="Edit User"></i>
                            </td>
                            <td class="hidden lg:table-cell">
                                <i id="deleteBtn" class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-trash-can" aria-label="Delete User"></i>
                            </td>
                            <td class="relative w-1/2 pt-9 border-current border flex place-content-center gap-2 lg:hidden">
                                <i id="editBtnMobile" class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-2xl fa-solid fa-square-pen" aria-label="Edit User"></i>
                                <i id="deleteBtnMobile" class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-2xl fa-solid fa-trash-can" aria-label="Delete User"></i>
                            </td>
                        </tr>
                    </template>
                </table>
            </section>
        </section>

        <button onclick="addEditUser()" class="btn btn-accent btn-sm md:btn-md m-auto" aria-label="Add a new user">Add a new user</button>
        <section class="grid grid-cols-2 join m-auto mt-11 w-1/2 md:w-2/6" aria-label="Pagination">
            <button onclick="getPreviousPage()" class="join-item btn btn-outline btn-sm md:btn-md">Previous</button>
            <button onclick="getNextPage()" class="join-item btn btn-outline btn-sm md:btn-md">Next</button>
        </section>
    </section>

    <template id="childTemplate">
        <p class="basis-1/12 grow-0">User ID</p>
    </template>

    <?php include 'templates/admin_form.php'; ?>

    <script>
        let adminFormTemplate;
        // Determines the current page number for pagination
        let pageNum = 1;

        // Waiting for all PHP files are loaded before calling the functions
        window.onload = () => {
            listUserDetails();
            adminFormTemplate = document.querySelector("#adminFormTemplate");
        }

        /**
         * Decrements the page number and fetches the user details for the previous page.
         */
        function getPreviousPage() {
            if (pageNum > 1) {
                pageNum -= 1;
                listUserDetails();
            } 
        }

        /**
         * Increments the page number and fetches the user details for the next page.
         */
        function getNextPage() {
            pageNum += 1;
            listUserDetails();
        }

        /**
         * Fetches and displays the user details based on the current page number.
         */
        async function listUserDetails() {
            const parentTemplate = document.querySelector("#userDetailsTemplate");
            const usersList = document.querySelector("#usersList");
            const tableHeaders = document.querySelectorAll("thead>tr>th");
            let details = await getNeededDetails();

            if (details) {
                usersList.innerHTML = "";
                details.forEach(detail => {
                    // Populate each row of the table with each user
                    const parent = parentTemplate.content.cloneNode(true).children[0];
                    const beforePoint = parent.children[0];
                    let idx = 0;

                    parent.id = detail.user_id;
                    for (const [key,value] of Object.entries(detail)) {
                        const td = document.createElement('td');
                        td.className = 'relative w-1/2 pt-9 border-current border overflow-x-clip lg:pt-1 lg:border-0'
                        const header = tableHeaders[idx].innerHTML;
                        const mobileSpan = `<span class="lg:hidden bg-slate-500	font-bold uppercase absolute top-0 left-0 p-1">${header}</span>${value}`;
                        td.innerHTML = mobileSpan;
                        parent.insertBefore(td, beforePoint);
                        idx += 1
                    }

                    //button actions 
                    parent.querySelector("#editBtn").onclick =  () => addEditUser(detail.user_id);
                    parent.querySelector("#deleteBtn").onclick =  async () => {
                        if (confirm(`Are you sure you want to delete user ${detail.name}?`)) {
                            await deleteItem('users', detail.user_id)
                            .then(data => {
                                alert(`User ${detail.name} has been successfully deleted`);
                                pageNum = 1;
                            })
                            .catch(err => console.log(err))
                            listUserDetails();
                        }
                    };

                    // Button actions but only on mobile
                    parent.querySelector("#editBtnMobile").onclick =  () => addEditUser(detail.user_id);
                    parent.querySelector("#deleteBtnMobile").onclick =  async () => {
                        if (confirm(`Are you sure you want to delete user ${detail.name}?`)) {
                            await deleteItem('users', detail.user_id)
                            .then(data => {
                                alert(`User ${detail.name} has been successfully deleted`);
                                pageNum = 1;
                            })
                            .catch(err => console.log(err))
                            listUserDetails();
                        }
                    };
                    
                    usersList.append(parent);
                });
            }
        }


        /**
         * Fetches the necessary details for displaying user information.
         * Filters users based on the current user's type and business association 
         * if the user is a business owner.
         * 
         * @returns {Array} An array of user details with the needed structure.
         */
        async function getNeededDetails() {
            let users = await get("users", null, pageNum);
            const currentUser = await get("users", <?= esc(session()->get('userId')) ?>)

            if ("<?= esc(session()->get('usertype')) ?>" == "owner") {
                // If this is the admin page for the business owner, they should only 
                // be able to see the users linked to their business.
                let business = await get("businesses");
                business = business.find(busi => busi.id == currentUser.business_id);
                users = await get("users", null, pageNum, business.id);
            }
             
            if (users.length == 0) {
                // This is reached when the page number goes over 
                // the total number of pages available
                pageNum -= 1;
                return;
            }

            // Create an array of user objects containing all the fields required
            // for each table row.
            const neededStructure = Promise.all(users.map(async user => {
                let business = await get("businesses");
                business = business.find(busi => busi.id == user.business_id);

                const result = {
                    user_id: user.id,
                    name: user.name,
                    user_type: user.usertype,
                    email: user.email,
                    phone: user.phone ? user.phone : "N.A",
                    businessName: business ? business.name : "N.A",
                    businessID: business ? business.id : "N.A",
                }
                
                return result;
            }))
            
            return neededStructure;
        }

        /**
         * Opens the add/edit user modal and handles the form submission.
         * 
         * @param {number} id - The ID of the user to edit (optional).
         */
        async function addEditUser(id) {
            const adminForm = adminFormTemplate.content.cloneNode(true).children[0];
            const mainContent = document.querySelector("#main-content");
            mainContent.append(adminForm);

            const name = adminForm.querySelector("input#name");
            const businessName = adminForm.querySelector("input#businessName");
            const status = adminForm.querySelector("#status");
            const userId = adminForm.querySelector("#id");
            const usertype = adminForm.querySelector("#usertype");
            const header = adminForm.querySelector("h3>span");

            if (id) {
                // Edit if id is provided
                // Populate data to the modal
                const user = await get("users", id);
                const business = await get("businesses", user.business_id);
                name.value = user.name;
                businessName.value = business.name;
                usertype.value = user.usertype;
                header.innerText = "Edit";
                const phone = `<section class="flex flex-col gap-2">
                    <label class="font-bold" for="phone">Phone</label>
                    <input type="tel" name="phone" id="phone" class="p-2 rounded-lg" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required value=${user.phone}>
                </section>`
                businessName.insertAdjacentHTML("afterend", phone);;

                if ("<?= esc(session()->get('usertype')) ?>" == "admin" && "<?= esc(session()->get('userId')) ?>" == id) {
                    // Admin can't change their user type
                    usertype.previousElementSibling.remove();
                    usertype.remove()
                }

            } else {
                // Adding more fields needed to add user to the database
                header.innerText = "Add"
                const username = `<section class="flex flex-col gap-2">
                    <label class="font-bold" for="username">Username</label>
                    <input type="text" name="username" id="username" class="p-2 rounded-lg" required>
                </section>`;
                const email = `<section class="flex flex-col gap-2">
                    <label class="font-bold" for="email">Email</label>
                    <input type="email" name="email" id="email" class="p-2 rounded-lg" required>
                </section>`;
                const phone = `<section class="flex flex-col gap-2">
                    <label class="font-bold" for="phone">Phone</label>
                    <input type="tel" name="phone" id="phone" class="p-2 rounded-lg" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
                </section>`;

                if ("<?= esc(session()->get('usertype')) ?>" == "owner") {
                    // If the user is the owner, include the business ID
                    const user = await get("users", <?= esc(session()->get('userId')) ?>);
                    const businessInput = `<input class="btn btn-accent mt-3" name="business_id" type="hidden" value=${user.business_id}>`;
                    usertype.insertAdjacentHTML("afterend", businessInput);
                }

                name.previousElementSibling.insertAdjacentHTML("beforebegin", username)
                businessName.insertAdjacentHTML("afterend", email);
                businessName.insertAdjacentHTML("afterend", phone);
                
                businessName.previousElementSibling.remove();
                businessName.remove();
            }

            if ("<?= session()->get('usertype') ?>" == "owner") {
                // When admin is a business owner, they can't set users as "admin" (highest privilege)
                usertype.options[0].remove();
            }

            adminForm.querySelector("#submitBtn").onclick = async (e) => {
                e.preventDefault();
                if (adminForm.querySelector("#admin_form").reportValidity()) {
                    const adminFormData = new FormData(adminForm.querySelector("#admin_form"));
                    const data = Object.fromEntries(adminFormData.entries());

                    if (id) {
                        // Edit
                        const user = await get("users", id);
                        const business = await get("businesses", user.business_id);


                        const updatedUserData = {
                            ...user,
                            name: data.name,
                            usertype: data.usertype,
                            phone: data.phone
                        }

                        const updatedBusinessData = {
                            ...business,
                            name: data.businessName,
                            logo: business.logoURL
                        }

                        await update("users", updatedUserData)
                        .catch(err => console.log(err))

                        await update("businesses", updatedBusinessData)
                        .catch(err => console.log(err))
                        
                    } else {
                        // Add
                        const result = await add('users', data);
                    }

                    listUserDetails();
                    adminForm.remove();
                }
            }

            adminForm.querySelector("#close_modal").onclick = () => adminForm.remove()
            
            admin_modal.showModal();
        }
    </script>

<?= $this->endSection() ?>