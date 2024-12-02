<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Images') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <!-- Add Image Button -->
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('images.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Add</a>
                    <a href="{{ route('transformation.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Transformed List</a>
                </div>


                <!-- Table -->
                <table class="table-auto w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">#</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Image</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">User Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">IP</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Browser Details</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample row -->
                        @foreach ($images as $image )
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{$loop->iteration}}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <img src="{{ asset('images/'.$image->image)}}" alt="User Image" class="w-12 h-12 rounded-full">
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{$image->user_id}}</td>
                            <td class="border border-gray-300 px-4 py-2">{{$image->ip_address}}</td>
                            <td class="border border-gray-300 px-4 py-2">{{$image->browser}}</td>
                            <td class="border border-gray-300 px-4 py-2 ">
                                <div class="inline-flex gap-2">

                                    {{-- <a href="{{ route('transformation.create')}}" class="inline-flex items-center px-4 py-2 bg-green-800  border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Transform</a> --}}
                                    <a href="{{ route('images.edit',$image->id)}}" class="inline-flex items-center px-4 py-2 bg-blue-800  border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Edit</a>

                                    <form action="{{ route('images.destroy',$image->id)}}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block items-center px-4 py-2 bg-red-600  border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
