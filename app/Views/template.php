<!DOCTYPE html>
<html lang="en" data-theme="sunset">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-value" content="<?= csrf_hash() ?>">
    <title>NomNomNow</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.9.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <style>
        #debug-bar div:nth-child(n + 2) {
            height: 50vh !important;
        }

    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Lilita+One&family=Righteous&family=Rubik+Bubbles&display=swap" rel="stylesheet">
</head>
<body class="font-body min-h-screen w-full bg-base-200 flex flex-col text-sm md:text-lg">
    <header class="sticky top-0 z-10" >
        <!-- Code snippets from daisy UI https://daisyui.com/components/navbar/ -->
        <section class="navbar bg-base-100 flex-wrap justify-end">
            <section class="flex-1" aria-label="Name of the website section">
                <?php if (!isset($customer_view)): ?>
                    <a 
                        class="btn btn-ghost text-3xl font-header" 
                        href="
                            <?php  
                                if (session()->get("usertype") == "admin") {
                                    echo base_url("admin");
                                } else if (session()->get("usertype") == "staff") {
                                    echo base_url("ordersystem/");
                                } else if (session()->get("isLoggedIn")) {
                                    echo base_url(session()->get('userId'));
                                } else {
                                    echo base_url("");
                                }
                            ?>"
                        aria-label="Website name NomNomNow"
                    >NomNomNow</a>
                <?php else: ?>
                    <a 
                        class="btn btn-ghost text-3xl font-header" 
                        href="<?= base_url("onlineorder/") . $menu['id']. '/' . $tableNum ?>"
                        aria-label="Name of the business"
                    ><?=esc($business['name']) ?></a>
                <?php endif; ?>
            </section>
            <?php if (!isset($customer_view) && !isset($checkout)): ?>
                <section class="flex-none">
                    <ul class="menu menu-horizontal px-1">
                        <li>
                            <details>
                                <summary class="text-base md:text-xl">
                                    <!-- check admin to make it easier for testing, IRL admin wouldn't have a business -->
                                    <?php if (session()->get('isLoggedIn')) : ?>
                                        <?php  if (isset($business)): ?>
                                            <?php if (esc(session()->get('usertype')) != 'staff'): ?>
                                                <section>
                                                    <a 
                                                        href="<?= base_url("admin/" . esc(session()->get('userId'))) ?>"                                     
                                                        class="btn btn-accent"
                                                        aria-label="Navigate to the admin page"
                                                    >Admin page</a>
                                                </section>
                                            <?php endif; ?>
                                            <section tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                                <section class="w-10 rounded-full">
                                                    <img 
                                                        id = "business_logo"
                                                        alt="The logo of <?= esc($business['name']) ?>" 
                                                        src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" 
                                                    />
                                                </section>
                                            </section>
                                        <?php else: ?>
                                            <?= esc(session()->get('name')) ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        Account
                                    <?php endif; ?>
                                </summary>
                                <ul class="p-2 bg-base-100 rounded-t-none" role="menu" aria-label="Drop-down list">
                                    <?php if (session()->get('isLoggedIn')): ?>
                                        <li class="text-sm md:text-md hover:bg-accent hover:text-base-100 hover:rounded-md" role="menuitem">
                                            <a href="<?= base_url("google_logout") ?>">Logout</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="text-sm md:text-md lg:text-lg hover:bg-accent hover:text-base-100 hover:rounded-md" role="menuitem">
                                            <a href="<?= base_url("login") ?>">Login</a>
                                        </li>
                                        <li class="text-sm md:text-md lg:text-lg hover:bg-accent hover:text-base-100 hover:rounded-md" role="menuitem">
                                            <a href="#">Sign Up</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </details>
                        </li>
                    </ul>
                </section>
            <?php elseif (!isset($checkout)): ?>
                <section class="indicator mr-4" aria-label="Shopping Cart Indicator">
                    <span class="indicator-item badge badge-accent badge-sm md:badge-sm" id="totalQuantity">0</span> 
                    <button onclick="showCart()" aria-label="Open Cart">
                        <i class="text-2xl fa-solid fa-cart-shopping md:text-3xl"></i>
                    </button>
                </section>
            <?php endif; ?>         
        </section>
    </header>

    <main class="grow shrink-0 basis-auto mb-5 flex items-stretch" role="main">
        <section class="grow <?= service('router')->getMatchedRoute()[0] == 'login' ? 'place-content-center' : ''; ?>">
            <?= $this->renderSection('content'); ?>
        </section>
    </main>

    <!-- Code snippet sourced from daisy UI https://daisyui.com/components/footer/ -->
    <footer class="footer footer-center p-4 bg-base-300 text-base-content shrink-0" role="footer">
        <aside aria-label="Copyright statement from NomNomNow">
            <p>Copyright &copy; <?= date('Y') ?> - All rights reserved by <span class="font-header">NomNomNow</span></p>
        </aside>
    </footer>


    <?php include __DIR__ . '/helpers/api_calls.php' ?>

    <script src="https://kit.fontawesome.com/fbc01cbf45.js" crossorigin="anonymous"></script>
    <script>
        let csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content'); // CSRF Token name
        let csrfHash = document.querySelector('meta[name="csrf-token-value"]').getAttribute('content'); // CSRF hash

        const smallScreenSize = window.matchMedia("(max-width: 768px)");
        const stepElements = document.getElementsByClassName("steps");
        const individualSteps = document.querySelectorAll(".step>span");
        console.log(individualSteps)
        const businessId =  "<?= isset($business['id']) ? esc($business['id']) : null ?>";
        const customer_view = "<?= isset($customer_view) ?  esc($customer_view) : null ?>";

        // Manually removing "step-vertical" class to make the
        // steps for sign up and menu creation/edit work properly
        // on mobile and desktop size (Since it doesn't work for Daisy UI CDN)
        if (window.innerWidth > 768) {
            /* the viewport is more than 600 pixels wide */
            for (let i = 0; i < stepElements.length; i++) {
                stepElements[i].classList.remove("steps-vertical");
            }

            for (let i = 0; i < individualSteps.length; i++) {
                individualSteps[i].classList.remove("hidden");
            }
        }

        smallScreenSize.onchange = (e) => {
            if (e.matches) {
                /* the viewport is 600 pixels wide or less */
                for (let i = 0; i < stepElements.length; i++) {
                    stepElements[i].classList.add("steps-vertical");
                }

                for (let i = 0; i < individualSteps.length; i++) {
                    individualSteps[i].classList.add("hidden");
                }
            } else {
                for (let i = 0; i < stepElements.length; i++) {
                    stepElements[i].classList.remove("steps-vertical");
                    individualSteps[i].classList.remove("hidden");
                }

                for (let i = 0; i < individualSteps.length; i++) {
                    individualSteps[i].classList.remove("hidden");
                }
            }
        };

        /**
         * Update the business logo avatar.
         * 
         * Fetches the business details using the provided businessId and updates the logo image if available.
         */
        function updateAvatar() {
            if (businessId) {
                get('businesses', businessId)
                .then(
                    data => 
                        data.logo ? 
                        document.querySelector("#business_logo").src = `data:image/jpeg;base64,${data.logo}` :
                        ''
                )
            }
        }

        tailwind.config = {
            daisyui: {
                themes: ["light", "dracula", "retro", "night", "sunset"],
            },
            theme: {
                extend: {
                fontFamily: {
                    header: ['Rubik Bubbles', 'Lilita One','sans-serif'],
                    'sub-header': ['Lilita One','sans-serif'],
                    body: ['Josefin Sans', 'Lilita One','sans-serif'],
                },
                },
            }
        }
        
        if (!customer_view) {
            updateAvatar();
        }

    </script>
</body>
</html>