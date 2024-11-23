<x-filament-panels::page>

{{--    <h1 class="text-lg font-semibold text-gray-800">--}}
{{--        {{ __('All Resources')}}--}}
{{--    </h1>--}}

{{--    <div class="mb-6">--}}
{{--        <input type="text" wire:model.live="search" placeholder="Search resources..."--}}
{{--               class="w-full p-2 border border-gray-300 rounded-md"/>--}}
{{--    </div>--}}
{{--    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">--}}
{{--        @foreach ($this->getRecords() as $record)--}}
{{--            <a href="{{ route('filament.app.pages.preview-resource', ['recordId' => $record->id]) }}" wire:navigate--}}
{{--               class="bg-white h-68 shadow rounded-lg transform transition duration-300 hover:scale-105">--}}
{{--                <!-- Responsive Image Container -->--}}
{{--                <div class="h-64 overflow-hidden flex items-center justify-center rounded-md">--}}
{{--                    <img src="{{ Storage::url($record->cover_image) }}"--}}
{{--                         class="w-full h-full object-cover sm:h-full md:h-56 lg:h-64 xl:h-72 rounded-t-md"--}}
{{--                         alt="Cover Image" />--}}
{{--                </div>--}}

{{--                <h2 class="text-xs font-semibold text-center text-gray-800 mt-2">{{ $record->title }}</h2>--}}
{{--                <p class="text-gray-500 text-xs text-center mt-1 mb-2">--}}
{{--                    <span class="font-semibold text-success-700">Category: </span>{{ $record->category->name }}--}}
{{--                </p>--}}
{{--            </a>--}}
{{--        @endforeach--}}
{{--    </div>--}}


{{--    <div class="mt-4">--}}
{{--        {{ $this->getRecords()->links() }}--}}
{{--    </div>--}}


</x-filament-panels::page>
