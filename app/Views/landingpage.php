<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section class="hero min-h-fit p-5" aria-label="Welcome section">
        <section class="hero-content flex-col md:flex-row">
            <img src="<?= base_url('images/landingPage/landing.png') ?>" class="lg:max-w-sm max-w-60 rounded-lg shadow-2xl" alt="Welcome image"/>
            <section>
                <h1 class="text-2xl md:text-5xl font-bold font-sub-header">Welcome to <span class="font-header text-accent">NomNomNow </span></h1>
                <p class="text-sm md:text-lg py-6 text-dark-beige">Create Digital Menu So Easily with Us!!</p>
                <button class="btn btn-accent">
                    <a href="<?= base_url("/signup") ?>">Get Started</a>
                </button>
            </section>
        </section>
    </section>

    <section class="min-h-fit p-5" aria-label="Features section">
        <section class="w-4/5 md:w-4/6 m-auto">
            <h1 class="text-2xl md:text-4xl font-bold font-sub-header">Features</h1>
            <section class="flex flex-col md:flex-row gap-5 items-baseline place-content-center pt-5 text-dark-beige">
                <article class="mt-5 md:mt-0 w-full flex flex-row justify-center md:flex-col md:basis-4/12 md:grow-0 justify-items-center text-center" aria-label="Menu feature">
                    <img src="<?= base_url('images/landingPage/menu.png') ?>" class="w-24 h-24 md:w-40 md:h-40 m-auto" alt="Menu icon"/>
                    <section class="text-sm md:text-lg mt-10">
                        <p>Easy to create, flexible menu </p>
                        <p>Created in 3 steps</p>
                        <p>Change anytime</p>
                    </section>
                </article>
                <article class="mt-5 md:mt-0 w-full flex flex-row justify-center md:flex-col md:basis-4/12 md:grow-0 justify-items-center text-center" aria-label="Order management feature">
                    <img src="<?= base_url('images/landingPage/manage.png') ?>" class="w-24 h-24 md:w-40 md:h-40 m-auto" alt="Order management icon"/>
                    <section class="text-sm md:text-lg mt-10">
                        <p>Live managing orders for staffs</p>
                    </section>
                </article>
                <article class="mt-5 lg:mt-0 w-full flex flex-row justify-center md:flex-col md:basis-4/12 md:grow-0 justify-items-center text-center" aria-label="Online ordering feature">
                    <img src="<?= base_url('images/landingPage/qr-code.png') ?>" class="w-24 h-24 md:w-40 md:h-40 m-auto" alt="QR code icon"/>
                    <section class="text-sm lg:text-lg mt-10">
                        <p>Online ordering via QR code</p>
                    </section>
                </article>
            </section>
        </section>
    </section>

<?= $this->endSection() ?>