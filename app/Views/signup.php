<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
    <!-- <h1 class="text-center text-3xl md:text-4xl font-bold text-accent font-sub-header mt-11 ">Set up your business account</h1> -->
    <section class="p-3 md:w-1/2 m-auto">
        <?php include "templates/business_form.php" ?>
    </section>

    <?php include "helpers/api_calls.php" ?>
    <script>
        const businessInfo = document.querySelector("#business_info")
        const businessForm = document.querySelector("#business_form");
        businessForm.id = "business_signup";

        // header
        const formHeader = businessForm.querySelector("h4");
        formHeader.className = "text-center font-sub-header text-accent text-2xl md:text-4xl mt-5 md:mt-11 mb-3 md:mb-5";
        formHeader.innerText = "Register your business";

        const saveBtn = document.createElement("input");
        saveBtn.id = "saveBtn";
        saveBtn.classList.add("btn", "btn-accent");
        saveBtn.type = "submit";
        saveBtn.value = "Save"
        saveBtn.addEventListener("click", (e) => submitForm(e))
        businessForm.append(saveBtn);

        async function submitForm(e) {
            e.preventDefault();
            if (businessForm.reportValidity()) {
                const formData = new FormData(businessForm);
                const data = Object.fromEntries(formData.entries());
                const file = businessForm.querySelector("#logo").files[0];

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

                const result = await add("businesses", data)
                
                // update business_id in users table
                const user = await get("users", <?= session()->get("userId") ?>);
                const updatedUserData = {
                    ...user,
                    business_id: result.id
                }
                await update('users', updatedUserData)

                console.log(updatedUserData);

                // client side rendering not implemented
                location.replace("<?= base_url('/') ?>");
            };
        }
            
    </script>
<?= $this->endSection(); ?>