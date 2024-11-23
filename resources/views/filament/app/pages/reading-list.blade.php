<x-filament-panels::page>
    <div>
        <div class="flex flex-col lg:flex-row justify-between">

            <div class="w-full lg:w-7/10 p-2 bg-white hover:rounded-md">
                @if ($resources['data'])
                    @foreach($resources['data'] as $resource)
                        <div class="flex flex-col sm:flex-row gap-4 p-4 bg-white hover:bg-gray-50 hover:rounded-md">
                            <!-- Image Section -->
                            <div class="flex-shrink-0">
                                <a href="#">
                                    <img src="{{ Storage::url($resource['cover_image']) }}" alt="resource image"
                                         class="w-28 h-32 object-cover rounded-lg">
                                </a>
                            </div>

                            <!-- Content Section -->
                            <div class="flex-1 sm:pt-0">
                                <!-- Title Section -->
                                <h3 class="text-sm font-bold text-teal-700">
                                    <a href="{{ route('filament.app.pages.preview-resource', ['recordId' => $resource['id']]) }}"
                                       wire:navigate class="underline hover:text-amber-500">{{ $resource['title'] }}</a>
                                </h3>

                                <!-- Author and Category Section -->
                                <p class="text-sm font-semibold text-yellow-600 italic mt-2">
                                    by {{ $resource['authors'] }}, {{ $resource['year_of_publication'] }} <br/>
                                </p>
                                <p class="text-xs font-semibold text-yellow-600 italic mt-2">
                                    Category: {{ $resource['category']['name']}} <br/>
                                </p>
                                <p class="text-xs text-gray-800 mt-2">
                                    by {{ Str::limit(strip_tags($resource['abstract']), 250) }} <br/>
                                </p>
                                <!-- Action Buttons -->

                                <div class="flex flex-wrap gap-2 justify-end items-center pt-2">
                                    <!-- Preview Button -->
                                    <!-- how to dispatch event with data when using alpine -->
                                    <button wire:click="openModal({{ $resource['id'] }})" class="btn-nap-primary">
                                        Preview
                                    </button>

                                    <!-- Send to Email Button -->
                                    <button class="btn-nap-primary">
                                        Send to Email
                                    </button>

                                    <!-- Add to Reading List Button -->
                                    @if(Auth::check())
                                        <button wire:click="detachMember({{ $resource['id'] }})" class="btn-nap-primary">
                                            Remove Reading List
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <hr class="space-y-1 border border-gray-200 w-full pl-4 pr-4"/>
                    @endforeach
                @else
                    <div class="flex flex-col items-center text-center justify-center sm:flex-row gap-4 p-4 bg-white hover:bg-gray-100 hover:rounded-md h-screen">
                        <p>No available resources right now.</p>
                    </div>
                @endif
            </div>
            <div class="lg:w-3/10 w-full bg-white p-4" style="width:450px;">
                <div class="mb-6">
                    <input type="text" wire:model.live="searchTerm" id="searchTerm" wire:keydown.enter="searchBooks"
                           placeholder="Search resources..." class="w-full p-2 border border-primary-500 rounded-md"/>
                </div>
                <div
                    class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <a href="#" aria-current="true"
                       class="block w-full px-4 py-2 text-white bg-primary-600 border-b border-gray-200 rounded-t-lg cursor-pointer dark:bg-gray-800 dark:border-gray-600">
                        Resource categories
                    </a>
                    @if($categories)
                        @foreach($categories['data'] as $category)
                            <a href="#" wire:click="resourceCategories({{ $category['id']}})"
                               class="block w-full px-4 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                                {{ $category['name']}}
                            </a>
                        @endforeach
                    @else
                        <p>No categories listed</p>
                    @endif
                </div>

                @if (!empty($categories['links']))
                    <div class="flex space-x-2">
                        @foreach ($categories['links'] as $link)
                            <a href="" wire:click.prevent="gotoPage({{ $link['label'] }})"
                               class="px-3 py-1 border rounded {{ $link['active'] ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">
                                {!! $link['label'] !!}
                            </a>
                        @endforeach
                    </div>
                @endif


            </div>

        </div>

        <div class="mt-4">
            @if (!empty($resources['links']))
                <div class="flex space-x-2">
                    @foreach ($resources['links'] as $link)
                        <a href="" wire:click.prevent="gotoPage({{ $link['label'] }})"
                           class="px-3 py-1 border rounded {{ $link['active'] ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">
                            {!! $link['label'] !!}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>


        <div x-data="{ isOpen: @entangle('isOpen'), res: @entangle('res') }">

            <div x-show="isOpen" x-transition
                 class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    @if ($res)
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $res->title }}
                                </h3>
                                <button wire:click="isOpen = false" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="default-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 space-y-4">
                                <h3>Summary</h3>
                                <p
                                    class="text-base text-xs italic leading-relaxed text-gray-800 dark:text-gray-400 text-justify">
                                    {{ strip_tags($res->abstract) }}
                                </p>
                                <p class="text-xs"><span class="font-semibold">Author(s):</span> {{ $res->authors }}, <span
                                        class="font-semibold">Category:</span> {{ $res->category->name }}, <span
                                        class="font-semibold">Published:</span> {{ $res->year_of_publication }}</p>
                            </div>
                            <!-- Modal footer -->
                            <div
                                class="flex justify-between items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                                <a href="{{ route('filament.app.pages.preview-resource', ['recordId' => $res->id]) }}"
                                   wire:navigate type="button"
                                   class="btn-nap-success ">
                                    View PDF
                                </a>
                                <button wire:click="isOpen = false" type="button"
                                        class="btn-nap-primary-modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>
</x-filament-panels::page>
