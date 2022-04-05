<?php
/** @var \App\Models\Site $site */
?>

<x-app-layout>
    <x-slot name="meta_title">Queues {{ $site->getUrl() }}</x-slot>
    <x-slot name="header">Queues for {{ $site->getUrl() }}</x-slot>

    <div class="container max-w-7xl m-auto py-12 flex flex-row space-x-4">
        <div class="w-3/12">
            @include('common.menu')
        </div>
        <div class="w-9/12 flex flex-col space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col space-y-12">
                    @if($site->queues->count() === 0)
                        <p class="text-center">There is no queue for {{ $site->getUrl() }}</p>
                    @else
                        <table class="w-full">
                            <tr>
                                <th>connection</th>
                                <th>timeout</th>
                                <th>processes</th>
                                <th>tries</th>
                                <th>actions</th>
                            </tr>

                            @each('dashboard.queue._item', $site->queues, 'queue')
                        </table>
                    @endif

                    @include('dashboard.queue.form')
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
