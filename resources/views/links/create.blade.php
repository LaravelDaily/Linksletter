<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('links.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title"
                                   class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('title') }}"
                                   autofocus/>
                            @error('title')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                            <input type="url" name="url" id="url"
                                   class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('url') }}"/>
                            @error('url')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description"
                                      class="form-textarea rounded-md shadow-sm mt-1 block w-full">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                            <input type="text" name="position" id="position"
                                   class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('position') }}"/>
                            @error('position')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
