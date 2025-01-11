@php
    $statuses = ['Active', 'In Progress', 'Completed', 'On Hold', 'Cancelled'];
@endphp
<div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full"
     id="add-project-modal">
    <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                <h3 class="text-xl font-semibold dark:text-white">
                    Add new project
                </h3>
                <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                        data-modal-toggle="add-project-modal">
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
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Name
                            </label>
                            <input type="text" name="name" id="name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Add Project Name" required>
                        </div>
{{--                        <div class="col-span-6 sm:col-span-3">--}}
{{--                            <label for="site" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">--}}
{{--                                Site--}}
{{--                            </label>--}}
{{--                            <select id="site" name="site_id"--}}
{{--                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">--}}
{{--                                @foreach($sites as $site)--}}
{{--                                    <option value="{{ $site->id }}" {{ old('site') === $site->id ? 'selected' : ''}}>--}}
{{--                                        {{ $site->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="col-span-6 sm:col-span-3">
                            <label for="user"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User</label>
                            <input type="text" name="user" id="user"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 cursor-not-allowed"
                                   placeholder="Add Username" required value="{{ auth()->user()->name }}" disabled>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
{{--                            <select id="status" name="status"--}}
{{--                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">--}}
{{--                                @foreach($statuses as $status)--}}
{{--                                    <option value="{{ $status }}" {{ old('status') === $status ? 'selected' : ''}}>--}}
{{--                                        {{ $status }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
                        </div>
{{--                        <div class="col-span-6 sm:col-span-3">--}}
{{--                            <label for="started-at-datepicke"--}}
{{--                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">--}}
{{--                                Started Ad--}}
{{--                            </label>--}}
{{--                            <div class="relative max-w-sm">--}}
{{--                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">--}}
{{--                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"--}}
{{--                                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <input datepicker id="started-at-datepicker" type="text" name="started_at"--}}
{{--                                       autocomplete="off"--}}
{{--                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 pl-10"--}}
{{--                                       placeholder="Add Started Time" required>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-span-6 sm:col-span-3">--}}
{{--                            <label for="ended-at-datepicke"--}}
{{--                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">--}}
{{--                                Ended At--}}
{{--                            </label>--}}
{{--                            <div class="relative max-w-sm">--}}
{{--                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">--}}
{{--                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"--}}
{{--                                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <input datepicker id="ended-at-datepicke" type="text" name="ended_at" autocomplete="off"--}}
{{--                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 pl-10"--}}
{{--                                       placeholder="Add Ended Time" required>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-span-6">
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea id="description" rows="4" name="description"
                                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                      placeholder="Project Description."></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="items-center border-t border-gray-200 rounded-b dark:border-gray-700 mt-8">
                        <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 mt-8"
                                type="submit">Add project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
