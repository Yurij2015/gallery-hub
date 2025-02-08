@php
    use Carbon\Carbon;
@endphp
@extends('main')
@section('content')
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
                        <li class="inline-flex items-center">
                            <a href="{{ route('projects.index') }}"
                               class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                {{ __('message.projects') }}
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
                                      aria-current="page">{{ __('message.editProject') }} - {{ $project->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ __('message.editProject') }}
                    - {{ $project->name }}</h1>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <section class="bg-white dark:bg-gray-900">
                        <div class="py-8 px-4 mx-auto max-w-6xl lg:py-8 mt-8">
                            <div class="sm:col-span-2">
                                <div
                                    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                                    <form action="{{ route('projects.update', $project->id) }}" method="POST"
                                          enctype="multipart/form-data">
                                        @method('put')
                                        @csrf
                                        <div class="grid grid-cols-4 gap-4">
                                            <div class="col-span-6 sm:col-span-2">
                                                <label for="name"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('message.projectName') }}</label>
                                                <input type="text" name="name" id="name"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                       value="{{ $project->name }}" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-2">
                                                <label for="date-datepicker"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('message.eventDate') }}</label>
                                                <div class="relative max-w-full">
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                             aria-hidden="true"
                                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                             viewBox="0 0 20 20">
                                                            <path
                                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                        </svg>
                                                    </div>
                                                    <input datepicker id="date-datepicker" type="text" name="date"
                                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                           value="{{ Carbon::parse($project->date)->format('d/m/Y') }}">
                                                </div>
                                            </div>
                                            <div class="col-span-6 sm:col-span-2">
                                                <label for="expiration-date-datepicker"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ __('message.expirationDate') }}
                                                </label>
                                                <div class="relative max-w-full">
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                             aria-hidden="true"
                                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                             viewBox="0 0 20 20">
                                                            <path
                                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                        </svg>
                                                    </div>
                                                    <input datepicker id="expiration-date-datepicker" type="text"
                                                           name="expiration_date"
                                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                           value="{{ Carbon::parse($project->expiration_date)->format('d/m/Y') }}">
                                                </div>
                                            </div>
                                            <div class="col-span-6 sm:col-span-2">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                    for="user_avatar">
                                                    {{ __('message.chooseNewFiles') }}
                                                </label>
                                                <input
                                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                    aria-describedby="upload_directory_help" id="uploadDirectory"
                                                    type="file"
                                                    name="files[]" multiple
                                                >
                                            </div>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit"
                                                    class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800 float-end">
                                                {{ __('message.editProject') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="bg-white dark:bg-gray-900">
                        <div class="gallery">
                            <div class="flex flex-col mb-10">
                                <div class="grid md:grid-cols-12 gap-8 lg:mb-11 mb-7">
                                    @if(isset($projectObjects))
                                        @foreach($projectObjects as $object)
                                            <div
                                                class="md:col-span-4 md:h-[404px] h-[277px] w-full rounded-3xl relative group">
                                                <!-- Image -->
                                                <img src="{{ $object->objectUrl }}" alt="{{ $object->objectName }}"
                                                     class="gallery-image object-cover rounded-none hover:grayscale transition-all duration-700 ease-in-out mx-auto lg:col-span-4 md:col-span-6 w-full h-full">
                                                <!-- Hover Menu -->
                                                <div
                                                    class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/1 flex items-center bg-white py-2 px-2 rounded-none shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 h-auto min-h-[50px]">
                                                    <!-- Favorite Button -->
                                                    <button
                                                        class="bg-yellow-500 text-white rounded-full p-2 set-cover-button"
                                                        data-image-key="{{ $object->key }}">
                                                        <svg class="w-4 h-4 text-gray-800 dark:text-white"
                                                             aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                             width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-width="2"
                                                                  d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z"/>
                                                        </svg>
                                                    </button>
                                                    <!-- Separator -->
                                                    <div class="h-6 w-[1px] bg-gray-300 mx-2"></div>
                                                    <!-- Expand Button -->
                                                    <button
                                                        class="bg-blue-500 text-white rounded-full p-2 expand-button"
                                                        data-image-url="{{ $object->objectUrl }}">
                                                        <svg class="w-4 h-4 text-gray-800 dark:text-white"
                                                             aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                             width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path d="M4 10V4h6M4 14v6h6M20 10V4h-6M20 14v6h-6"
                                                                  stroke="currentColor" stroke-width="2"
                                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </button>
                                                    <!-- Separator -->
                                                    <div class="h-6 w-[1px] bg-gray-300 mx-2"></div>
                                                    <!-- Delete Button -->
                                                    <button class="bg-red-500 text-white rounded-full p-2 delete-button"
                                                            data-image-key="{{ $object->key }}">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                  clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <!-- Image Caption -->
                                                <p class="text-sm text-gray-900 sm:text-sm dark:text-white text-center mt-2">
                                                    {{ $object->objectName }}
                                                </p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="lightbox" id="lightbox">
                            <span class="close" id="close">&times;</span>
                            <img src="" alt="" class="lightbox-image" id="lightbox-image">
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <style>
        .delete-button {
            transition: opacity 0.3s ease;
            opacity: 0.7;
        }

        .delete-button:hover {
            opacity: 1;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
@endsection
@push('scripts')
    <script>
        let projectId = JSON.parse(`{{ $project->id }}`);

        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');
            const expandButtons = document.querySelectorAll('.expand-button');
            const setCoverButtons = document.querySelectorAll('.set-cover-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const imageKey = button.getAttribute('data-image-key');
                    if (confirm('Are you sure you want to delete this image?' + imageKey)) {
                        fetch(`/project/remove-object/${projectId}?imageKey=${imageKey}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                            .then(response => {
                                if (response.ok) {
                                    alert('Image deleted successfully');
                                    location.reload();
                                } else {
                                    alert('Failed to delete image');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Failed to delete image');
                            });
                    }
                });
            });

            expandButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const imageToExpand = button.closest('.gallery').querySelector('.gallery-image');
                    const imageSrc = button.getAttribute('data-image-url');

                    if (imageToExpand) {
                        lightboxImage.src = imageSrc;
                        lightbox.style.display = 'flex';
                    }
                });
            });

            setCoverButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const imageKey = button.getAttribute('data-image-key');
                    fetch(`/project/set-cover-image/${projectId}?imageKey=${imageKey}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('Cover image set successfully');
                            } else {
                                alert('Failed to set cover image');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to set cover image');
                        });
                });
            });
        });


    </script>
    <script src="{{ asset('js/gallery.js') }}"></script>
@endpush
