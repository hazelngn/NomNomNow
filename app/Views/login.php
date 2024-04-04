<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <section class="flex flex-row w-4/6 m-auto items-center">
        <section class="lg:w-1/2 lg:block hidden">
            <img class="max-w-96 m-auto" src="<?= base_url('images/login.png') ?>" alt="">
        </section>
        <section class="lg:w-1/2 flex flex-col w-full">
            <h3 class="lg:text-2xl text-xl font-bold mb-5 text-accent text-center">Sign in to your account</h3>
            <form method="" action="<?= base_url("1") ?>" class="flex flex-col gap-5 lg:w-1/2 lg:m-auto">
                <div class="flex flex-col gap-2">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="p-2 rounded-lg" placeholder="Enter your username" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="p-2 rounded-lg" placeholder="Enter your password" required>
                </div>
                <div class="flex flex-col">
                    <input type="submit" class="p-2 btn btn-accent" value="Sign In">
                    <div class="mt-4">
                        <p>Don't have an account? <a href="<?= base_url("signup") ?>" class="text-accent font-bold">Sign Up</a></p>
                    </div>                        
                </div>
            </form>
        </section>
    </section>
<?= $this->endSection(); ?>