<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-8">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data" class="mb-8">
            @csrf
            <div class="mb-4">
                <input type="file" name="image" class="border p-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload Image</button>
        </form>

        <div class="grid grid-cols-3 gap-4">
            @foreach($images as $image)
                <div class="border p-4 rounded">
                    <img src="{{ Storage::url('uploads/' . $image->filename) }}" alt="{{ $image->original_name }}" class="w-full h-48 object-cover mb-2">
                    <p class="text-sm text-gray-600">{{ $image->created_at->format('Y-m-d') }}</p>
                    <form action="{{ route('images.destroy', $image) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 text-sm">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
