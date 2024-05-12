<!DOCTYPE html>
<html lang="en" data-theme="sunset">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="navbar bg-base-100 flex-wrap justify-end">
            <div class="flex-1">
                <?php if (!isset($customer_view)): ?>
                    <a 
                        class="btn btn-ghost text-3xl font-header" 
                        href="
                            <?= 
                                base_url(session()->get("usertype") == "admin" ? "admin" : (session()->get("isLoggedIn") ? session()->get('userId') : "")); 
                            ?>"
                    >NomNomNow</a>
                <?php else: ?>
                    <a class="btn btn-ghost text-3xl font-header" href="<?= base_url("onlineorder/") . $menu['id']. '/' . $tableNum ?>"><?= $business['name'] ?></a>
                <?php endif; ?>
            </div>
            <?php if (!isset($customer_view) && !isset($checkout)): ?>
                <div class="flex-none">
                    <ul class="menu menu-horizontal px-1">
                        <li>
                            <details>
                                <summary class="text-base md:text-xl">
                                    <!-- check admin to make it easier for testing, IRL admin wouldn't have a business -->
                                    <?php if (session()->get('isLoggedIn')) : ?>
                                        <?php  if (isset($business)): ?>
                                            <section>
                                                <a 
                                                    href="<?= base_url("admin/" . $business['id']) ?>"                                     
                                                    class="btn btn-accent"
                                                >Admin page</a>
                                            </section>
                                            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                                <div class="w-10 rounded-full">
                                                    <img 
                                                        id = "business_logo"
                                                        alt="The logo of <?= $business['name'] ?>" 
                                                        src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" 
                                                    />
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <?= session()->get('name') ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        Account
                                    <?php endif; ?>
                                </summary>
                                <ul class="p-2 bg-base-100 rounded-t-none">
                                    <?php if (session()->get('isLoggedIn')): ?>
                                        <li class="text-sm md:text-md hover:bg-accent hover:text-base-100 hover:rounded-md">
                                            <a href="<?= base_url("google_logout") ?>">Logout</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="text-sm md:text-md lg:text-lg hover:bg-accent hover:text-base-100 hover:rounded-md">
                                            <a href="<?= base_url("login") ?>">Login</a>
                                        </li>
                                        <li class="text-sm md:text-md lg:text-lg hover:bg-accent hover:text-base-100 hover:rounded-md">
                                            <a href="<?= base_url("signup") ?>">Sign Up</a>
                                        </li>
                                    <?php endif; ?>
                                    
                                </ul>
                            </details>
                        </li>
                    </ul>
                </div>
            <?php elseif (!isset($checkout)): ?>
                <div class="indicator mr-4">
                    <span class="indicator-item badge badge-accent badge-sm md:badge-sm" id="totalQuantity">0</span> 
                    <button onclick="showCart()">
                        <i class="text-2xl fa-solid fa-cart-shopping md:text-3xl"></i>
                    </button>
                </div>
            <?php endif; ?>         
        </div>
    </header>

    <main class="grow shrink-0 basis-auto mb-5 flex items-stretch">
        <section class="grow <?= service('router')->getMatchedRoute()[0] == 'login' ? 'place-content-center' : ''; ?>">
            <?= $this->renderSection('content'); ?>
        </section>
    </main>
    <!-- Code snippet sourced from daisy UI https://daisyui.com/components/footer/ -->
    <footer class="footer footer-center p-4 bg-base-300 text-base-content shrink-0">
        <aside>
            <p>Copyright &copy; <?= date('Y') ?> - All right reserved by <span class="font-header">NomNomNow</span></p>
        </aside>
    </footer>

    <?php include __DIR__ . '/helpers/api_calls.php' ?>

    <script src="https://kit.fontawesome.com/fbc01cbf45.js" crossorigin="anonymous"></script>
    <script>
        const smallScreenSize = window.matchMedia("(max-width: 768px)");
        const stepElements = document.getElementsByClassName("steps");
        const businessId =  "<?= isset($business['id']) ? $business['id'] : null ?>";
        const customer_view = "<?= isset($customer_view) ?  $customer_view : null ?>";

        if (window.innerWidth > 768) {
            /* the viewport is more than 600 pixels wide */
            for (let i = 0; i < stepElements.length; i++) {
                stepElements[i].classList.remove("steps-vertical")
            }
        }

        smallScreenSize.onchange = (e) => {
            if (e.matches) {
                /* the viewport is 600 pixels wide or less */
                for (let i = 0; i < stepElements.length; i++) {
                    stepElements[i].classList.add("steps-vertical")
                }
            } else {
                for (let i = 0; i < stepElements.length; i++) {
                    stepElements[i].classList.remove("steps-vertical")
                }
            }
        };

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