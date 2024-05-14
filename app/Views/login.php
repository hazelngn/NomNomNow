<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <section class="flex flex-row w-4/6 gap-5 m-auto items-center" aria-label="Sign-in section">
        <section class="md:w-1/2 lg:block hidden">
            <img class="max-w-96 m-auto" src="<?= base_url('images/login.png') ?>" alt="Sign-in image" aria-hidden="true">
        </section>
        <section class="md:w-4/6 md:m-auto flex flex-col w-full">
            <h3 class="lg:text-2xl text-xl font-bold mb-5 text-accent text-center" ari>Sign in to your account</h3>
            <form class="flex flex-col gap-5 lg:w-1/2 lg:m-auto" role="form">
                <section class="flex flex-col gap-2">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="p-2 rounded-lg" placeholder="Enter your username" required aria-required="true">
                </section>
                <section class="flex flex-col gap-2">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="p-2 rounded-lg" placeholder="Enter your password" required aria-required="true">
                </section>
                <section class="flex flex-col">
                    <input type="submit" class="p-2 btn btn-accent" value="Sign In" aria-label="Sign In button">
                    <section class="mt-4">
                        <p>Don't have an account? <a href="<?= base_url("signup") ?>" class="text-accent font-bold" aria-label="Sign Up button">Sign Up</a></p>
                    </section>
                </section>
                <section class="flex flex-col">
                    <h3 aria-label="Alternative sign in options">Or sign in with...</h3>
                    <section class="flex justify-evenly md:mt-5 md:text-3xl mt-3 text-2xl text-accent">
                        <a href="<?= base_url("google_login") ?>" aria-label="Sign in with Google"><i class="fa-brands fa-google"></i></a>
                        <i class="fa-brands fa-github" aria-label="Sign in with GitHub"></i>
                        <i class="fa-brands fa-facebook" aria-label="Sign in with Facebook"></i>
                    </section>
                </section>
            </form>
        </section>
    </section>

<?= $this->endSection(); ?>