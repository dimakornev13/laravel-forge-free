<x-app-layout>
    <x-slot name="meta_title">Ssl for {{ $site->getUrl() }}</x-slot>
    <x-slot name="header">Ssl for {{ $site->getUrl() }}</x-slot>

    <div class="container m-auto py-12">
        <div class="w-6/12 m-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col space-y-12">
                    <form action="{{ route('ssl.obtain', ['site' => $site]) }}" method="post">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn rounded-md bg-green-600 hover:bg-green-700 text-white p-3">Obtain certificate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
