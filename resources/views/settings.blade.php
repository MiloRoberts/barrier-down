<x-layout>
    <x-slot name="styling">
        <link rel='stylesheet' href='/css/settings.css' />
    </x-slot>
    <x-slot name="content">

        {{ auth()->id() }}
        
    </x-slot>
</x-layout>