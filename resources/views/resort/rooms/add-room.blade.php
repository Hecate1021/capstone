@extends('design.header')
@section('content')
<div class="bg-gray-200 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md" style="max-height: 100vh; overflow-y: auto;">
        <h2 class="text-center text-2xl font-bold mb-4">Add Room</h2>
        <form action="{{ route('room.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" step="0.01" class="mt-1 p-2 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Image</label>
                <input type="file" class="filepond" name="image" multiple credits="false" />
            </div>
            <div class="text-center">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Submit</button>
            </div>
        </form>
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

