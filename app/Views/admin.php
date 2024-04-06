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
        <section class="flex flex-col text-cente gap-5 p-3 mt-11 mb-11 md:text-lg">
            <div class="flex gap-1">
                <p class="basis-1/12 grow-0">User ID</p>
                <p class="basis-3/12 grow-0">User name</p>
                <p class="basis-3/12 grow-0">Business name</p>
                <p class="basis-1/12 grow-0">Business ID</p>
                <p class="basis-2/12 grow-0">Status</p>
                <p class="basis-1/12 grow-0">Delete</p>
                <p class="basis-1/12 grow-0">Edit</p>
            </div>
            <div class="flex gap-1">
                <p class="basis-1/12 grow-0">1</p>
                <p class="basis-3/12 grow-0">Hazel</p>
                <p class="basis-3/12 grow-0">Carrot Co.</p>
                <p class="basis-1/12 grow-0">1</p>
                <p class="basis-2/12 grow-0">Active</p>
                <i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-trash-can"></i>
                <i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-square-pen"></i>
            </div>
            <div class="flex gap-1">
                <p class="basis-1/12 grow-0">2</p>
                <p class="basis-3/12 grow-0">Ava</p>
                <p class="basis-3/12 grow-0">Slay Co.</p>
                <p class="basis-1/12 grow-0">2</p>
                <p class="basis-2/12 grow-0">Active</p>
                <i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-trash-can"></i>
                <i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-square-pen"></i>
            </div>
            <div class="flex gap-1">
                <p class="basis-1/12 grow-0">3</p>
                <p class="basis-3/12 grow-0">Josh</p>
                <p class="basis-3/12 grow-0">V. Slay Co.</p>
                <p class="basis-1/12 grow-0">3</p>
                <p class="basis-2/12 grow-0">Active</p>
                <i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-trash-can"></i>
                <i class="basis-1/12 grow-0 text-accent text-base cursor-pointer md:text-lg fa-solid fa-square-pen"></i>
            </div>
        </section>
        <div class="join m-auto self-center">
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="1" checked />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="2" />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="3" />
            <input class="join-item btn btn-neutral btn-square " type="radio" name="options" aria-label="4" />
        </div>
    </section>
<?= $this->endSection() ?>