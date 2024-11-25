<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Links List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('message'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('links.create') }}"
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add New
                            Link</a>
                    </div>

                    <table class="table-auto w-full mt-4 border">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">URL</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($links as $link)
                            <tr>
                                <td class="border px-4 py-2">{{ $link->title }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ $link->url }}" target="_blank"
                                       class="text-blue-400 underline underline-offset-3 decoration-blue-200">{{ $link->url }}</a>
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('links.edit', $link->id) }}"
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded">Edit</a>
                                    <form action="{{ route('links.destroy', $link->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $links->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
