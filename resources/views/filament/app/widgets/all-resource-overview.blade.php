<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
            <h3 class="text-primary-600 font-bold py-2 px-4 text-lg sm:text-xl">
                Latest Resources
            </h3>

            <div class="w-full sm:w-1/3">
                <input type="text"
                       wire:model.live="searchTerm" wire:keydown.enter="search"
                       placeholder="Search resources..."
                       class="w-full sm:w-64 lg:w-full p-3 border border-primary-500 rounded-md shadow-sm focus:ring-2 focus:ring-primary-500 focus:outline-none"
                />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($this->resources() as $resource)
                <a href="{{ route('filament.app.pages.preview-resource', ['recordId' => $resource->id]) }}" wire:navigate
                   class="bg-white h-68 shadow rounded-lg transform transition duration-300 hover:scale-105">
                    <!-- Responsive Image Container -->
                    <div class="h-64 overflow-hidden flex items-center justify-center rounded-md">
                        <img src="{{ Storage::url($resource->cover_image) }}"
                             class="w-full h-full object-cover sm:h-full md:h-56 lg:h-64 xl:h-72 rounded-t-md"
                             alt="Cover Image" />
                    </div>

                    <h2 class="text-xs font-semibold text-center text-gray-800 mt-2">{{ $resource->title }}</h2>
                    <p class="text-gray-500 text-xs text-center mt-1 mb-2">
                        <span class="font-semibold text-success-700">Category: </span>{{ $resource->category->name }}
                    </p>
                </a>
            @endforeach
        </div>


        <div class="mt-4">
            {{ $this->resources()->links() }}
        </div>
{{--        <div class="w-full lg:w-7/10 p-2 bg-white hover:rounded-md">--}}
{{--            @if ($resources['data'])--}}
{{--                @foreach($resources['data'] as $resource)--}}
{{--                    <div class="flex flex-col sm:flex-row gap-4 p-4 bg-white hover:bg-gray-50 hover:rounded-md">--}}
{{--                        <!-- Image Section -->--}}
{{--                        <div class="flex-shrink-0">--}}
{{--                            <a href="#">--}}
{{--                                <img src="{{ Storage::url($resource['cover_image']) }}" alt="resource image"--}}
{{--                                     class="w-28 h-32 object-cover rounded-lg">--}}
{{--                            </a>--}}
{{--                        </div>--}}

{{--                        <!-- Content Section -->--}}
{{--                        <div class="flex-1 sm:pt-0">--}}
{{--                            <!-- Title Section -->--}}
{{--                            <h3 class="text-sm font-bold text-blue-700">--}}
{{--                                <a href="{{ route('filament.app.pages.preview-resource', ['recordId' => $resource['id']]) }}"--}}
{{--                                   wire:navigate class="underline hover:text-blue-500">{{ $resource['title'] }}</a>--}}
{{--                            </h3>--}}

{{--                            <!-- Author and Category Section -->--}}
{{--                            <p class="text-sm font-semibold text-yellow-600 italic mt-2">--}}
{{--                                by {{ $resource['authors'] }}, {{ $resource['year_of_publication'] }} <br/>--}}
{{--                            </p>--}}
{{--                            <p class="text-xs font-semibold text-yellow-600 italic mt-2">--}}
{{--                                Category: {{ $resource['category']['name']}} <br/>--}}
{{--                            </p>--}}
{{--                            <p class="text-xs text-gray-800 mt-2">--}}
{{--                                by {{ Str::limit(strip_tags($resource['abstract']), 250) }} <br/>--}}
{{--                            </p>--}}
{{--                            <!-- Action Buttons -->--}}

{{--                            <div class="flex flex-wrap gap-2 justify-end items-center pt-2">--}}
{{--                                <!-- Preview Button -->--}}
{{--                                <!-- how to dispatch event with data when using alpine -->--}}
{{--                                <button wire:click="openModal({{ $resource['id'] }})" class="btn-nap-primary">--}}
{{--                                    Preview--}}
{{--                                </button>--}}

{{--                                <!-- Send to Email Button -->--}}
{{--                                <button class="btn-nap-primary">--}}
{{--                                    Send to Email--}}
{{--                                </button>--}}

{{--                                <!-- Add to Reading List Button -->--}}
{{--                                @if(Auth::check())--}}
{{--                                    <button class="btn-nap-primary">--}}
{{--                                        Add to Reading List--}}
{{--                                    </button>--}}
{{--                                @endif--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <hr class="space-y-1 border border-gray-200 w-full pl-4 pr-4"/>--}}
{{--                @endforeach--}}
{{--            @else--}}
{{--                <div--}}
{{--                    class="flex flex-col items-center text-center justify-center sm:flex-row gap-4 p-4 bg-white hover:bg-gray-100 hover:rounded-md h-screen">--}}
{{--                    <p>No available resources right now.</p>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

    </x-filament::section>
</x-filament-widgets::widget>
