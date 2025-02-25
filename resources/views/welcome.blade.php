<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Project Management</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100">
            <!-- header -->
            <nav class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-2xl font-semibold text-gray-800">Project Management</h1>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- body -->
            <main class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Projects Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Projects Overview</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attributes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($projects as $project)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $project->name }}</div>
                                                </td>
                                                {{-- Project Status badges --}}
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $project->status === 'done' ? 'bg-green-100 text-green-800' : 
                                                           ($project->status === 'progress' ? 'bg-yellow-100 text-yellow-800' : 
                                                           'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($project->status) }}
                                                    </span>
                                                </td>
                                                {{-- Users Chips --}}
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex space-x-4">
                                                        @foreach($project->users as $user)
                                                            <div class="inline-flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                                                                <span class="text-xs font-medium text-gray-700">
                                                                    {{ strtoupper(substr($user->first_name, 0, 2)) }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                {{-- Attributes (not available on seeded projects) --}}
                                                <td class="px-6 py-4">
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($project->attributes as $attribute)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $attribute->attribute->name }}: {{ $attribute->value }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>


    </body>
</html>