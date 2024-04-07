<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section class="hero min-h-fit p-5">
        <div class="hero-content flex-col md:flex-row">
            <img src="<?= base_url('images/landingPage/landing.png') ?>" class="lg:max-w-sm max-w-60 rounded-lg shadow-2xl" />
            <div>
                <h1 class="text-2xl md:text-5xl font-bold font-sub-header">Welcome to <span class="font-header text-accent">NomNomNow</span></h1>
                <p class="text-sm md:text-lg py-6 text-dark-beige">Create Digital Menu So Easily with Us!!</p>
                <button class="btn btn-accent">
                    <a href="<?= base_url("/signup") ?>">Get Started</a>
                </button>
            </div>
        </div>
    </section>

    <section class="min-h-fit p-5">
        <section class="w-4/5 md:w-4/6 m-auto">
            <h1 class="text-2xl md:text-4xl font-bold font-sub-header">Features</h1>
            <section class="flex flex-col md:flex-row gap-5 items-baseline place-content-center pt-5 text-dark-beige">
                <article class="mt-5 md:mt-0 w-full flex flex-row justify-center md:flex-col md:basis-4/12 md:grow-0 justify-items-center text-center">
                    <img src="<?= base_url('images/landingPage/menu.png') ?>" class="w-24 h-24 md:w-40 md:h-40 m-auto"/>
                    <div class="text-sm md:text-lg mt-10">
                        <p>Easy to create, flexible menu </p>
                        <p>Created in 3 steps</p>
                        <p>Change anytime</p>
                    </div>
                </article>
                <article class="mt-5 md:mt-0 w-full flex flex-row justify-center md:flex-col md:basis-4/12 md:grow-0 justify-items-center text-center">
                    <img src="<?= base_url('images/landingPage/manage.png') ?>" class="w-24 h-24 md:w-40 md:h-40 m-auto"/>
                    <div class="text-sm md:text-lg mt-10">
                        <p>Live managing orders for staffs</p>
                    </div>
                </article>
                <article class="mt-5 lg:mt-0 w-full flex flex-row justify-center md:flex-col md:basis-4/12 md:grow-0 justify-items-center text-center">
                    <img src="<?= base_url('images/landingPage/qr-code.png') ?>" class="w-24 h-24 md:w-40 md:h-40 m-auto"/>
                    <div class="text-sm lg:text-lg mt-10">
                        <p>Online ordering via QR code</p>
                    </div>
                </article>
            </section>
            
        </section>
    </section>
<?= $this->endSection() ?>