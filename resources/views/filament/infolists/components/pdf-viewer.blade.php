@php
    $url = $getRecord()->getFirstMediaUrl('pdf');
@endphp

<div class="flex flex-col items-center gap-2">
    <iframe src="{{ $url }}" class="w-full h-[400px] rounded-lg border border-gray-300"></iframe>
    <a href="{{ $url }}" target="_blank"
        class="filament-button filament-button-size-md inline-flex items-center justify-center py-2 px-4 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filter-none bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 text-white border-transparent">
        Ouvrir le PDF
    </a>
</div>
