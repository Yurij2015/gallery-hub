@php
    use Carbon\Carbon;
@endphp
@extends('main')
@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full">
            <nav class="flex" aria-label="Breadcrumb">
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
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            @include('projects.partials.project-manage-menu')
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <section class="bg-white dark:bg-gray-900">
                        <div class="gallery">
                            <div class="flex flex-col mb-2 md:px-10 px-5">
                                <div class="grid grid-cols-12 gap-4">
                                    <div
                                        class="col-span-12 md:col-span-4 flex items-center justify-start  space-x-6 mt-3 sm:mt-0">
                                        <button
                                            data-modal-target="add-folder-modal"
                                            data-modal-toggle="add-folder-modal"
                                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-yellow-500 rounded-none focus:ring-4 focus:ring-yellow-400 dark:focus:ring-yellow-500 hover:bg-yellow-400 {{ request()->get('folderSlug') ? 'cursor-not-allowed' : '' }}"
                                            {{ request()->get('folderSlug') ? 'disabled' : '' }}
                                        >
                                            <svg class="w-4 h-4 me-2 text-gray-800 dark:text-white" aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                 viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="M13.5 8H4m0-2v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z"/>
                                            </svg>
                                            {{ __('message.addFolder') }}
                                        </button>
                                        <div class="flex items-center space-x-4 mt-0">
                                            @if(isset($projectFoldersWithFolderName))
                                                @foreach($projectFoldersWithFolderName as $folder)
                                                    <div class="relative group flex flex-col items-center folder-icon"
                                                         data-folder-key="{{ $folder['folderKey'] }}"
                                                         data-folder-slug="{{ $folder['folderSlug'] }}"
                                                    >
                                                        <svg
                                                            class="w-10 h-10 text-gray-800 dark:text-white cursor-pointer"
                                                            aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                  d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                                                  clip-rule="evenodd"/>
                                                        </svg>
                                                        <div
                                                            class="absolute top-full mt-2 px-4 py-2 min-w-[150px] text-center max-w-xs text-sm font-medium text-white bg-gray-900 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 dark:bg-gray-800 z-50">
                                                            {{ $folder['folderName'] }}
                                                            <div
                                                                class="absolute left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-900 rotate-45 top-[-5px] dark:bg-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-span-12 md:col-span-8 flex items-center">
                                        <form
                                            method="POST"
                                            action="{{ route('projects.upload-images', ['project' => $project->id, 'folderSlug' => request()->get('folderSlug')]) }}"
                                            class=" w-full"
                                            enctype="multipart/form-data"
                                            id="dropUploadForm">
                                            @method('put')
                                            @csrf
                                            <div id="dropzone-container"
                                                 class="flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-none cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2"
                                                              d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                            class="font-semibold">
                                                            {{ __('message.dragAndDrop') }}
                                                        </span> {{ __('message.toUpload') }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ __('message.imagesAndVideos') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                        {{-- TODO remove this and js for this --}}
                                        <form id="uploadForm" hidden="hidden"
                                              method="POST" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <!-- Hidden File Input -->
                                            <input type="file" id="fileInput" name="files[]" multiple class="hidden">

                                            <!-- Upload Button -->
                                            <button
                                                type="button"
                                                id="uploadButton"
                                                class="inline-flex items-center px-5 py-2.5 sm:mt-6 text-sm font-medium text-white bg-primary-700 rounded-none focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800"
                                            >
                                                <svg
                                                    class="w-4 h-4 me-2 text-gray-100 group-hover:text-gray-100 dark:text-gray-100 dark:group-hover:text-gray-300"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                          stroke-linejoin="round" stroke-width="2"
                                                          d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/>
                                                </svg>
                                                {{ __('message.upload') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <hr class="mb-5 border border-gray-200 dark:border-gray-700">
                                <div class="grid md:grid-cols-12 gap-12 lg:mb-11 mb-7 md:px-5">
                                    @if(isset($projectFiles))
                                        @foreach($projectFiles as $object)
                                            @php
                                                $extension = pathinfo(parse_url($object->objectUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                                $videoExtensions = ['mp4', 'mov', 'avi', 'webm'];
                                            @endphp
                                            <div
                                                class="md:col-span-2 md:h-[222px] h-[190px] w-full rounded-3xl relative group">
                                                @if (in_array(strtolower($extension), $imageExtensions))
                                                    <img src="{{ $object->objectUrl }}" alt="{{ $object->objectName }}"
                                                         class="gallery-image object-cover rounded-none hover:grayscale transition-all duration-700 ease-in-out mx-auto lg:col-span-4 md:col-span-6 w-full h-full">
                                                @elseif (in_array(strtolower($extension), $videoExtensions))
                                                    <video controls
                                                           class="object-cover rounded-none hover:grayscale transition-all duration-700 ease-in-out mx-auto lg:col-span-4 md:col-span-6 w-full h-full">
                                                        <source src="{{ $object->objectUrl }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                                <!-- Hover Menu -->
                                                <div
                                                    class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/1 flex items-center bg-white py-1 px-2 rounded-none shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 h-auto min-h-[25px]">
                                                    @if (in_array(strtolower($extension), $imageExtensions))
                                                        <!-- Favorite Button -->
                                                        <button
                                                            class="bg-yellow-500 text-white rounded-full p-1 set-cover-button"
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
                                                            class="bg-blue-500 text-white rounded-full p-1 expand-button"
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
                                                    @endif
                                                    <!-- Delete Button -->
                                                    <button class="bg-red-500 text-white rounded-full p-1 delete-button"
                                                            data-image-key="{{ $object->key }}">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                  clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                @if($object->downloadsCount)
                                                    <div class="downloads-count-block">
                                                        <div class="flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-gray-400"
                                                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                                 viewBox="0 0 24 24">
                                                                <path d="M12 16l4-5h-3V4h-2v7H8l4 5zm-6 2v2h12v-2H6z"/>
                                                            </svg>
                                                            <span
                                                                class="text-xs text-gray-400">{{ $object->downloadsCount }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                <!-- Image Caption -->
                                                <p class="text-sm text-gray-800 sm:text-sm dark:text-white text-center mt-2">
                                                    <span class="stringDisplay"
                                                          data-full-string="{{ $object->objectName }}"></span>
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
    @include('projects.partials.add-folder-modal')
    <!-- Loader -->
    <div id="loader"
         class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="flex flex-col items-center">
            <button disabled type="button"
                    class="py-3 px-6 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center">
                <svg aria-hidden="true" role="status"
                     class="inline w-6 h-6 mr-3 text-gray-200 animate-spin dark:text-gray-600"
                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor"/>
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="#1C64F2"/>
                </svg>
                Uploading...
            </button>
            {{--            <div class="w-64 bg-gray-200 rounded-full dark:bg-gray-700 mt-4">--}}
            {{--                <div id="progressContainer"></div>--}}
            {{--            </div>--}}
            <div class="w-64 bg-gray-200 rounded-full dark:bg-gray-700 mt-4">
                <div id="progressBar"
                     class="bg-blue-500 text-xs font-medium text-white text-center p-0.5 leading-none rounded-full"
                     style="width: 0%">0%
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

        .expand-button {
            transition: opacity 0.3s ease;
            opacity: 0.7;
        }

        .expand-button:hover {
            opacity: 1;
        }

        .set-cover-button {
            transition: opacity 0.3s ease;
            opacity: 0.7;
        }

        .set-cover-button:hover {
            opacity: 1;
        }

        .downloads-count-block {
            position: absolute;
            top: 100%;
            right: 0;
            transform: translate(100%, -100%);
            width: 25px;
            height: 25px;
        }

        .stringDisplay::after {
            content: attr(data-full-string);
            display: inline-block;
            width: 15ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            direction: rtl;
        }

        @media (max-width: 640px) {
            .downloads-count-block {
                transform: none;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/project-edit.css') }}">
@endsection
@push('scripts')
    <script>
        let projectId = JSON.parse(`{{ $project->id }}`);

        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');
            const expandButtons = document.querySelectorAll('.expand-button');
            const setCoverButtons = document.querySelectorAll('.set-cover-button');
            const folderIcons = document.querySelectorAll('.folder-icon');

            folderIcons.forEach(folderIcon => {
                folderIcon.addEventListener('click', function () {
                    const folderKey = folderIcon.getAttribute('data-folder-key');
                    const folderSlug = folderIcon.getAttribute('data-folder-slug');
                    console.log(folderKey);
                    console.log(folderSlug);
                    window.location.href = `/projects/edit/${projectId}?folderSlug=${folderSlug}`;
                });
            });

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

        // Trigger file input when button is clicked
        document.getElementById('uploadButton').addEventListener('click', function () {
            document.getElementById('fileInput').click();
        });

        document.getElementById('fileInput').addEventListener('change', function () {
            if (this.files.length > 0) {
                let formData = new FormData(document.getElementById("uploadForm"));
                let loader = document.getElementById("loader");
                let progressBar = document.getElementById("progressBar");

                loader.classList.remove("hidden"); // Show loader

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('projects.upload-images', ['project' => $project->id, 'folderSlug' => request()->get('folderSlug')]) }}", true);
                xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));


                // Update progress bar
                xhr.upload.onprogress = function (event) {
                    if (event.lengthComputable) {
                        let percent = Math.round((event.loaded / event.total) * 100);
                        progressBar.style.width = percent + "%";
                        progressBar.textContent = percent + "%";
                    }
                };

                // When upload is complete
                xhr.onload = function () {
                    loader.classList.add("hidden"); // Hide loader
                    if (xhr.status === 200) {
                        Swal.fire("Success!", "File(s) uploaded successfully!", "success").then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire("Error!", "File upload failed!", "error");
                    }
                };

                xhr.onerror = function () {
                    loader.classList.add("hidden"); // Hide loader
                    Swal.fire("Error!", "Something went wrong!", "error");
                };

                xhr.send(formData);
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const dropzoneContainer = document.querySelector("#dropzone-container");
            const dropzoneElement = document.querySelector("#dropUploadForm");
            let loader = document.getElementById("loader");
            let progressBar = document.getElementById("progressBar");

            if (dropzoneElement) {
                new Dropzone(dropzoneElement, {
                    paramName: "files",
                    maxFilesize: 300,
                    acceptedFiles: "image/*,video/*",
                    uploadMultiple: true,
                    parallelUploads: 10,
                    addRemoveLinks: true,
                    autoProcessQueue: true,
                    previewsContainer: false,
                    clickable: dropzoneContainer,

                    init: function () {
                        this.on("sending", function (file, xhr) {
                            loader.classList.remove("hidden");
                            progressBar.style.width = "0%";

                            xhr.upload.onprogress = function (event) {
                                if (event.lengthComputable) {
                                    let percent = Math.round((event.loaded / event.total) * 100);
                                    progressBar.style.width = percent + "%";
                                    progressBar.textContent = percent + "%";
                                }
                            };
                        });

                        this.on("queuecomplete", function () {
                            loader.classList.add("hidden");
                            Swal.fire("Success!", "File(s) uploaded successfully!", "success").then(() => {
                                window.location.reload();
                            });
                        });

                        this.on("error", function (file, response) {
                            loader.classList.add("hidden");
                            Swal.fire("Error!", "Upload failed: " + response, "error");
                        });
                    },

                    error: function (file, response) {
                        alert("Upload failed: " + response);
                    },
                });
            }
        });

    </script>
    <script src="{{ asset('js/gallery.js') }}"></script>
@endpush
