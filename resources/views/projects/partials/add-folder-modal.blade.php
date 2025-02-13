
<div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full"
     id="add-folder-modal">
    <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-none shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-5 border-b rounded-none dark:border-gray-700">
                <h3 class="text-xl font-semibold dark:text-white">
                    Add New Folder
                </h3>
                <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-none text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                        data-modal-toggle="add-folder-modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                        <div class="col-span-6 sm:col-span-12">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Folder Name
                            </label>
                            <input type="text" name="name" id="name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-none focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Add Folder Name" required>
                        </div>
                        <div class="col-span-6 sm:col-span-12">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="user_avatar">
                                {{ __('message.chooseFolderFiles') }}
                            </label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-none cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="upload_directory_help" id="uploadDirectory"
                                type="file"
                                name="files[]" multiple
                            >
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="items-center border-t border-gray-200 rounded-b dark:border-gray-700 mt-8">
                        <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-none text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 mt-8"
                                type="submit">Save Folder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
