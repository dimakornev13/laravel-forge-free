<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="container m-auto p-12 flex flex-row space-x-6">
        <div class="w-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($entities->count() === 0)
                    <p class="text-center">There is no events</p>

                @else
                    <table>
                        <tr>
                            <th>Type</th>
                            <th class="w-75">Message</th>
                            <th>Datetime</th>
                        </tr>
                        @each('dashboard.events._item', $entities, 'entity')
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
