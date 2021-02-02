<?php
/** @var \App\Models\Site $site */
?>

<x-app-layout>
    <x-slot name="header">{{ $site->getUrl() }}</x-slot>

    <div class="container max-w-7xl m-auto py-12 flex flex-row space-x-4">
        <div class="w-3/12">
            @include('common.menu')
        </div>
        <div class="w-9/12 flex flex-col space-y-6">
            @if(!empty($site->getRepository()) && !empty($site->getDeployScript()))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex flex-col space-y-12">
                        <div class="flex flex-row justify-between">
                            <h5 class="font-bold">Deployment</h5>

                            <a href="{{ route('deploy.do', ['site' => $site]) }}"
                               class="btn rounded-md text-white bg-green-600 hover:bg-green-700 p-3">Deploy now</a>
                        </div>

                        <a href="#" class="btn rounded-md bg-gray-200 hover:bg-gray-300 p-3 text-center">View latest deployment log</a>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200 flex flex-col space-y-12">
                    <h5 class="font-bold">Deploy Script</h5>

                    @if(empty($site->getDeployScript()))
                        <p class="text-red-600">In order to make deploy available save this field below</p>
                    @endif

                    <form action="{{ route('sites.update', ['site' => $site]) }}" method="post">
                        @csrf

                        <textarea name="deploy_script" class="form-control" id="" cols="30"
                                  rows="10">{{ $site->getDeployScript() }}</textarea>

                        <div class="text-right">
                            <button type="submit"
                                    class="btn rounded-md text-white bg-green-600 hover:bg-green-700 p-3">Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200 flex flex-col space-y-12">
                    <h5 class="font-bold">Update Git Remote</h5>

                    <form action="{{ route('sites.update', ['site' => $site]) }}" method="post">
                        @csrf

                        <input type="text" class="form-control w-full" name="repository" value="{{ $site->getRepository() }}">

                        <div class="text-right">
                            <button type="submit"
                                    class="btn rounded-md text-white bg-green-600 hover:bg-green-700 p-3">Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white border-b border-gray-200 flex flex-col space-y-12">
                    <h5 class="font-bold">Environment</h5>

                    @if(empty($site->getEnvironment()))
                        <p class="text-red-600">In order to make deploy available save this field below</p>
                    @endif

                    <form action="{{ route('sites.update', ['site' => $site]) }}" method="post">
                        @csrf

                        <textarea name="environment" class="form-control" id="" cols="30"
                                  rows="10">{{ $site->getEnvironment() ?? getDefaultEnvironment() }}</textarea>

                        <div class="text-right">
                            <button type="submit"
                                    class="btn rounded-md text-white bg-green-600 hover:bg-green-700 p-3">Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

