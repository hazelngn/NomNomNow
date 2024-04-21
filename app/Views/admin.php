<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section class="md:w-4/6 m-auto flex flex-col">
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
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="usersList">
                        <!-- Users data will be here -->
                        <template id="userDetailsTemplate">
                            <tr>
                                <td><i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-trash-can"></i></td>
                                <td><i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-square-pen"></i></td>
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

    <?php include "helpers/api_calls.php" ?>
    <script>
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
                
                usersList.append(parent);
            });
            
        }

        async function getNeededDetails() {
            const users = await get("users");
            const neededStructure = Promise.all(users.map(async user => {
                let business = await get("businesses");
                business = business.filter(busi => busi.user_id == user.id)[0];


                const result = {
                    user_id: user.id,
                    username: user.username,
                    businessName: business ? business.name : "N.A",
                    businessID: business ? business.id : "N.A",
                    status: user.status ? "active" : "not active",
                }
                
                return result;
            }))
            
            return neededStructure;
        }

        listUserDetails();

    </script>

<?= $this->endSection() ?>