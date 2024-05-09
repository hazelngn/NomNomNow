<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section id="main-content" class="md:w-4/6 m-auto flex flex-col">
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
                            <th>Business name</th>
                            <th>Business ID</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="usersList">
                        <!-- Users data will be here -->
                        <template id="userDetailsTemplate">
                            <tr>
                                <td><i id="editBtn" class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-square-pen"></i></td>
                                <td><i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-trash-can"></i></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Pagination -->
        <div class="join m-auto self-center">
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="1" checked />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="2" />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="3" />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="4" />
        </div>
    </section>

    <template id="childTemplate">
        <p class="basis-1/12 grow-0">User ID</p>
    </template>

    <?php include 'templates/admin_form.php'; ?>

    <script>
        let adminFormTemplate;

        window.onload = () => {
            listUserDetails();
            adminFormTemplate = document.querySelector("#adminFormTemplate");
        }

        async function listUserDetails() {
            const parentTemplate = document.getElementById("userDetailsTemplate");
            const usersList = document.getElementById("usersList");
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
                
                usersList.append(parent);
            });
            
        }

        async function getNeededDetails() {
            const users = await get("users");
            const neededStructure = Promise.all(users.map(async user => {
                let business = await get("businesses");
                business = business.filter(busi => busi.id == user.business_id)[0];


                const result = {
                    user_id: user.id,
                    username: user.username,
                    businessName: business ? business.name : "N.A",
                    businessID: business ? business.id : "N.A",
                    status: user.status == '1' ? "active" : "not active",
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

            const name = adminForm.querySelector("input#username");
            const businessName = adminForm.querySelector("input#businessName");
            const status = adminForm.querySelector("#status");
            const userId = adminForm.querySelector("#id");

            if (id) {
                const user = await get("users", id);
                const business = await get("businesses", user.business_id);
                console.log(user, business)
                name.value = user.username;
                businessName.value = business.name;
                status.value = user.status == '1' ? "active" : "not active";
            }


            adminForm.querySelector("#close_modal").addEventListener("click", () => adminForm.remove())
            
            admin_modal.showModal();
        }

        

    </script>

<?= $this->endSection() ?>