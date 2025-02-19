<div x-data="{ openModal: false, availabilities: {} }" x-init="fetch('{{ route('resort.availability.get', ['resortId' => Auth::id()]) }}')
    .then(response => response.json())
    .then(data => availabilities = data.reduce((acc, item) => {
        acc[item.day] = item;
        return acc;
    }, {}))">

    <!-- Button to Open Modal -->
    <button @click="openModal = true"
        class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-200 shadow-md">
        Manage Availability
    </button>

    <!-- Modal -->
    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-[500px] max-w-[90%]">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">Resort Availability</h2>

            <form action="{{ route('resort.availability.store') }}" method="POST">
                @csrf

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-3 text-left font-semibold text-gray-700">Day</th>
                            <th class="p-3 text-left font-semibold text-gray-700">Opening</th>
                            <th class="p-3 text-left font-semibold text-gray-700">Closing</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <tr class="border-b hover:bg-gray-50 transition duration-150">
                                <td class="p-4 font-medium text-gray-600">{{ $day }}</td>
                                <td class="p-4">
                                    <input type="time" name="availability[{{ $day }}][opening_time]"
                                        x-bind:value="availabilities['{{ $day }}']?.opening_time || ''"
                                        class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">
                                </td>
                                <td class="p-4">
                                    <input type="time" name="availability[{{ $day }}][closing_time]"
                                        x-bind:value="availabilities['{{ $day }}']?.closing_time || ''"
                                        class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" @click="openModal = false"
                        class="px-6 py-2.5 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 font-medium shadow-md">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
