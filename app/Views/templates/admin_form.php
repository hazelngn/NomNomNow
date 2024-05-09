<template id="adminFormTemplate">
    <dialog id="admin_modal" class="modal">
        <div class="modal-box md:6/1 md:max-w-xl lg:w-8/12 lg:max-w-3xl">
            <form method="dialog">
                <button id="close_modal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <form id="admin_form" class="flex flex-col p-5 gap-4">
                <h3 class="lg:text-3xl text-center text-accent text-xl"><span></span> a user</h3>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="username">Name</label>
                    <input type="text" name="username" id="username" class="p-2 rounded-lg" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="businessName">Business name</label>
                    <input type="text" name="businessName" id="businessName" class="p-2 rounded-lg" required>
                </div>
                <div>
                    <label class="font-bold" for="status">Status</label>

                    <select class="p-2 rounded-lg" name="status" id="status" required>
                        <option value="0">Not Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
                <!-- Add some context where this shows and not, using aria-label,.... -->
                <input id="submitBtn" class="btn btn-accent" type="submit" value="Save">
                <input type="hidden" id="id" name="id">
            </form>
        </div>
    </dialog>
</template>