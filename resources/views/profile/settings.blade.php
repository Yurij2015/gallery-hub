@extends('main')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('projects.index') }}"
                               class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                {{ __('message.home')}}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                      aria-current="page">{{ __('message.userSettings') }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-800 sm:text-2xl dark:text-white">{{ __('message.userSettings') }}</h1>
            </div>
        </div>
    </div>

    <section class="bg-white dark:bg-gray-800">
    <div
        class="py-8 px-4 mx-auto max-w-2xl lg:py-16 ">
        <div class="flex items-start justify-between dark:border-gray-700 mb-3">
            <h3 class="text-xl font-semibold dark:text-white">
                {{ __('message.editUser') }} - {{ $user->email }}
            </h3>
        </div>
        <form action="{{ route('update-user-settings') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="name"
                           class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('message.name') }}:
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           value="{{ $user->name }}"
                           required
                    >
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="user"
                           class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('message.email') }}:
                    </label>
                    <input type="text"
                           name="email"
                           id="email"
                           class="bg-gray-100 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           disabled
                           readonly
                           required
                           value="{{ $user->email }}"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="address"
                           class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('message.address') }}
                    </label>
                    <input type="text"
                           name="address"
                           id="address"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           required
                           value="{{ $user->userDetail?->address }}"
                    >
                    <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="city"
                           class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('message.city') }}
                    </label>
                    <input type="text"
                           name="city"
                           id="city"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           required
                           value="{{ $user->userDetail?->city }}"
                    >
                    <x-input-error :messages="$errors->get('city')" class="mt-2"/>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="state"
                           class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('message.state') }}
                    </label>
                    <input type="text"
                           name="state"
                           id="state"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           required
                           value="{{ $user->userDetail?->state }}"
                    >
                    <x-input-error :messages="$errors->get('state')" class="mt-2"/>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="zip"
                           class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('message.zip') }}
                    </label>
                    <input type="text"
                           name="zip"
                           id="zip"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-800 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           required
                           value="{{ $user->userDetail?->zip }}"
                    >
                    <x-input-error :messages="$errors->get('zip')" class="mt-2"/>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="phone"
                           class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('message.phoneNumber') }}:
                    </label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                 viewBox="0 0 19 18">
                                <path
                                    d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z"/>
                            </svg>
                        </div>
                        <input type="text"
                               id="phone"
                               aria-describedby="helper-text-explanation"
                               name="phone"
                               class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               pattern="\+[0-9]{3}-[0-9]{3}-[0-9]{4,5,6}"
                               placeholder="+123-456-7890"
                               value="{{ $user->userDetail?->phone }}"
                               required
                        />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="dob"
                           class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('message.dob') }}
                    </label>
                    <div class="relative max-w-sm">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
                                />
                            </svg>
                        </div>
                        <input datepicker
                               id="dob-datepicker-{{$user->id}}"
                               type="text"
                               name="dob"
                               class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Select date of birth"
                               value="{{ Carbon::parse($user->userDetail?->dob )->format('d/m/Y') }}"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('dob')" class="mt-2"/>
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-white"
                           for="instagramUrl">
                        {{ __('message.instagramUrl') }}
                    </label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                      d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="text"
                               id="instagramUrl"
                               aria-describedby="instagram_url_help"
                               name="instagram_url"
                               class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Type your instagram link"
                               value="{{ $user->userDetail?->instagram_url }}"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6">
                    <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-white"
                           for="userAvatar">
                        {{ __('message.uploadAvatar') }}
                    </label>
                    <input
                        class="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="upload_avatar_help" id="userAvatar" type="file" name="file"
                    >
                </div>
            </div>
            <div class="items-center border-t border-gray-200 rounded-b dark:border-gray-700 mt-8">
                <button
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 mt-8"
                    type="submit">
                    {{ __('message.updateSettings') }}
                </button>
            </div>
        </form>
    </div>

@endsection
