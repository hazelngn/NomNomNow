<template id="adminFormTemplate">
    <dialog id="admin_add_modal" class="modal">
        <div class="modal-box md:6/1 md:max-w-xl lg:w-8/12 lg:max-w-3xl">
            <form method="dialog">
                <button id="close_modal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <form id="admin_add_form" method="post" class="flex flex-col p-5 gap-4">
                <h3 class="lg:text-3xl text-center text-accent text-xl">Add a user</h3>
                <div class="flex flex-col gap-2">
                    <label class="font-bold" for="name">Name</label>
                    <input type="text" name="name" id="name" class="p-2 rounded-lg" required>
                </div>
                <div>
                    <label class="font-bold mr-3" for="status">Status</label>

                    <select class="p-2 rounded-lg" name="status" id="status" required>
                        <option value="0">Not Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>

                <div>
                    <label class="font-bold mr-3" for="usertype">User Type</label>

                    <select class="p-2 rounded-lg" name="usertype" id="usertype" required>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <!-- Add some context where this shows and not, using aria-label,.... -->
                <input id="submitBtn" class="btn btn-accent mt-3" type="submit" value="Save">
            </form>
        </div>
    </dialog>
</template>