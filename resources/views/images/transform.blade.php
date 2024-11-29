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
                <div class="grid grid-cols-8">
                    <form class="col-span-6" action="{{ route('transformation.transform') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-4">
                            <label for="image-upload" class="block text-sm font-medium text-gray-700">Upload Image</label>
                            <input type="file" id="image-upload" name="image" class="mt-1 block w-full" accept="image/*" >
                            <input type="hidden" name="action" id="action" value="crop">

                            <input type="hidden" name="rotate" id="rotate" value="0">
                            <input type="hidden" name="flip_horizontal" id="flip_horizontal" value="false">
                            <input type="hidden" name="flip_vertical" id="flip_vertical" value="false">
                            <!-- Hidden field for crop data -->
                            <input type="hidden" name="crop_x" id="crop-x-input">
                            <input type="hidden" name="crop_y" id="crop-y-input">
                            <input type="hidden" name="crop_width" id="crop-width-input">
                            <input type="hidden" name="crop_height" id="crop-height-input">

                            <div class="mt-4">
                                <img id="image-preview" class="h-28 w-auto" style="display:none;">
                            </div>
                        </div>

                        <!-- Hidden field to store the cropped image (base64) -->
                        <input type="hidden" name="cropped_image" id="cropped_image">

                        <div class="mb-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-800 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-4">Submit</button>
                        </div>
                    </form>
                    <div class="col-span-2 p-4 grid gap-4 grid-rows-6 h-full bg-gray-200 block">
                        <button class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="showRotateFlip()">
                            <a href="#">Rotate/Flip</a>
                        </button>

                        <button class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 transition duration-200">
                            <a href="#">Resize</a>
                        </button>
                        <button class="bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600 transition duration-200">
                            <a href="#">Watermark</a>
                        </button>
                        <button class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition duration-200">
                            <a href="#">Compress</a>
                        </button>
                        <button class="bg-pink-500 text-white py-2 px-4 rounded hover:bg-pink-600 transition duration-200">
                            <a href="#">Filter</a>
                        </button>
                    </div>
                    <div id="rotate-flip-section" class="mt-4 mb-4 flex w-max gap-2 hidden">
                        <button id="rotate-left" class="px-2 py-2 bg-yellow-500 text-white rounded">Rotate Left</button>
                        <button id="rotate-right" class="px-2 py-2 bg-yellow-500 text-white rounded">Rotate Right</button>
                        <button id="flip-horizontal" class="px-2 py-2 bg-pink-500 text-white rounded">Flip Horizontal</button>
                        <button id="flip-vertical" class="px-2 py-2 bg-pink-500 text-white rounded">Flip Vertical</button>
                    </div>
                </div>
                <div id="crop-section" class="mt-4 mb-4 flex  gap-2 ">
                    <div id="crop-data" class="inline-flex gap-3 mt-4 text-sm text-gray-700">
                        <p >X: <span id="crop-x">0</span></p>
                        <p>Y: <span id="crop-y">0</span></p>
                        <p>Width: <span id="crop-width">0</span></p>
                        <p>Height: <span id="crop-height">0</span></p>
                    </div>
                </div>
        </div>
    </div>

    <script>
const image = document.getElementById('image-preview');
const cropX = document.getElementById('crop-x');
const cropY = document.getElementById('crop-y');
const cropWidth = document.getElementById('crop-width');
const cropHeight = document.getElementById('crop-height');
const actionInput = document.getElementById('action');

let cropper;

// Event listener to initialize cropper when image is uploaded
document.getElementById('image-upload').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            image.src = e.target.result;
            image.style.display = 'block';
            if (cropper) {
                cropper.destroy(); // Destroy previous cropper instance if it exists
            }
            cropper = new Cropper(image, {
                aspectRatio: 0,
                viewMode: 1,
                rotatable: true,
                minContainerHeight: 250,
                autoCropArea: 1,
                wheelZoomRatio: 0,
                crop(event) {
                    document.getElementById('crop-x').textContent = Math.round(event.detail.x);
                    document.getElementById('crop-y').textContent = Math.round(event.detail.y);
                    document.getElementById('crop-width').textContent = Math.round(event.detail.width);
                    document.getElementById('crop-height').textContent = Math.round(event.detail.height);

                    document.getElementById('crop-x-input').value = Math.round(event.detail.x);
                    document.getElementById('crop-y-input').value = Math.round(event.detail.y);
                    document.getElementById('crop-width-input').value = Math.round(event.detail.width);
                    document.getElementById('crop-height-input').value = Math.round(event.detail.height);
                },
            });
        };
        reader.readAsDataURL(file);
    }
});

let flipX = 1; // Flip state for horizontal
let flipY = 1; // Flip state for vertical
document.getElementById('rotate-left').addEventListener('click', () => {
    if (cropper) {

        let currentRotateValue = parseInt(document.getElementById('rotate').value) || 0; // Get current value or default to 0
        let newRotateValue = currentRotateValue + 10; // Decrease by 10 degrees
        cropper.rotate(-10); // Rotate the image 10 degrees counterclockwise
        document.getElementById('rotate').value = newRotateValue; // Set the rotate field value
    }
});

document.getElementById('rotate-right').addEventListener('click', () => {
    if (cropper) {

        let currentRotateValue = parseInt(document.getElementById('rotate').value) || 0; // Get current value or default to 0
        let newRotateValue = currentRotateValue - 10; // Increase by 10 degrees
        cropper.rotate(10); // Rotate the image 10 degrees clockwise
        document.getElementById('rotate').value = newRotateValue; // Set the rotate field value
    }
});
document.getElementById('flip-horizontal').addEventListener('click', () => {
    if (cropper) {

        flipX = flipX === 1 ? -1 : 1; // Toggle between 1 and -1
        cropper.scaleX(flipX);
        document.getElementById('flip_horizontal').value = flipX === 1 ? 'false' : 'true'; // Set the flip value
    }
});

document.getElementById('flip-vertical').addEventListener('click', () => {
    if (cropper) {

        flipY = flipY === 1 ? -1 : 1; // Toggle between 1 and -1
        cropper.scaleY(flipY);
        document.getElementById('flip_vertical').value = flipY === 1 ? 'false' : 'true'; // Set the flip value
    }
});


function showRotateFlip() {
    // Hide crop section and show rotate/flip section
    document.getElementById('rotate-flip-section').classList.remove('hidden');
}




    </script>
</x-app-layout>
