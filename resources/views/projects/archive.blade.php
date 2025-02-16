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
                                  aria-current="page">{{ __('message.archive') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="alert-border"
         class="flex items-center p-4 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800"
         role="alert">
        <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
             viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div class="ms-3 text-sm font-medium">
            {{ __('message.projectCanBeRestored') }}
        </div>
        <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-border" aria-label="Close">
            <span class="sr-only">{{ __('message.dismiss') }}</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-bock min-w-full align-middle">
                <div class="relative overflow-x-auto">
                    <table
                        class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 relative overflow-hidden">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        @if($projects->count())
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
                                    {{ __('message.eventDate') }}
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                    {{ __('message.deleted') }}
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
                                    {{ __('message.renewProject') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
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
                                @php
                                    $expirationDate = Carbon::parse($project->expiration_date);
                                    $currentDate = Carbon::now();
                                    $canBeRenewed = $expirationDate->diffInDays($currentDate) <= 7;
                                    $tooltipText = $canBeRenewed ? __('message.canBeRestored') : __('message.cannotBeRestored');
                                @endphp
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                                            <button
                                                {{ !$canBeRenewed ? 'disabled' : '' }}
                                                data-tooltip-target="renew-tooltip-{{ $project->id }}"
                                                data-project-id="{{ $project->id }}"
                                                class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-sm text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 disabled:opacity-50 disabled:cursor-not-allowed renew-project-button">
                                                {{ __('message.renew') }}
                                            </button>
                                        </div>
                                        <div id="renew-tooltip-{{ $project->id }}" role="tooltip"
                                             class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-800">
                                            {{ $tooltipText }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="6"
                                    class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ __('message.noArchivedProjects') }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
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
        document.addEventListener('DOMContentLoaded', function () {
            const renewProjectButtons = document.querySelectorAll('.renew-project-button');

            renewProjectButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const projectId = button.getAttribute('data-project-id');
                    const url = '{{ route('client.projects.renew', ':id') }}'.replace(':id', projectId);

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('Project successfully renewed');
                                location.reload();
                            } else {
                                alert('Failed to project renew');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to project renew');
                        });
                });
            });
        });

    </script>
@endpush
