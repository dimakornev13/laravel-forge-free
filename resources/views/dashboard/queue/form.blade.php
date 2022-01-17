<form action="{{ route('queue.store') }}" method="post">
    @csrf
    @method('put')

    <div class="flex flex-col space-y-6">
        <input type="hidden" name="site_id" value="{{ $site->getId() }}">

        <div>
            <div>
                <p><b>Timeout</b></p>
                <a href="https://laravel.com/docs/8.x/queues#max-job-attempts-and-timeout" class="border-b border-blue-700">source</a>
            </div>
            <div class="w-8/12">
                <input type="text" class="form-control" name="timeout" placeholder="30 sec" required>
            </div>
        </div>

        <div>
            <div>
                <p><b>processes</b></p>
                <a href="https://laravel.com/docs/8.x/queues#configuring-supervisor" class="border-b border-blue-700">source</a>
            </div>
            <div class="w-8/12">
                <input type="text" class="form-control" name="processes" placeholder="2" required>
            </div>
        </div>


        <div>
            <div>
                <p><b>queue connection</b></p>
                <a href="https://laravel.com/docs/8.x/queues#chain-connection-queue" class="border-b border-blue-700">source</a>
            </div>
            <div class="w-8/12">
                <input type="text" class="form-control" name="queue" placeholder="default" required>
            </div>
        </div>


        <div>
            <div>
                <p><b>tries</b></p>
                <a href="https://laravel.com/docs/8.x/queues#max-attempts" class="border-b border-blue-700">source</a>
            </div>
            <div class="w-8/12">
                <input type="text" class="form-control" name="tries" placeholder="3" required>
            </div>
        </div>


        <div class="text-center">
            <button type="submit" class="btn rounded-md bg-green-600 hover:bg-green-700 text-white p-3 w-full">
                Save
            </button>
        </div>
    </div>

</form>
