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
                        <div class="py-8 px-4 mx-auto max-w-8xl lg:py-8">
                            <div class="sm:col-span-2">
                                <div class="grid gap-4 px-2 mb-4 md:grid-cols-2 xl:grid-cols-4">
                                    <div
                                        class="space-y-6 bg-white border border-gray-200 rounded-none shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                                        <div
                                            class="text-gray-400  rounded dark:border-gray-600">
                                            <img src="{{ $project->projectImage }}" alt="{{ $project->name }}"
                                                 class="w-full h-48 object-cover mt-2 rounded-lg">
                                        </div>
                                        <div
                                            class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Cover</h3>
                                        </div>
                                        <div
                                            class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Typography</h3>
                                        </div>
                                        <div
                                            class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Color</h3>
                                        </div>
                                        <div
                                            class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Grid</h3>
                                        </div>
                                    </div>
                                    <div
                                        class="p-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                                        <h5 class="text-xl font-bold dark:text-white">{{ __('message.cover') }}</h5>

                                        <div
                                            class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Card header</h3>
                                        </div>
                                        <div
                                            class="h-16 px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Card body</h3>
                                        </div>
                                        <div
                                            class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Card footer</h3>
                                        </div>
                                    </div>
                                    <div
                                        class="p-4 col-span-2 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                                        <div
                                            class="text-gray-400  rounded dark:border-gray-600">
                                            <img src="{{ $project->projectImage }}" alt="{{ $project->name }}"
                                                 class="w-full h-96 object-cover mt-2 rounded-lg">
                                        </div>
                                        <div
                                            class="h-16 px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Card body</h3>
                                        </div>
                                        <div
                                            class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                            <h3>Card footer</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <style>

    </style>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
