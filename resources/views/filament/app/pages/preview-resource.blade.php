<x-filament-panels::page>
    <h1 class="text-lg font-semibold text-gray-800">
        {{ __($resource->title)}}
    </h1>
    <div class="flex flex-col gap-4 lg:flex-row">
        <div class="850px; h-screen">
            <iframe src="{{ asset('/storage/' . $resource->file) }}#view=fitH"
                    style="width:850px; height:850px; toolbar:0;" frameborder="0">
            </iframe>
        </div>
        <div class="p-2">
            <div class="p-6 bg-white shadow-lg rounded-lg max-w-full sm:max-w-lg mx-auto sm:text-center">
                <!-- Title Section -->
                <div class="mb-6">
                    <p class="font-semibold underline underline-offset-4 text-sm sm:text-sm text-gray-800 mb-3">
                        {{ $resource->title }}
                    </p>
                    <p class="text-gray-700 text-justify leading-relaxed" style="font-size: 12px;">
                        {{ Str::limit(strip_tags($resource->abstract), 250, '...') }}
                    </p>
                    <span class="block text-left">
                        <a href="#" class="text-primary-500 hover:text-green-700 font-medium" style="font-size: 12px;"
                           wire:click="readmore">Read
                            more</a>
                    </span>
                </div>

                <!-- Category and Author Tags -->
                <div class="flex flex-wrap gap-2 justify-center mb-5">
                    <span class="inline-flex items-center px-3 py-1.5 text-gray-800 rounded-full text-xs font-medium">
                        Authors: {{ $resource->authors }}
                    </span>
                    <span
                        class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                        Category: {{ $resource->category->name }}
                    </span>
                </div>

                <hr class="border-t border-gray-300 mb-5"/>

                <!-- Button Section -->
                <div class="flex justify-center items-center flex-row block">
                    <button
                        class="btn-nap-primary mr-1">
                        Add to reading list
                    </button>
                    <button
                        class="btn-nap-primary ml-1">
                        Send to email
                    </button>
                </div>
            </div>

            <div class="w-full text-left mt-5 rounded-md shadow-lg">

                <div
                    class="w-full text-sm font-medium text-gray-900 shadow-lg rounded-t-lg bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <a href="#" aria-current="true"
                       class="block w-full px-4 py-2 text-white bg-primary-600 border-b border-gray-200 rounded-t-lg cursor-pointer dark:bg-gray-800 dark:border-gray-600">
                        Resource categories
                    </a>
                    @if($categories)
                        @foreach($categories['data'] as $category)
                            <a href="{{ route('filament.app.pages.books',['recordId' => $category['id']]) }}" wire:navigate
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





    </div>
    <div x-data="{ isOpen: @entangle('isOpen') }">

        <div x-show="isOpen" x-transition
             class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                @if ($resource)
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $resource->title }}
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
                                class="text-base text-xs italic leading-relaxed text-gray-500 dark:text-gray-400 text-justify">
                                {{ strip_tags($resource->abstract) }}
                            </p>
                            <p class="text-xs"><span class="font-semibold">Author(s):</span> {{ $resource->authors }},
                                <span
                                    class="font-semibold">Category:</span> {{ $resource->category->name }}, <span
                                    class="font-semibold">Published:</span> {{ $resource->year_of_publication }}</p>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex justify-between items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                            <a href="{{ route('filament.app.pages.preview-resource', ['recordId' => $resource->id]) }}"
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


</x-filament-panels::page>
