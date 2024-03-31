<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <section class="flex flex-col w-4/6 m-auto">
        <section class="flex flex-col w-full">
            <h3 class="lg:text-2xl text-xl font-bold mb-7 mt-10 text-accent text-center <?= $step == 4 ? 'hidden' : '' ?>">Sign up to your account</h3>
            <h3 class="lg:text-2xl text-xl font-bold mb-7 mt-10 text-accent text-center <?= $step != 4 ? 'hidden' : '' ?>">Thank you for creating an account with NomNomNow</h3>
            <ul class="steps steps-vertical mb-11">
                <li class="step <?= $step >= 1 ? 'step-secondary text-secondary' : '' ?> ">User Information</li>
                <li class="step <?= $step >= 2  ? 'step-secondary text-secondary' : '' ?>">Credentials</li>
                <li class="step <?= $step >= 3 ? 'step-secondary text-secondary' : '' ?>">Business Information</li>
            </ul>
            <form method="POST" >
                <section class="flex flex-col gap-5 lg:w-1/2 lg:m-auto <?= $step == 1 ? '' : 'hidden' ?>">
                    <div class="flex flex-col gap-2">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="p-2 rounded-lg" placeholder="Enter your name" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="p-2 rounded-lg" placeholder="Enter your email" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="phone">Phone Number</label>
                        <small class="text-accent italic">Format: 0123456789</small>
                        <input type="tel" name="phone" id="phone" class="p-2 rounded-lg" pattern="[0-9]{10}" placeholder="Enter your phone number" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <p>What is your role?</p>
                        <div class="flex flex-row justify-around">
                            <div class="w-1/3 flex flex-row items-center gap-2">
                                <input type="radio" class="radio radio-accent" value="owner" name="user_type" id="owner" checked />
                                <label for="owner">Owner</label>
                            </div>
                            <div class="w-1/3 flex flex-row items-center gap-2">
                                <input type="radio" class="radio radio-accent" value="staff" name="user_type" id="staff" />
                                <label for="staff">Staff</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row justify-evenly">
                        <a class="<?= $step - 1 <= 0 ? 'pointer-events-none' : '' ?>"   href="<?= $backStep = $step - 1; base_url('signup/' . $backStep);  ?>">
                            <i class="text-accent text-3xl fa-solid fa-circle-arrow-left <?= $step - 1 <= 0 ? 'text-neutral' : '' ?>" ></i>
                        </a>
                        <a href="<?= $nextStep = $step + 1;  base_url('signup/' . $nextStep)  ?>">
                            <i class="text-accent text-3xl fa-solid fa-circle-arrow-right" ></i>
                        </a>
                    </div>
                    <div class="flex flex-col">
                        <p>Already had an account? <a href="<?= base_url("login") ?>" class="text-accent font-bold">Sign In</a></p>
                    </div>                      
                </div>
                </section>
                <section class="flex flex-col gap-5 lg:w-1/2 lg:m-auto <?= $step == 2 ? '' : 'hidden' ?>">
                    <div class="flex flex-col gap-2">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="p-2 rounded-lg" placeholder="Enter your username" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="p-2 rounded-lg" placeholder="Enter your password" required>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="passwordRetype">Retype your password</label>
                        <input type="password" name="passwordRetype" id="passwordRetype" class="p-2 rounded-lg" placeholder="Enter your password" required>
                    </div>

                    <div class="flex flex-row justify-evenly">
                        <a href="<?=  $backStep = $step - 1; base_url('signup/' . $backStep);  ?>">
                            <i class="text-accent text-3xl fa-solid fa-circle-arrow-left" ></i>
                        </a>
                        <a href="<?= $nextStep = $step + 1; base_url('signup/' . $nextStep)  ?>">
                            <i class="text-accent text-3xl fa-solid fa-circle-arrow-right"></i>
                        </a>
                    </div>
                </section>
                
                <section class="flex flex-col gap-5 lg:w-1/2 lg:m-auto <?= $step == 3 ? '' : 'hidden' ?>">
                    <div class="flex flex-col gap-2">
                        <label for="business_name">Business name</label>
                        <input type="text" name="business_name" id="business_name" class="p-2 rounded-lg" placeholder="Enter your business name" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="tables">Number of tables available</label>
                        <input type="number" name="tables" id="tables" class="p-2 rounded-lg" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="desc">Short description of your business</label>
                        <textarea id="desc" name="desc" class="textarea textarea-accent" placeholder="Description"></textarea>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="logo">Logo of your business</label>
                        <input type="file" id="logo" name="logo" class="file-input file-input-bordered file-input-accent w-full max-w-xs file-input-sm lg:file-input-md" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="address">Your business's address</label>
                        <input type="text" name="address" id="address" class="p-2 rounded-lg" placeholder="Enter your business address" required>
                    </div>

                    <div class="flex flex-row justify-evenly">
                        <a href="<?=  $backStep = $step - 1; base_url('signup/' . $backStep);  ?>">
                            <i class="text-accent text-3xl fa-solid fa-circle-arrow-left" ></i>
                        </a>
                        <a href="<?= $nextStep = $step + 1; base_url('signup/' . $nextStep)  ?>">
                            <i class="text-accent text-3xl fa-solid fa-circle-check"></i>
                        </a>
                    </div>
                </section>
                <section class="flex flex-col gap-5 lg:w-1/2 lg:m-auto <?= $step == 4 ? '' : 'hidden' ?>">
                    <i class="text-success text-7xl m-auto animate-bounce fa-solid fa-circle-check"></i>
                </section>
            </form>
        </section>
    </section>
<?= $this->endSection(); ?>