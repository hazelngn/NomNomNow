<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    <section class="flex flex-col lg:flex-row flex-wrap justify-evenly mt-5 ">
        <div class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12">
            <input type="radio" name="my-accordion-2" checked="checked" /> 
            <div class="collapse-title text-xl font-medium flex flex-row gap-3">
                <i class="inline-block text-accent text-3xl fa-solid fa-book-open"></i>
                <h3 class="text-xl lg:text-3xl">Menus</h3>
            </div>
            <div class="collapse-content bg-neutral"> 
                <ul>
                    <?php if (isset($menus)): ?>
                        <?php foreach ($menus as $menu): ?>
                            <div class="flex flex-row justify-between items-center pt-3">
                                <li><a href="<?= base_url("menu/") . $menu['id'] ?>">
                                    <?= $menu['name'] ?>
                                </a></li>
                                <a href="<?= base_url("menu/addedit/") . $menu['id'] ?>"><i class="text-info text-base lg:text-xl fa-solid fa-pen-to-square"></i></a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <!-- lg:tooltip doesn't work -->
                    <div class="w-full flex justify-center pt-3 tooltip tooltip-accent" data-tip="Add new menu">
                        <a href="<?= base_url("/menu/addedit") ?>">
                            <i class="text-accent text-lg lg:text-2xl fa-solid fa-circle-plus"></i>
                        </a>
                    </div>
                </ul>
            </div>
        </div>
        <div class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12">
            <input type="radio" name="my-accordion-2" /> 
            <div class="collapse-title text-xl font-medium flex flex-row gap-3 w-full">
                <i class="inline-block text-accent text-3xl fa-solid fa-circle-info"></i>
                <h3 class="text-xl lg:text-3xl">Business Information</h3>
            </div>
            <div id="business_info" class="collapse-content  bg-neutral flex flex-col gap-3"> 
                <i onclick="businessFormModal.showModal()" class="text-info text-base lg:text-xl fa-solid fa-pen-to-square text-end mt-3"></i>
                <?php include "templates/business_form.php"; ?>
            </div>
        </div>
        <div class="collapse collapse-arrow bg-base-200 lg:grow-0 lg:basis-5/12">
            <input type="radio" name="my-accordion-2" /> 
            <div class="collapse-title text-xl font-medium flex flex-row gap-3 w-full">
                <i class="inline-block text-accent text-3xl fa-solid fa-qrcode"></i>
                <h3 class="text-xl lg:text-3xl">QR Codes</h3>
            </div>
            <div class="collapse-content bg-neutral"> 
                <ul>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Table 1</li>
                        <i onclick="qr.showModal()" class="cursor-pointer text-info text-base lg:text-xl fa-solid fa-up-right-and-down-left-from-center"></i>
                    </div>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Table 2</li>
                        <i onclick="qr.showModal()" class="cursor-pointer text-info text-base lg:text-xl fa-solid fa-up-right-and-down-left-from-center"></i>
                    </div>
                    <div class="flex flex-row justify-between items-center pt-3">
                        <li>Table 3</li>
                        <i onclick="qr.showModal()" class="cursor-pointer text-info text-base lg:text-xl fa-solid fa-up-right-and-down-left-from-center"></i>
                    </div>
                </ul>
            </div>
        </div>
        <div class="bg-base-200 lg:grow-0 lg:basis-5/12">
            <div class="collapse-title text-xl font-medium flex flex-row gap-3 w-full">
                <i class="inline-block text-accent text-3xl fa-solid fa-gears"></i>
                <a href="<?= base_url('ordersystem') ?>" class="text-xl lg:text-3xl text-info underline underline-offset-4">Order System</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container md:w-4/6 m-auto mt-11 md:text-md">
            <?php if (session()->getFlashdata('success')): ?>
                <div role="alert" class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div role="alert"  class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- You can open the modal using ID.showModal() method -->
    <dialog id="qr" class="modal">
        <div class="modal-box p-10">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3>Table 1</h3>
            <section>
                <?php 
                    /**
                     * GdImage output example
                     *
                     * @created      24.12.2017
                     * @author       Smiley <smiley@chillerlan.net>
                     * @copyright    2017 Smiley
                     * @license      MIT
                     */

                    use chillerlan\QRCode\{QRCode, QROptions};
                    use chillerlan\QRCode\Data\QRMatrix;
                    use chillerlan\QRCode\Output\QRGdImagePNG;

                    // require_once __DIR__.'/../vendor/autoload.php';

                    $options = new QROptions;

                    $options->version             = 7;
                    $options->outputInterface     = QRGdImagePNG::class;
                    $options->scale               = 20;
                    $options->outputBase64        = false;
                    $options->bgColor             = [200, 150, 200];
                    $options->imageTransparent    = true;
                    #$options->transparencyColor   = [233, 233, 233];
                    $options->drawCircularModules = true;
                    $options->drawLightModules    = true;
                    $options->circleRadius        = 0.4;
                    $options->keepAsSquare        = [
                        QRMatrix::M_FINDER_DARK,
                        QRMatrix::M_FINDER_DOT,
                        QRMatrix::M_ALIGNMENT_DARK,
                    ];
                    $options->moduleValues        = [
                        // finder
                        QRMatrix::M_FINDER_DARK    => [0, 63, 255], // dark (true)
                        QRMatrix::M_FINDER_DOT     => [0, 63, 255], // finder dot, dark (true)
                        QRMatrix::M_FINDER         => [233, 233, 233], // light (false), white is the transparency color and is enabled by default
                        // alignment
                        QRMatrix::M_ALIGNMENT_DARK => [255, 0, 255],
                        QRMatrix::M_ALIGNMENT      => [233, 233, 233],
                        // timing
                        QRMatrix::M_TIMING_DARK    => [255, 0, 0],
                        QRMatrix::M_TIMING         => [233, 233, 233],
                        // format
                        QRMatrix::M_FORMAT_DARK    => [67, 159, 84],
                        QRMatrix::M_FORMAT         => [233, 233, 233],
                        // version
                        QRMatrix::M_VERSION_DARK   => [62, 174, 190],
                        QRMatrix::M_VERSION        => [233, 233, 233],
                        // data
                        QRMatrix::M_DATA_DARK      => [0, 0, 0],
                        QRMatrix::M_DATA           => [233, 233, 233],
                        // darkmodule
                        QRMatrix::M_DARKMODULE     => [0, 0, 0],
                        // separator
                        QRMatrix::M_SEPARATOR      => [233, 233, 233],
                        // quietzone
                        QRMatrix::M_QUIETZONE      => [233, 233, 233],
                        // logo (requires a call to QRMatrix::setLogoSpace()), see QRImageWithLogo
                        QRMatrix::M_LOGO           => [233, 233, 233],
                    ];

                    $data = base_url('onlineorder/31');

                    $out = (new QRCode($options))->render($data);

                    header('Content-type: image/png');

                    echo $out;


                ?>
            </section>
        </div>
    </dialog>

    
    <script>
        const businessInfo = document.querySelector("#business_info")
        const businessFormTemplate = document.querySelector("#business_form");
        const businessForm = businessFormTemplate.cloneNode(true);
        businessForm.id = "businessForEdit";
        

        function renderModal() {
            const dialog = document.createElement("dialog");
            dialog.classList.add("modal");
            dialog.id = "businessFormModal";

            const formHeader = businessForm.querySelector("h4");
            formHeader.className = "text-center font-sub-header text-accent text-xl md:text-2xl";
            formHeader.innerText = "Edit your business information";

            const modalContainer = document.createElement("div");
            modalContainer.className = "modal-box md:6/1 md:max-w-xl lg:w-8/12 lg:max-w-3xl p-7";

            const saveBtn = document.createElement("input");
            saveBtn.id = "saveBtn";
            saveBtn.classList.add("btn", "btn-accent");
            saveBtn.type = "submit";
            saveBtn.value = "Save"
            saveBtn.addEventListener("click", (e) => editForm(e))
            // <input id="submitBtn" class="btn btn-accent" type="submit" value="Save">
            businessForm.append(saveBtn);

            const closeModalForm = document.querySelector("#close_modal_form").content.cloneNode(true).children[0];
            modalContainer.appendChild(closeModalForm);
            modalContainer.appendChild(businessForm);
            

            const formInputs = modalContainer.querySelectorAll("input");
            const formTextarea = modalContainer.querySelector("textarea");
            formInputs.forEach(input => input.removeAttribute("disabled"))
            formTextarea.removeAttribute("disabled");

            dialog.appendChild(modalContainer);
            businessInfo.appendChild(dialog);
        }

        async function editForm(e) {
            e.preventDefault();
            const businessFormModal = document.querySelector("#businessFormModal");

            if (businessForm.reportValidity()) {
                const formData = new FormData(businessForm);
                const data = Object.fromEntries(formData.entries());
                const file = businessFormModal.querySelector("#logo").files[0];

                if (file) {
                    const uploadFile = new FormData();
                    uploadFile.append('file', file)

                    await fetch("<?= base_url('upload/') ?>", {
                        method: "POST",
                        body: uploadFile
                    })
                    .then(res => res.json())
                    .then(json => data['logo'] = json['data'])
                } else {
                    delete data['logo']
                }

                const result = await update("businesses", data)
                console.log(result);

                businessFormModal.close();
                // client side rendering not implemented
                location.reload();
            };
        }
            
        renderModal();
        

    </script>
<?= $this->endSection() ?>