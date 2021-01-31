<?php
/** @var \App\Models\Site $site */
?>

<x-app-layout>
    <x-slot name="header">Creating new site</x-slot>

    <div class="container m-auto py-12">
        <div class="w-6/12 m-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('sites.store') }}" method="post" class="flex flex-col space-y-3">
                        @csrf

                        @method('put')

                        @include('dashboard.sites._form')

                        <button class="btn rounded-md bg-green-600 hover:bg-green-700 text-white p-3">Store</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
