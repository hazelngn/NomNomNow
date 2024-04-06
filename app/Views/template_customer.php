<!DOCTYPE html>
<html lang="en" data-theme="sunset">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $business['name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.9.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Lilita+One&family=Righteous&family=Rubik+Bubbles&display=swap" rel="stylesheet">
</head>
<body class="font-body min-h-screen w-full bg-base-200 flex flex-col text-sm lg:text-lg">
    <header class="sticky top-0 z-10" >
        <!-- Code snippets from daisy UI https://daisyui.com/components/navbar/ -->
        <div class="navbar bg-base-100">
            <div class="flex-1">
                <a class="btn btn-ghost text-3xl font-header" href="<?= base_url("onlineorder/1") ?>"><?= $business['name'] ?></a>
            </div>
            <div class="indicator mr-4">
                <span class="indicator-item badge badge-accent badge-sm">0</span> 
                <button onclick="cart.showModal()">
                    <i class="text-2xl fa-solid fa-cart-shopping"></i>
                </button>
            </div>
            
        </div>
    </header>

    <main class="grow shrink-0 basis-auto mb-5">
        <?= $this->renderSection('content'); ?>
    </main>

    <!-- Code snippet sourced from daisy UI https://daisyui.com/components/footer/ -->
    <footer class="footer footer-center p-4 bg-base-300 text-base-content shrink-0">
        <aside>
            <p>Copyright &copy; <?= date('Y') ?> - All right reserved by <span class="font-header">NomNomNow</span></p>
        </aside>
    </footer>

    <script src="https://kit.fontawesome.com/fbc01cbf45.js" crossorigin="anonymous"></script>
    <script>
        const smallScreenSize = window.matchMedia("(max-width: 768px)");
        const stepElements = document.getElementsByClassName("steps");

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
    </script>
    <script>
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
    </script>
</body>
</html>