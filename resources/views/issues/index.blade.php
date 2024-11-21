<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Issues List') }}
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
                        @if($availableLinks)
                            <a href="{{ route('issues.create') }}"
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add New Issue</a>
                        @else
                            <p class="text-red-500">No links available to create a new issue</p>
                        @endif
                    </div>

                    <table class="table-auto w-full mt-4 border">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Subject</th>
                            <th class="px-4 py-2">Links</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Sent At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($issues as $issue)
                            <tr>
                                <td class="border px-4 py-2">{{ $issue->subject }}</td>
                                <td class="border px-4 py-2">{{ $issue->links_count }}</td>
                                <td class="border px-4 py-2">{{ $issue->created_at->format('Y-m-d') }}</td>
                                <td class="border px-4 py-2">{{ $issue->sent_at?->format('Y-m-d') ?? 'Not Sent'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $issues->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
