<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section id="main-content" class="md:w-5/6 m-auto flex flex-col">
        <h3 class="text-3xl font-body mt-5 text-center font-bold">Administration</h3>
        <form method="get" action="<?= base_url(); ?>">
            <section class="flex justify-center items-center mt-5 gap-2">
                <label class="input input-bordered flex items-center gap-2 w-8/12 md:w-6/12" aria-label="Search">
                    <input type="text" placeholder="Search" aria-label="Search input">
                </label>
                <i class="text-accent md:text-xl fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            </section>
        </form>

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
        let pageNum = 1;

        window.onload = () => {
            listUserDetails();
            adminFormTemplate = document.querySelector("#adminFormTemplate");
        }

        function getPreviousPage() {
            if (pageNum > 1) {
                pageNum -= 1;
                listUserDetails();
            } 
        }

        function getNextPage() {
            pageNum += 1;
            listUserDetails();
        }

        async function listUserDetails() {
            const parentTemplate = document.querySelector("#userDetailsTemplate");
            const usersList = document.querySelector("#usersList");
            const tableHeaders = document.querySelectorAll("thead>tr>th");
            let details = await getNeededDetails();

            if (details) {
                usersList.innerHTML = "";
                details.forEach(detail => {
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


        async function getNeededDetails() {
            let users = await get("users", null, pageNum);
            const currentUser = await get("users", <?= esc(session()->get('userId')) ?>)
            if ("<?= esc(session()->get('usertype')) ?>" == "owner") {
                let business = await get("businesses");
                business = business.find(busi => busi.id == currentUser.business_id);
                users = await get("users", null, pageNum, business.id);
            }
             
            if (users.length == 0) {
                pageNum -= 1;
                return;
            }

            

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

        async function addEditUser(id) {
            // modals
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
                const user = await get("users", id);
                const business = await get("businesses", user.business_id);
                name.value = user.name;
                businessName.value = business.name;
                usertype.value = user.usertype;
                header.innerText = "Edit";

            } else {
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
                    <input type="text" name="phone" id="phone" class="p-2 rounded-lg" required>
                </section>`;

                if ("<?= esc(session()->get('usertype')) ?>" == "owner") {
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
                usertype.options[0].remove();
            }

            adminForm.querySelector("#submitBtn").onclick = async (e) => {
                e.preventDefault();
                if (adminForm.querySelector("#admin_form").reportValidity()) {
                    const adminFormData = new FormData(adminForm.querySelector("#admin_form"));
                    const data = Object.fromEntries(adminFormData.entries());
                    // console.log(data)

                    if (id) {
                        const user = await get("users", id);
                        const business = await get("businesses", user.business_id);


                        const updatedUserData = {
                            ...user,
                            name: data.name,
                            usertype: data.usertype
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
                        const result = await add('users', data);
                        console.log(result);
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