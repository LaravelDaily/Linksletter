<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Issue') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('issues.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="subject" id="subject"
                                   class="form-input rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('subject') }}"
                                   autofocus/>
                            @error('subject')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="header_text" class="block text-sm font-medium text-gray-700">Header Text</label>
                            <textarea name="header_text" id="header_text"
                                      class="form-textarea rounded-md shadow-sm mt-1 block w-full">{{ old('header_text') }}</textarea>
                            <button type="button" onclick="askAi('header')">
                                Ask AI to generate the header
                            </button>
                            @error('header_text')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="footer_text" class="block text-sm font-medium text-gray-700">Footer Text</label>
                            <textarea name="footer_text" id="footer_text"
                                      class="form-textarea rounded-md shadow-sm mt-1 block w-full">{{ old('footer_text') }}</textarea>
                            <button type="button" onclick="askAi('footer')">
                                Ask AI to generate the footer
                            </button>
                            @error('footer_text')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <h2 class="text-xl">Links to be Included</h2>
                            <table class="table-auto w-full mt-4 border">
                                <thead>
                                <tr>
                                    <th class="px-4 py-2">Title</th>
                                    <th class="px-4 py-2">URL</th>
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
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
        <script>
            function askAi(type) {
                fetch('/text-generation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        type,
                        provider: 'OPENAI' // TODO: Once we have multiple providers, we can make this dynamic
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (type === 'header') {
                            document.getElementById('header_text').value = data.text;
                        } else {
                            document.getElementById('footer_text').value = data.text;
                        }
                    });
            }
        </script>
    </div>
</x-app-layout>
