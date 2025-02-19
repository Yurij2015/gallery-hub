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
                                <div class="grid grid-cols-12 gap-4 mb-3">
                                    <div
                                        class="col-span-12 md:col-span-4 flex items-center justify-start  space-x-6 mt-3 sm:mt-0">
                                        <div class="flex items-center space-x-4 mt-0 sm:mt-6 md:mt-6 xl:mt-6">
                                            @if(isset($clientNames))
                                                @foreach($clientNames as $clientName)
                                                    <div class="relative group flex flex-col items-center folder-icon"
                                                         data-folder-client="{{ $clientName }}"
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
                                                            {{ $clientName }}
                                                            <div
                                                                class="absolute left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-900 rotate-45 top-[-5px] dark:bg-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="ms-3 text-sm font-medium mt-1">
                                                <div class="flex items-center space-x-2">
                                                    <span
                                                        class="text-gray-700 dark:text-gray-300"> {{ __('message.favorites') }} </span>
                                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                    @if(request()->has('folderSlug'))
                                                        <span
                                                            class="text-gray-700 dark:text-gray-300">{{ request()->get('folderSlug') }}</span>
                                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                    @endif
                                                    <span
                                                        class="text-gray-500 dark:text-gray-400 text-sm">{{ $project->userReactions->count() }} {{ __('message.files') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-5 border border-gray-200 dark:border-gray-700">
                                <div class="grid md:grid-cols-12 gap-12 lg:mb-11 mb-7 md:px-5">
                                    @if(isset($project->userReactions))
                                        @foreach($project->userReactions as $object)
                                            @php
                                                $extension = pathinfo(parse_url($object->object_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                                $videoExtensions = ['mp4', 'mov', 'avi', 'webm'];
                                            @endphp
                                            <div
                                                class="md:col-span-2 md:h-[222px] h-[190px] w-full rounded-3xl relative group">
                                                @if (in_array(strtolower($extension), $imageExtensions))
                                                    <img src="{{ $object->object_url }}" alt="{{ $object->object_key }}"
                                                         class="gallery-image object-cover rounded-none hover:grayscale transition-all duration-700 ease-in-out mx-auto lg:col-span-4 md:col-span-6 w-full h-full">
                                                @elseif (in_array(strtolower($extension), $videoExtensions))
                                                    <video controls
                                                           class="object-cover rounded-none hover:grayscale transition-all duration-700 ease-in-out mx-auto lg:col-span-4 md:col-span-6 w-full h-full">
                                                        <source src="{{ $object->objectUrl }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                                <!-- Image Caption -->
                                                <p class="text-sm text-gray-800 sm:text-sm dark:text-white text-center mt-2">
                                                    <span class="stringDisplay"
                                                          data-full-string="{{ $object->object_key }}"></span>
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
        .stringDisplay::after {
            content: attr(data-full-string);
            display: inline-block;
            width: 15ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            direction: rtl;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/project-edit.css') }}">
@endsection
@push('scripts')
    <script>
        let projectId = JSON.parse(`{{ $project->id }}`);

        document.addEventListener('DOMContentLoaded', function () {
            const folderIcons = document.querySelectorAll('.folder-icon');
            folderIcons.forEach(folderIcon => {
                folderIcon.addEventListener('click', function () {
                    const clientName = folderIcon.getAttribute('data-folder-client');
                    window.location.href = `/projects/favorites/${projectId}?folderSlug=${clientName}`;
                });
            });
        });
    </script>
    <script src="{{ asset('js/gallery.js') }}"></script>
@endpush
