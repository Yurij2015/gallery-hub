@extends('main')
@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}"
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
                                {{ __('message.projects')}}
                            </a>
                        </li>
                        @if(isset($countOfChildKeysInUrl))
                            <li class="inline-flex items-center">
                                <a href="{{ route('projects.show', $project->id) }}"
                                   class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                    <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('message.project') }} - {{ $project->name }}
                                </a>
                            </li>
                        @else
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                          aria-current="page">{{ __('message.project') }}   - {{ $project->name }} </span>
                                </div>
                            </li>
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center">
                </div>
                <div>
                    <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        {{ __('message.addFolder') }}
                    </button>
                    <button type="button"
                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        {{ __('message.addPhoto') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
            <button type="button"
                    class="py-2 px-3 me-2 mb-9 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    id="goBack">
                {{ __('message.goBack') }}
            </button>

            <span
                class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-3 py-2 rounded dark:bg-blue-900 dark:text-blue-300">
                {{ $project->getObjectsCount() }} file(s)
            </span>
            <span
                class="bg-green-100 text-green-800 text-sm font-medium me-2 px-3 py-2 rounded dark:bg-green-900 dark:text-green-300">
                {{ $project->getSizeOfProjectFolder() }}
            </span>

            <div class="gallery">
                <div class="flex flex-col mb-10">
                    <div class="grid md:grid-cols-12 gap-8 lg:mb-11 mb-7">
                        @if(isset($filteredObjects))
                            @foreach($filteredObjects as $object)
                                <div class="md:col-span-4 md:h-[404px] h-[277px] w-full rounded-3xl">
                                    <img src="{{ $object->objectUrl }}" alt="{{ $object->objectName }}"
                                         class="gallery-image object-cover rounded-3xl hover:grayscale transition-all duration-700 ease-in-out mx-auto lg:col-span-4 md:col-span-6 w-full h-full">
                                    <p class="text-sm text-gray-900 sm:text-sm dark:text-white text-center mt-2">{{ $object->getObjectName() }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="grid md:grid-cols-12 gap-8 lg:mb-11 mb-7 mt-4">
                        @if(isset($childKeys))
                            @foreach($childKeys as $childKey)
                                <a href="{{ $project->id .  '?childKey=' . $childKey}}"
                                   class="md:col-span-2 w-[128px]  h-[128px]">
                                    <img src="{{ asset('images/folder.png') }}" alt=""
                                         class="object-cover rounded-3xl hover:grayscale transition-all duration-700 ease-in-out mx-auto lg:col-span-4 md:col-span-6 w-full h-full">
                                    <p class="text-sm text-gray-900 sm:text-sm dark:text-white text-center">{{ $childKey }}</p>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="lightbox" id="lightbox">
            <span class="close" id="close">&times;</span>
            <img src="" alt="" class="lightbox-image" id="lightbox-image">
        </div>
    </section>
@stop

@section('footer')
    <link rel="stylesheet" href="{{ asset('css/project-show.css') }}">
@endsection

@push('scripts')
    <script src="{{ asset('js/gallery.js') }}"></script>
@endpush
