<template id="adminFormTemplate">
    <dialog id="admin_modal" class="modal" aria-labelledby="adminModalTitle" aria-describedby="adminModalContent">
        <div class="modal-box md:6/1 md:max-w-xl lg:w-8/12 lg:max-w-3xl">
            <form method="dialog">
                <button id="close_modal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">&#10005;</button>
            </form>
            <form id="admin_form" method="post" class="flex flex-col p-5 gap-4" aria-label="Admin Form">
                <h3 id="adminModalTitle" class="lg:text-3xl text-center text-accent text-xl"><span></span> a user</h3>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="name">Name</label>
                    <input type="text" name="name" id="name" class="p-2 rounded-lg" required aria-required="true" aria-label="Name">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="businessName">Business name</label>
                    <input type="text" name="businessName" id="businessName" class="p-2 rounded-lg" required aria-required="true" aria-label="Business Name">
                </div>
                <div>
                    <label class="font-bold mr-3" for="usertype">User Type</label>
                    <select class="p-2 rounded-lg" name="usertype" id="usertype" required aria-required="true" aria-label="User Type">
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <input id="submitBtn" class="btn btn-accent mt-3" type="submit" value="Save" aria-label="Save Button">
            </form>
        </div>
    </dialog>
</template>