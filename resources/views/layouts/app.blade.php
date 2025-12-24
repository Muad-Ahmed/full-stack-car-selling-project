@props(['title' => '','bodyClass' => null, 'footerLinks' => ''])

<x-base-layout :$title>
    <x-layouts.header />
    {{ $slot }}
    
</x-base-layout>
