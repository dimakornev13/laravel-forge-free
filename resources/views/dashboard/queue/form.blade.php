<form action="{{ route('queue.store') }}" method="post">
    @csrf
    @method('put')

    <div class="flex flex-col space-y-6">
        @foreach($fields as $field)
            @if($field === 'site_id')
                <input type="hidden" name="{{ $field }}" value="{{ $site->getId() }}">
            @else
                <div class="flex flex-row space-x-6">
                    <div class="text-right w-4/12">{{ $field }}</div>
                    <div class="w-8/12">
                        <input type="text" class="form-control" name="{{ $field }}" placeholder="" required>
                    </div>
                </div>
            @endif
        @endforeach

        <div class="text-right">
            <button type="submit" class="btn rounded-md bg-green-600 hover:bg-green-700 text-white p-3">
                Save
            </button>
        </div>
    </div>

</form>
