<!DOCTYPE html>
<html>
<head>
    <title>Activity Logger Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Activity Logger Demo</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">{{ session('info') }}</div>
        @endif

        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('logs.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-medium">View Logs</a>
            <a href="{{ route('logs.manual') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm font-medium">Manual Log</a>
            <a href="{{ route('logs.create-post') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm font-medium">Create Post</a>
            <a href="{{ route('logs.update-post') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm font-medium">Update Post</a>
            <a href="{{ route('logs.delete-post') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-medium">Delete Post</a>
            <a href="{{ route('logs.clear') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm font-medium">Clear Logs</a>
        </div>

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-4 py-3 font-semibold">ID</th>
                        <th class="px-4 py-3 font-semibold">Action</th>
                        <th class="px-4 py-3 font-semibold">Description</th>
                        <th class="px-4 py-3 font-semibold">Loggable</th>
                        <th class="px-4 py-3 font-semibold">User</th>
                        <th class="px-4 py-3 font-semibold">IP</th>
                        <th class="px-4 py-3 font-semibold">Metadata</th>
                        <th class="px-4 py-3 font-semibold">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $log->id }}</td>
                            <td class="px-4 py-3"><span class="bg-gray-200 rounded px-2 py-0.5 text-xs font-mono">{{ $log->action }}</span></td>
                            <td class="px-4 py-3">{{ $log->description }}</td>
                            <td class="px-4 py-3 text-xs text-gray-500">{{ $log->loggable_type ? class_basename($log->loggable_type) . '#' . $log->loggable_id : '-' }}</td>
                            <td class="px-4 py-3">{{ $log->user_id ?? '-' }}</td>
                            <td class="px-4 py-3 text-xs font-mono">{{ $log->ip_address ?? '-' }}</td>
                            <td class="px-4 py-3 text-xs">{{ $log->metadata ? json_encode($log->metadata) : '-' }}</td>
                            <td class="px-4 py-3 text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">No activity logs yet. Click one of the buttons above to generate logs!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->count())
            <p class="text-xs text-gray-400 mt-2">Total log entries: {{ $logs->count() }}</p>
        @endif
    </div>
</body>
</html>
