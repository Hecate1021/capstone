@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')
    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">

            <!-- Add Category Button -->
            <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="openCategoryModal()">
                Add Category
            </button>

            <!-- Add Subcategory Button -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openSubcategoryModal()">
                Add Subcategory
            </button>

            <!-- Add Category Modal -->
            <div id="categoryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white w-full max-w-md max-h-[90vh] overflow-hidden rounded-lg shadow-lg flex flex-col">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b p-4">
                        <h2 class="text-xl font-semibold">Add Category</h2>
                        <button class="text-gray-600 hover:text-gray-800" onclick="closeCategoryModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="flex-1 p-4 overflow-y-auto">
                        <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
                            @csrf
                            <div class="mb-4">
                                <label for="categoryName" class="block text-sm font-medium text-gray-700">Category
                                    Name</label>
                                <input type="text" name="name" id="categoryName"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                    onclick="closeCategoryModal()">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                    Save Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Subcategory Modal -->
            <div id="subcategoryModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white w-full max-w-md max-h-[90vh] overflow-hidden rounded-lg shadow-lg flex flex-col">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b p-4">
                        <h2 class="text-xl font-semibold">Add Subcategory</h2>
                        <button class="text-gray-600 hover:text-gray-800" onclick="closeSubcategoryModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="flex-1 p-4 overflow-y-auto">
                        <form method="POST" action="{{ route('subcategories.store') }}" class="space-y-4">
                            @csrf
                            <div class="mb-4">
                                <label for="subcategoryName" class="block text-sm font-medium text-gray-700">Subcategory
                                    Name</label>
                                <input type="text" name="name" id="subcategoryName"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="categorySelect" class="block text-sm font-medium text-gray-700">Parent
                                    Category</label>
                                <select name="category_id" id="categorySelect"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                    onclick="closeSubcategoryModal()">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Save Subcategory
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- JavaScript for Modal Functionality -->
            <script>
                function openCategoryModal() {
                    document.getElementById('categoryModal').classList.remove('hidden');
                }

                function closeCategoryModal() {
                    document.getElementById('categoryModal').classList.add('hidden');
                }

                function openSubcategoryModal() {
                    document.getElementById('subcategoryModal').classList.remove('hidden');
                }

                function closeSubcategoryModal() {
                    document.getElementById('subcategoryModal').classList.add('hidden');
                }
            </script>

            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Category Name</th>
                        <th class="py-3 px-6 text-left">Action</th>
                    </tr>
                </thead>
            </table>
            <div class="overflow-x-auto mt-5">
                <table class="min-w-full table-auto">
                    @foreach ($categories as $category)
                        <thead>

                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">{{ $category->name }}</th>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center text-sm">
                                        <!-- Edit button -->
                                        <button data-modal-target="edit-modal-{{ $category->id }}"
                                            data-modal-toggle="edit-modal-{{ $category->id }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Delete button -->
                                        <button data-modal-target="popup-modal-{{ $category->id }}"
                                            data-modal-toggle="popup-modal-{{ $category->id }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Delete">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </thead>

                        <tbody class="text-gray-600 text-sm font-light">
                            <!-- Category Row -->

                            <!-- Subcategories Row -->
                            @if ($category->subcategories->count())
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($category->subcategories as $subcategory)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">{{ $subcategory->name }}</td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center text-sm">
                                            <!-- Edit Subcategory button -->
                                            <button data-modal-target="edit-subcategory-modal-{{ $subcategory->id }}"
                                                data-modal-toggle="edit-subcategory-modal-{{ $subcategory->id }}"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Delete Subcategory button -->
                                            <button data-modal-target="popup-delete-subcategory{{ $subcategory->id }}"
                                                data-modal-toggle="popup-delete-subcategory{{ $subcategory->id }}"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Delete">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        </td>
                        </tr>
                    @endif
                    @endforeach

                    </tbody>
                </table>
            </div>


            <!-- Category List -->
            @foreach ($categories as $category)
                <!-- Edit Category Modal -->
                <div id="edit-modal-{{ $category->id }}" tabindex="-1"
                    class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" data-modal-hide="edit-modal-{{ $category->id }}"
                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M6 4.293a1 1 0 011.414 0L10 7.586l2.586-2.586a1 1 0 111.414 1.414L11.414 9l2.586 2.586a1 1 0 11-1.414 1.414L10 10.414l-2.586 2.586a1 1 0 11-1.414-1.414L8.586 9 6 6.414a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="px-6 py-6 lg:px-8">
                                <h3 class="mb-4 text-xl font-medium text-gray-900">Edit Category</h3>
                                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label for="category_name"
                                            class="block text-sm font-medium text-gray-700">Category Name</label>
                                        <input type="text" name="name" id="category_name"
                                            value="{{ $category->name }}" required
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Category Modal -->
                <div id="popup-modal-{{ $category->id }}" tabindex="-1"
                    class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" data-modal-hide="popup-modal-{{ $category->id }}"
                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M6 4.293a1 1 0 011.414 0L10 7.586l2.586-2.586a1 1 0 111.414 1.414L11.414 9l2.586 2.586a1 1 0 11-1.414 1.414L10 10.414l-2.586 2.586a1 1 0 11-1.414-1.414L8.586 9 6 6.414a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="p-6 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want
                                    to delete this
                                    category?</h3>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button data-modal-hide="popup-modal-{{ $category->id }}" type="submit"
                                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:bg-red-700">Yes,
                                        delete</button>
                                    <button data-modal-hide="popup-modal-{{ $category->id }}" type="button"
                                        class="ml-4 px-4 py-2 bg-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:bg-gray-300">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subcategory List -->
                @foreach ($category->subcategories as $subcategory)
                    <!-- Edit Subcategory Modal -->
                    <div id="edit-subcategory-modal-{{ $subcategory->id }}" tabindex="-1"
                        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" data-modal-hide="edit-subcategory-modal-{{ $subcategory->id }}"
                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M6 4.293a1 1 0 011.414 0L10 7.586l2.586-2.586a1 1 0 111.414 1.414L11.414 9l2.586 2.586a1 1 0 11-1.414 1.414L10 10.414l-2.586 2.586a1 1 0 11-1.414-1.414L8.586 9 6 6.414a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div class="px-6 py-6 lg:px-8">
                                    <h3 class="mb-4 text-xl font-medium text-gray-900">Edit Subcategory</h3>
                                    <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label for="subcategory_name"
                                                class="block text-sm font-medium text-gray-700">Subcategory
                                                Name</label>
                                            <input type="text" name="name" id="subcategory_name"
                                                value="{{ $subcategory->name }}" required
                                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                        <div class="flex items-center justify-end">
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Subcategory Modal -->
                    <div id="popup-delete-subcategory{{ $subcategory->id }}" tabindex="-1"
                        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" data-modal-hide="popup-delete-subcategory{{ $subcategory->id }}"
                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M6 4.293a1 1 0 011.414 0L10 7.586l2.586-2.586a1 1 0 111.414 1.414L11.414 9l2.586 2.586a1 1 0 11-1.414 1.414L10 10.414l-2.586 2.586a1 1 0 11-1.414-1.414L8.586 9 6 6.414a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div class="p-6 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you
                                        want to delete
                                        this subcategory?</h3>
                                    <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:bg-red-700">Yes,
                                            delete</button>
                                        <button data-modal-hide="popup-delete-subcategory{{ $subcategory->id }}"
                                            type="button"
                                            class="ml-4 px-4 py-2 bg-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:bg-gray-300">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach



        </div>
    </div>
@endsection
