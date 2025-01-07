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
                                            <div class="col-span-6 sm:col-span-1">
                                                <label for="brand"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('message.creationDate') }}</label>
                                                <div class="relative max-w-sm">
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
                                            <div class="col-span-6 sm:col-span-1">
                                                <label for="price"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ __('message.expirationDate') }}
                                                </label>
                                                <div class="relative max-w-sm">
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
                                                <label for="projectLink"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ __('message.projectLink') }}
                                                </label>
                                                <input id="projectLink" name="project_link" type="text"
                                                       class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                       value="{{ $project->project_link }}">
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
                                        <button type="submit"
                                                class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                            {{ __('message.editProject') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="bg-white dark:bg-gray-900">
                        <div class="px-4 mx-auto max-w-6xl mb-20">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($projectObjects as $projectObject)
                                    <div>
                                        <img class="h-auto max-w-full rounded-lg"
                                             src="{{ $projectObject->getObjectUrl() }}"
                                             alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop

