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
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                      aria-current="page">{{ __('message.projects') }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ __('message.projects') }}</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="sites-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="email" id="sites-search"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Search for project">
                        </div>
                    </form>
                </div>
                <a href="{{ route('projects.create') }}"
                   class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    Add new project
                </a>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-bock min-w-full align-middle">
                <div class="relative overflow-x-auto">
                    <table
                        class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 relative overflow-hidden">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                                           class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.id') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.name') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.creationDate') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.expirationDate') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.viewsStatistic') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.downloadStatistic') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.userReactions') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.projectLink') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @if($projects)
                            @php
                                $currentPage = $projects->currentPage();
                                $perPage = $projects->perPage();
                            @endphp
                            @foreach($projects as $index => $project)
                                @php
                                    $rowNumber = ($currentPage - 1) * $perPage + $index + 1;
                                @endphp
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 project-row cursor-pointer"
                                    data-project-edit-url="{{ route('projects.edit', $project->id) }}"
                                >
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-{{ $project->id }}" aria-describedby="checkbox-1"
                                                   type="checkbox"
                                                   class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-{{ $project->id }}" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $rowNumber }}</td>
                                    <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                        {{-- TODO get prev image (by meta, or save in db name of main image--}}
                                        {{--                                        <img class="w-10 h-10" src="/images/users/profile-picture-4.jpg"--}}
                                        <img class="w-10 h-10" src="{{ $project->getProjectImage() }}"
                                             alt="{{ $project->name }} avatar">
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $project->name }}
                                            </div>
                                            {{--  TODO add project statistic --}}
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                {{ $project->getObjectsCount() }} file(s)
                                                ({{ $project->getSizeOfProject() }})
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                        {{ $project->date }}
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                        {{ $project->expiration_date }}
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex justify-center items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-100 border border-gray-500 w-14 h-6 text-center">
                                                <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-width="2"
                                                      d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                <path stroke="currentColor" stroke-width="2"
                                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                                {{ $project->views_statistic }}
                                             </span>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                         <span
                                             class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex justify-center items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-100 border border-gray-500 w-14 h-6">
                                                <svg class="w-3 h-3 me-1.5" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                               <path fill-rule="evenodd"
                                                     d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z"
                                                     clip-rule="evenodd"/>
                                                <path fill-rule="evenodd"
                                                      d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z"
                                                      clip-rule="evenodd"/>
                                                </svg>
                                                {{ $project->download_statistic }}
                                             </span>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex justify-center items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-100 border border-gray-500 w-14 h-6">
                                                <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                  <path fill-rule="evenodd"
                                                        d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z"
                                                        clip-rule="evenodd"/>
                                                </svg>
                                                {{$project->userReactions->where('has_like', 1)->count()}}
                                            </span>
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-100 border border-gray-500 w-14 justify-center h-6 mt-2">
                                                <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                  <path fill-rule="evenodd"
                                                        d="M3 5.983C3 4.888 3.895 4 5 4h14c1.105 0 2 .888 2 1.983v8.923a1.992 1.992 0 0 1-2 1.983h-6.6l-2.867 2.7c-.955.899-2.533.228-2.533-1.08v-1.62H5c-1.105 0-2-.888-2-1.983V5.983Zm5.706 3.809a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Zm2.585.002a1 1 0 1 1 .003 1.414 1 1 0 0 1-.003-1.414Zm5.415-.002a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Z"
                                                        clip-rule="evenodd"/>
                                                </svg>
                                                    {{ $project->userReactions->where('has_comment', 1)->count()}}
                                                </span>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                @if($project->getObjectsCount())
                                                    <a href="{{route('user-projects.show', ['project' =>  $project, 'user' => $project->user->id, 'project-name' => urldecode($project->name)]) }}"
                                                       target="_blank">
                                                        {{ __('message.projectLink')  }}
                                                    </a>
                                                @else
                                                    <span class="cursor-not-allowed">
                                                        {{ __('message.projectLink')  }}
                                                    </span>
                                                @endif
                                                <a href="{{ route('user-projects.show', ['project' =>  $project, 'user' => $project->user->id, 'project-name' => urldecode($project->name)]) }}"
                                                   target="_blank"
                                                   data-tooltip-target="tooltip-copy-{{ $project->id }}"
                                                   data-objects-count="{{ $project->getObjectsCount() }}"
                                                   data-url="{{ route('user-projects.show', ['project' =>  $project, 'user' => $project->user->id, 'project-name' => urldecode($project->name)]) }}"
                                                   class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white rounded-lg bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-primary-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800 ml-2 copyLink {{ !$project->getObjectsCount() ? 'cursor-not-allowed disabled' : ''  }}">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                              d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                                <div id="tooltip-copy-{{ $project->id }}" role="tooltip"
                                                     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-800">
                                                    {{ __('message.copyToClipboard') }}
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                {{ auth()->user()->hasRole('admin') ? $project->user->name  : ''}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <a href="{{ route('projects.show', $project->id) }}"
                                           data-tooltip-target="tooltip-view"
                                           class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                        <div id="tooltip-view" role="tooltip"
                                             class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-800">
                                            {{ __('message.view') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button type="button"
                                                data-modal-target="delete-project-modal-{{ $project->id }}"
                                                data-modal-toggle="delete-project-modal-{{ $project->id }}"
                                                data-tooltip-target="tooltip-delete"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        <div id="tooltip-delete" role="tooltip"
                                             class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-800">
                                            {{ __('message.delete') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <a href="{{ route('project.statistic', $project->id) }}"
                                           data-tooltip-target="tooltip-statistic"
                                           class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white rounded-lg bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-primary-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/>
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/>
                                            </svg>
                                        </a>
                                        <div id="tooltip-statistic" role="tooltip"
                                             class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-800">
                                            {{ __('message.projectStatistic') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        @include('projects.partials.delete-project-modal')
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"
                                    class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ __('message.noDataFound') }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700 pr-24">
        <div class="flex items-center mb-4 sm:mb-0">
            <a href="{{ $projects->previousPageUrl() ?: '#' }}"
               class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                          clip-rule="evenodd"></path>
                </svg>
            </a>
            <a href="{{ $projects->nextPageUrl() ?: '#' }}"
               class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                          clip-rule="evenodd"></path>
                </svg>
            </a>
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ __('message.showing') }} <span
                    class="font-semibold text-gray-900 dark:text-white">{{ $projects->currentPage() . " page" }}</span> of <span
                    class="font-semibold text-gray-900 dark:text-white">{{ $projects->lastPage() . " page(s)" }}</span>
            </span>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ $projects->previousPageUrl() ?: '#' }}"
               class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg
                 {{ $projects->onFirstPage() ? 'bg-gray-600 text-white cursor-not-allowed' : 'bg-primary-700 text-white hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800' }}">
                <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                          clip-rule="evenodd"></path>
                </svg>
                {{ __('message.previous') }}
            </a>

            <!-- Pagination numbers -->
            @php
                $start = max(1, $projects->currentPage() - 3);
                $end = min($projects->lastPage(), $projects->currentPage() + 3);
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                <a href="{{ $projects->url($page) }}"
                   class="px-3 py-2 text-sm font-medium rounded-lg
                    {{ $projects->currentPage() == $page ? 'bg-primary-700 text-white' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    {{ $page }}
                </a>
            @endfor

            <a href="{{ $projects->nextPageUrl() ?: '#' }}"
               class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg
                {{ !$projects->hasMorePages() ? 'bg-gray-600 text-white cursor-not-allowed' : 'bg-primary-700 text-white hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800' }}">
                {{ __('message.next') }}
                <svg class="w-5 h-5 ml-1 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                          clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
@stop
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const projectRows = document.querySelectorAll('.project-row');
            projectRows.forEach(row => {
                row.addEventListener('click', function () {
                    window.location.href = row.getAttribute('data-project-edit-url');
                });
            });


            const copyLinks = document.querySelectorAll('.copyLink');

            copyLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const url = link.getAttribute('data-url');
                    const objectsCount = link.getAttribute('data-objects-count');
                    if (!objectsCount) {
                        return;
                    }
                    navigator.clipboard.writeText(url).then(() => {
                        alert('URL copied to clipboard!');
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                    });
                });
            });
        });
    </script>
@endpush
