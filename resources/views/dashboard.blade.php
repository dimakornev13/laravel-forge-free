<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="container m-auto py-12 flex flex-row space-x-6">
        <div class="w-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 m-auto">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
