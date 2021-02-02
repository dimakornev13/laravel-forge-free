<script>
    function confirmDelete(){
        return{
            openModal: false,
            shouldSend: false,

            submitForm(){
                console.log(this.shouldSend)
                return this.shouldSend
            }
        }
    }
</script>

<form action="{{ url($url) }}" method="post" x-data="confirmDelete()" x-on:submit="submitForm">
    @csrf

    @method('delete')

    <button type="button" class="bg-red-600 py-1 px-3 text-white rounded-md confirm" @click="openModal = true">
        <i class="fal fa-trash"></i>
    </button>

    <div
        class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-50 duration-300 overflow-y-auto"
        x-show="openModal"
        x-transition:enter="transition duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3 mx-2 sm:mx-auto my-10 opacity-100">
            <div
                class="relative bg-white shadow-lg rounded-lg text-gray-900 z-20"
                @click.away="openModal = false"
                x-show="openModal"
                x-transition:enter="transition transform duration-300"
                x-transition:enter-start="scale-0"
                x-transition:enter-end="scale-100"
                x-transition:leave="transition transform duration-300"
                x-transition:leave-start="scale-100"
                x-transition:leave-end="scale-0"
            >
                <header class="flex flex-col justify-center items-center p-3 text-green-600">
                    <h2 class="font-semibold text-2xl">Are you sure to delete this?</h2>
                </header>
                <main class="p-3 text-center">
                    <b>{{ $content }}</b>
                </main>
                <footer class="flex justify-center bg-transparent">
                    <button
                        class="bg-red-600 font-semibold text-white py-3 w-full hover:bg-red-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300"
                        @click="shouldSend = true"
                    >
                        Confirm
                    </button>
                    <button
                        class="bg-green-600 font-semibold text-white py-3 w-full hover:bg-green-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300"
                        @click="openModal = false"
                    >
                        Cancel
                    </button>
                </footer>
            </div>
        </div>
    </div>


</form>
