<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transform') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('images.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Back</a>
                </div>

                <!-- Image Upload and Preview -->
                <div class="mb-4">
                    <label for="image-upload" class="block text-sm font-medium text-gray-700">Upload Image</label>
                    <input type="file" id="image-upload" class="mt-1 block w-full" accept="image/*" onchange="previewImage(event)">
                    <div class="mt-4">
                        <img id="image-preview" class="max-w-full h-auto" style="display:none;">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button id="resize-btn" class="px-4 py-2 bg-blue-500 text-white rounded">Resize</button>
                    <button id="crop-btn" class="px-4 py-2 bg-green-500 text-white rounded">Crop</button>
                    <button id="rotate-btn" class="px-4 py-2 bg-yellow-500 text-white rounded">Rotate</button>
                    <button id="watermark-btn" class="px-4 py-2 bg-purple-500 text-white rounded">Watermark</button>
                    <button id="flip-btn" class="px-4 py-2 bg-pink-500 text-white rounded">Flip</button>
                    <button id="compress-btn" class="px-4 py-2 bg-red-500 text-white rounded">Compress</button>
                    <button id="filter-btn" class="px-4 py-2 bg-gray-500 text-white rounded">Filter</button>
                </div>

                <!-- Additional Inputs -->
                <div id="resize-inputs" class="mt-4" style="display: none;">
                    <label for="resize-width" class="block text-sm font-medium text-gray-700">Width:</label>
                    <input type="number" id="resize-width" class="mt-1 block w-full">
                    <label for="resize-height" class="block text-sm font-medium text-gray-700">Height:</label>
                    <input type="number" id="resize-height" class="mt-1 block w-full">
                </div>

                <div id="watermark-input" class="mt-4" style="display: none;">
                    <label for="watermark-text" class="block text-sm font-medium text-gray-700">Watermark Text:</label>
                    <input type="text" id="watermark-text" class="mt-1 block w-full">
                </div>

                <div id="flip-buttons" class="mt-4" style="display: none;">
                    <button id="flip-horizontal" class="px-4 py-2 bg-blue-400 text-white rounded">Flip Horizontal</button>
                    <button id="flip-vertical" class="px-4 py-2 bg-blue-400 text-white rounded">Flip Vertical</button>
                </div>

                <div id="compress-options" class="mt-4" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700">Compress:</label>
                    <button class="px-4 py-2 bg-blue-400 text-white rounded" data-compress="75">75%</button>
                    <button class="px-4 py-2 bg-blue-400 text-white rounded" data-compress="50">50%</button>
                    <button class="px-4 py-2 bg-blue-400 text-white rounded" data-compress="25">25%</button>
                </div>

                <div id="rotate-control" class="mt-4" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700">Rotate:</label>
                    <div class="flex items-center justify-center">
                        <button class="px-4 py-2 bg-orange-400 text-white rounded">🔄 Rotate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.src = URL.createObjectURL(event.target.files[0]);
            imagePreview.style.display = 'block';
        }

        // Function to hide all dynamic input sections
        function hideAllSections() {
            document.getElementById('resize-inputs').style.display = 'none';
            document.getElementById('rotate-control').style.display = 'none';
            document.getElementById('watermark-input').style.display = 'none';
            document.getElementById('flip-buttons').style.display = 'none';
            document.getElementById('compress-options').style.display = 'none';
        }

        document.getElementById('resize-btn').addEventListener('click', () => {
            hideAllSections();
            document.getElementById('resize-inputs').style.display = 'block';
        });

        document.getElementById('crop-btn').addEventListener('click', () => {
            hideAllSections();
            alert('Implement cropping functionality.');
        });

        document.getElementById('rotate-btn').addEventListener('click', () => {
            hideAllSections();
            document.getElementById('rotate-control').style.display = 'block';
        });

        document.getElementById('watermark-btn').addEventListener('click', () => {
            hideAllSections();
            document.getElementById('watermark-input').style.display = 'block';
        });

        document.getElementById('flip-btn').addEventListener('click', () => {
            hideAllSections();
            document.getElementById('flip-buttons').style.display = 'block';
        });

        document.getElementById('compress-btn').addEventListener('click', () => {
            hideAllSections();
            document.getElementById('compress-options').style.display = 'block';
        });

        document.getElementById('filter-btn').addEventListener('click', () => {
            hideAllSections();
            alert('Implement filter functionality.');
        });
    </script>

</x-app-layout>
