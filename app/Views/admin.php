<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section id="main-content" class="md:w-5/6 m-auto flex flex-col">
        <h3 class="text-3xl font-body mt-5 text-center font-bold">Administration</h3>
        <form method="get" action="<?= base_url(); ?>">
            <section class="flex justify-center items-center mt-5 gap-2">
                <label class="input input-bordered flex items-center gap-2 w-8/12 md:w-6/12">
                    <input type="text" placeholder="Search" />
                </label>
                <i class="text-accent md:text-xl fa-solid fa-magnifying-glass"></i>
            </section>
        </form>
            
        <section  class="flex flex-col text-cente gap-5 p-3 mt-11 mb-11 md:text-lg">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <!-- head -->
                    <thead>
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
                    <tbody id="usersList">
                        <!-- Users data will be here -->
                        
                    </tbody>
                    <template id="userDetailsTemplate">
                        <tr>
                            <td><i id="editBtn" class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-square-pen"></i></td>
                            <td><i id="deleteBtn" class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-trash-can"></i></td>
                        </tr>
                    </template>
                </table>
            </div>
        </section>

        <button onclick="addEditUser()" class="btn btn-accent w-2/12 m-auto">Add a new user</button>
        <div class="join grid grid-cols-2">
            <button onclick="getPreviousPage()" class="join-item btn btn-outline">Previous page</button>
            <button onclick="getNextPage()"  class="join-item btn btn-outline">Next</button>
        </div>

        <!-- Pagination -->
        <!-- <div class="join m-auto self-center">
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="1" checked />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="2" />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="3" />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="4" />
        </div> -->
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
            const parentTemplate = document.getElementById("userDetailsTemplate");
            const usersList = document.getElementById("usersList");
            usersList.innerHTML = "";
            let details = await getNeededDetails();

            details.forEach(detail => {
                const parent = parentTemplate.content.cloneNode(true).children[0];
                const beforePoint = parent.children[0];

                parent.id = detail.user_id;
                for (const [key,value] of Object.entries(detail)) {
                    const td = document.createElement('td');
                    td.innerText = value;
                    parent.insertBefore(td, beforePoint);
                }

                //edit 
                parent.querySelector("#editBtn").onclick =  () => addEditUser(detail.user_id);
                parent.querySelector("#deleteBtn").onclick =  async () => {
                    if (confirm(`Are you sure you want to delete user ${detail.name}?`)) {
                        await deleteItem('users', detail.user_id)
                        .then(data => alert(`User ${detail.name} has been successfully deleted`))
                        .catch(err => console.log(err))
                        listUserDetails();
                    }
                };
                
                usersList.append(parent);
            });
            
        }

        async function getNeededDetails() {
            const users = await get("users", null, pageNum);
            const neededStructure = Promise.all(users.map(async user => {
                let business = await get("businesses");
                business = business.filter(busi => busi.id == user.business_id)[0];


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
                header.innerText = "Edit"
            } else {
                header.innerText = "Add"
                const username = `<div class="flex flex-col gap-2">
                    <label class="font-bold" for="username">Username</label>
                    <input type="text" name="username" id="username" class="p-2 rounded-lg" required>
                </div>`;
                const email = `<div class="flex flex-col gap-2">
                    <label class="font-bold" for="email">Email</label>
                    <input type="email" name="email" id="email" class="p-2 rounded-lg" required>
                </div>`;
                const phone = `<div class="flex flex-col gap-2">
                    <label class="font-bold" for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="p-2 rounded-lg" required>
                </div>`;
                name.previousElementSibling.insertAdjacentHTML("beforebegin", username)
                businessName.insertAdjacentHTML("afterend", email);
                businessName.insertAdjacentHTML("afterend", phone);
                
                businessName.previousElementSibling.remove();
                businessName.remove();
            }

            adminForm.querySelector("#submitBtn").onclick = async (e) => {
                e.preventDefault();
                if (adminForm.querySelector("#admin_form").reportValidity()) {
                    const adminFormData = new FormData(adminForm.querySelector("#admin_form"));
                    const data = Object.fromEntries(adminFormData.entries());

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
                        }


                        await update("users", updatedUserData)
                        .catch(err => console.log(err))

                        await update("businesses", updatedBusinessData)
                        .catch(err => console.log(err))
                        
                    } else {
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