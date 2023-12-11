<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ingredients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('ingredients.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                   + Create Ingredients
                </a>
            </div>

            <!-- Filtering Form -->
            <form action="{{ route('ingredients.index') }}" method="GET" class="mb-7 flex justify-end">
                <div class="flex items-center">
                    <label for="type" class="mr-2">Filter by Type:</label>
                    <select name="type" id="type" class="border px-8 py-1">
                        <option value="">All</option>
                        <option value="daging" @if(request('type') == 'daging') selected @endif>Daging</option>
                        <option value="sayur" @if(request('type') == 'sayur') selected @endif>Sayur</option>
                        <option value="buah" @if(request('type') == 'buah') selected @endif>Buah</option>
                    </select>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-2 rounded">Filter</button>
                </div>
            </form>

            <div class="bg-white">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border px-6 py-4">ID</th>
                            <th class="border px-6 py-4">Name</th>
                            <th class="border px-6 py-4">Image</th>
                            <th class="border px-6 py-4">Price</th>
                            <th class="border px-6 py-4">Rate</th>
                            <th class="border px-6 py-4">Stock</th>
                            <th class="border px-6 py-4">Types</th>
                            <th class="border px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ingredients as $item)
                            @if (request('type') && strcasecmp(trim($item->types), request('type')) !== 0)
                                @continue
                            @endif
                            <tr>
                                <td class="border px-6 py-4">{{ $item->id }}</td>
                                <td class="border px-6 py-4">{{ $item->name }}</td>
                                <td class="border px-6 py-4">
                                    <img src="{{ $item->picture_path_url }}" alt="{{ $item->name }}" class="mb-2 rounded border border-gray-300 w-20 h-20 object-cover">
                                </td>
                                <td class="border px-6 py-4">{{ number_format($item->price) }}</td>
                                <td class="border px-6 py-4">{{ $item->rate }}</td>
                                <td class="border px-6 py-4">{{ $item->stock }}</td>
                                <td class="border px-6 py-4">{{ $item->types }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('ingredients.edit', $item->id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('ingredients.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        {!!  method_field('delete') . csrf_field() !!}
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            <i class="fas fa-trash-alt mr-2"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border text-center p-5">
                                    Data Tidak Ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="text-center mt-5">
                    {{ $ingredients->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
