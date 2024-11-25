@extends('design.header')
@section('content')

<div class="container mx-auto py-4 flex justify-center">
    <div class="bg-white shadow-md rounded-lg p-6 mx-15 border border-gray-300">
        <h2 class="text-2xl font-semibold mb-6 text-center">Edit Room</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative grid grid-cols-3 gap-4">
                @foreach ($room->images as $image)
                    <div class="relative w-full h-32 bg-gray-200 flex items-center justify-center">
                        <img src="{{ asset('storage/images/' . $image->path) }}" alt="{{ $image->name }}" class="object-cover h-full w-full rounded-md">
                        <form action="{{ route('image.destroy', $image->id) }}" method="POST" class="absolute top-0 right-0 mt-1 mr-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-gray-200 hover:bg-red-600 rounded-full p-1 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            <form action="{{ route('room.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ $room->name }}" class="mt-1 p-2 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 p-2 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ $room->description }}</textarea>
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price" value="{{ $room->price }}" step="0.01" class="mt-1 p-2 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Upload New Images</label>
                    <input type="file" class="filepond" name="image" multiple credits="false" />
                </div>
                <div>
                    <button type="submit" class="mt-4 w-full inline-flex justify-center rounded-md border border-transparent bg-blue-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update Room</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
    document.getElementById('price').addEventListener('input', function (event) {
        let value = event.target.value;
        if (value.includes('.')) {
            let parts = value.split('.');
            if (parts[1].length > 2) {
                event.target.value = parseFloat(value).toFixed(2);
            }
        }
    });
</script>
@endpush
