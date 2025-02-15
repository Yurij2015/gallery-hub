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
                                  aria-current="page">{{ __('message.reviews') }} </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-bock min-w-full align-middle">
                <div class="overflow-hidden shadow overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 relative overflow-hidden">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.id') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.client') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs text-mediun text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.comment') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.added') }}
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                {{ __('message.showImage') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @if($userReactions)
                            @php($i = 1)
                            @foreach($userReactions as $reaction)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $i++  }}</td>
                                    <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                        <img class="w-32 h-32" src="{{ $reaction->object_url }}"
                                             data-tooltip-target="tooltip-object-{{ $reaction->id }}"
                                             onerror="this.onerror=null;this.src='{{ asset('images/image-deleted.svg') }}';"
                                             alt="{{ $reaction->object_key }}">
                                        <div class="text-sm font-normal text-gray-900 dark:text-gray-400">
                                            <div class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                                {{ $reaction->client_name }}
                                            </div>
                                            <div
                                                class="text-base font-normal text-gray-500 dark:text-white stringDisplay"
                                                data-full-string="{{ $reaction->object_key }}">
                                            </div>
                                        </div>
                                        <div id="tooltip-object-{{ $reaction->id }}" role="tooltip"
                                             class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-800">
                                            {{ $reaction->object_key }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                {{ $reaction->comment_message }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400 text-center">
                                                {{ $reaction->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400 text-center">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('projects.show', $reaction->project->id) }}"
                                                   data-tooltip-target="tooltip-view-{{$reaction->id}}"
                                                   data-image-src="{{ $reaction->object_url }}"
                                                   data-reaction-id="{{ $reaction->id }}"
                                                   data-modal-target="imageModal"
                                                   data-modal-toggle="imageModal"
                                                   class="imageLink inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                              d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div id="tooltip-view-{{ $reaction->id }}" role="tooltip"
                                                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-800">
                                                {{ __('message.viewImage') }}
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

    <!-- Image preview modal -->
    <div id="imageModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
    >
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white image-preview-title">
                        {{ __('message.imagePreview') }}
                    </h3>
                    <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="imageModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">{{ __('message.closeModal') }}</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <img id="modalImage" src="" alt="Image Preview" class="w-full h-auto">
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
            width: 30ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            direction: rtl;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageLinks = document.querySelectorAll('.imageLink');
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const imagePreviewTitle = document.querySelector('.image-preview-title');

            imageLinks.forEach((link) => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const imageUrl = link.getAttribute('data-image-src');

                    const tempImage = new Image();
                    tempImage.src = imageUrl;

                    tempImage.onload = function () {
                        modalImage.src = imageUrl;
                        imageModal.classList.remove('hidden');
                    };

                    tempImage.onerror = function () {
                        console.warn('Image not found:', imageUrl);
                        imagePreviewTitle.textContent = '{{ __('message.imageNotFound') }}';
                        modalImage.src = '{{ asset('images/image-deleted.svg') }}';
                        imageModal.classList.remove('hidden');
                    };
                });
            });
        });
    </script>
@endpush

