<x-app-layout>
    <x-slot name="meta_title">Sites</x-slot>
    <x-slot name="header">Sites</x-slot>

    <div class="container m-auto py-12">
        <div class="w-6/12 m-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col space-y-12">
                    <div class="text-right">
                        <a href="{{ url(route('sites.create')) }}" class="btn rounded-md bg-green-600 hover:bg-green-700 text-white p-3">Create</a>
                    </div>

                    @if($sites->count() === 0)
                        <p class="text-center">There is no sites.</p>
                    @else
                        <table class="w-full">
                            <tr>
                                <th>Site</th>
                                <th width="20%">Actions</th>
                            </tr>
                                @each('dashboard.sites._item', $sites, 'site')
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
