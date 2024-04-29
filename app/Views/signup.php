<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <!-- <h1 class="text-center text-3xl md:text-4xl font-bold text-accent font-sub-header mt-11 ">Set up your business account</h1> -->
    <section class="p-3 md:w-1/2 m-auto">
        <?php include "templates/business_form.php" ?>
    </section>

    <?php include "helpers/api_calls.php" ?>
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
<?= $this->endSection(); ?>