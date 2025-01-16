@extends('client-main')
@section('content')
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
                    {{ $project->getSizeOfProject() }}
            </span>
            <a href="{{ route('download-folder', $project->id) }}"
               class="py-2 px-3 me-2 mb-9 text-xs text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-sm text-sx text-center inline-flex items-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg class="w-3 h-3 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z"
                          clip-rule="evenodd"/>
                    <path fill-rule="evenodd"
                          d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z"
                          clip-rule="evenodd"/>
                </svg>
                {{ __('client-gallery.download') }}
            </a>

            <div class="gallery">
                <div class="flex flex-col mb-10">
                    <div class="grid md:grid-cols-12 gap-8 lg:mb-11 mb-7">
                        @foreach($projectObjects as $object)
                            <div class="relative md:col-span-4 h-[277px] w-full rounded-3xl mb-7">
                                <a href="{{ $object->objectUrl }}"
                                   data-gallery="gallery-{{ $project->id }}"
                                   data-description='
                                                                   <div class="flex items-center space-x-2">
                                                                       <!-- Like Button -->
                                                                       <button class="like-btn" data-id="{{ $object->key }}">❤️ Like</button>

                                                                       <!-- Comment Input -->
                                                                       <input type="text" name="name" placeholder="Yout name..."
                                                                              class="comment-input border border-gray-300 rounded-lg px-2 py-1 text-sm w-full"
                                                                              data-id="{{ $object->key }}">
                                                                                   <input type="text" name="comment" placeholder="Add a comment..."
                                                                              class="comment-input border border-gray-300 rounded-lg px-2 py-1 text-sm w-full"
                                                                              data-id="{{ $object->key }}">

                                                                       <!-- Save Comment Button -->
                                                                       <button class="save-comment-btn bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition"
                                                                               data-id="{{ $object->key }}">
                                                                           Save
                                                                       </button>
                                                                   </div>'
                                   class="glightbox">
                                    <img src="{{ $object->objectUrl }}" alt="{{ $object->objectName }}"
                                         class="gallery-image object-cover rounded-3xl hover:grayscale transition-all duration-700 ease-in-out mx-auto lg:col-span-4 md:col-span-6 w-full h-full">
                                    <p class="text-sm text-gray-900 sm:text-sm dark:text-white text-center mt-2">
                                        {{ $object->getObjectName() }}
                                    </p>
                                </a>
                                <button
                                    data-modal-target="like-modal"
                                    data-modal-toggle="like-modal"
                                    class="absolute top-2 right-2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100 like-btn-preview"
                                    data-id="{{ $object->key  }}"
                                    data-object="{{ json_encode($object) }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" class="w-6 h-6 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4.318 6.318a4.5 4.5 0 011.406-1.094 4.5 4.5 0 015.68 0l.596.596.596-.596a4.5 4.5 0 015.68 0 4.5 4.5 0 011.406 1.094 4.5 4.5 0 010 5.68l-7.072 7.072a1 1 0 01-1.414 0L4.318 12a4.5 4.5 0 010-5.682z"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="like-modal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add your comment
                        </h3>
                        <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="like-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        {{--                        <p class="text-sm font-semibold text-gray-900 dark:text-white hidden"><span id="liked-image-id"></span></p>--}}
                        <form class="space-y-4" action="#">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    name</label>
                                <input type="text" name="name" id="name"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="Type your name" required value="{{ session('client_name') }}"/>
                            </div>
                            <div class="col-span-2">
                                <label for="comment"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    comment</label>
                                <textarea id="comment" rows="4"
                                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                          placeholder="Write your comment here"></textarea>
                            </div>
                            <button id="save-comment"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <style>
        #like-modal {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
@endsection

@push('scripts')
    <script>
        let currentImageId = null;
        let currentObject = null;

        const project = @json($project);
        const user = @json($user);
        const likeProjectUrl = "{{ route('client.projects.like', ['project' => '__PROJECT_ID__']) }}";
        const commentProjectUrl = "{{ route('client.projects.comment', ['project' => '__PROJECT_ID__']) }}";
        const clientName = "{{ session('client_name') }}" || null;

        if(clientName){
            const buttons = document.querySelectorAll('.like-btn-preview');
            buttons.forEach(button => {
                button.removeAttribute('data-modal-toggle');
            });
        }

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('like-btn')) {
                document.getElementById('liked-image-id').textContent = e.target.getAttribute('data-id');
            }
        });

        document.getElementById('save-comment').addEventListener('click', function (e) {
            e.preventDefault();

            const nameInput = document.getElementById('name');
            const commentInput = document.getElementById('comment');

            if (!nameInput.checkValidity()) {
                nameInput.focus();
                return;
            }

            if (!commentInput.checkValidity()) {
                commentInput.focus();
                return;
            }

            const name = nameInput.value;
            const comment = commentInput.value;

            sendCommentRequest(currentImageId, currentObject, comment, name);
            // document.getElementById('like-modal').classList.add('hidden');
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('like-btn')) {
                console.log('Like button clicked!');

                const button = e.target;

                button.innerHTML = button.innerHTML === '❤️ Like' ? '💔 Unlike' : '❤️ Like';
            }
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.like-btn-preview')) {

                const button = e.target.closest('.like-btn-preview');
                const imageId = button.getAttribute('data-id');
                const object = JSON.parse(button.getAttribute('data-object'));

                currentImageId = button.getAttribute('data-id');
                currentObject = JSON.parse(button.getAttribute('data-object'));

                // Toggle liked state (change heart color)
                const heartIcon = button.querySelector('svg');
                heartIcon.classList.toggle('text-red-500');
                heartIcon.classList.toggle('text-gray-500');

                // console.log(`Toggled like for image ID: ${imageId}`);
                console.log({userId: user.id, projectId: project.id});

                sendLikeRequest(imageId, object);

                // document.getElementById('like-modal').classList.remove('hidden');
            }
        });

        function sendLikeRequest(imageId, object) {
            const url = likeProjectUrl.replace('__PROJECT_ID__', project.id);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    userId: user.id,
                    projectId: project.id,
                    imageId: imageId,
                    object: object,
                    hasLike: true,
                    clientName: clientName
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Object liked:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function sendCommentRequest(imageId, object, comment, name) {
            const url = commentProjectUrl.replace('__PROJECT_ID__', project.id);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    userId: user.id,
                    projectId: project.id,
                    imageId: imageId,
                    object: object,
                    hasComment: true,
                    comment: comment,
                    clientName: name
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Object commented:', data);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

    </script>
@endpush
