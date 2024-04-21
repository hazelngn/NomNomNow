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
        <section id="usersList" class="flex flex-col text-cente gap-5 p-3 mt-11 mb-11 md:text-lg">
            <div class="flex gap-1">
                <p class="basis-1/12 grow-0">User ID</p>
                <p class="basis-3/12 grow-0">User name</p>
                <p class="basis-3/12 grow-0">Business name</p>
                <p class="basis-1/12 grow-0">Business ID</p>
                <p class="basis-2/12 grow-0">Status</p>
                <p class="basis-1/12 grow-0">Delete</p>
                <p class="basis-1/12 grow-0">Edit</p>
            </div>
            <!-- Users data will be here -->
        </section>
        <!-- Pagination -->
        <div class="join m-auto self-center">
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="1" checked />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="2" />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="3" />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="4" />
        </div>
    </section>

    <template id="userDetailsTemplate">
        <div class="flex gap-1">
            <i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-trash-can"></i>
            <i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-square-pen"></i>
        </div>
    </template>
    <template id="childTemplate"> 
        <p class="basis-1/12 grow-0"></p>
    </template>

    <?php include "helpers/api_calls.php" ?>
    <script>
        async function listUserDetails() {
            const parentTemplate = document.getElementById("userDetailsTemplate");
            const childTemplate = document.getElementById("childTemplate");
            const usersList = document.getElementById("usersList");
            const users = await get("users");
            users.forEach(user => {
                const parent = parentTemplate.content.cloneNode(true).children[0];
                const appendPoint = parent.children[0];
                parent.id = user.id;
                for (const [key, value] of Object.entries(user)) {
                    const child = childTemplate.content.cloneNode(true).children[0];
                    child.innerText = value
                    parent.insertBefore(child, appendPoint);
                }
                usersList.append(parent);
            });
            
        }

        listUserDetails();

    </script>

<?= $this->endSection() ?>