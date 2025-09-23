<div id="news-create-section"
    class="flex-col hidden w-full max-w-[770px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
    <h3 class=" text-left font-bold ">Crear una noticia</h3>
    <form id="create-news-form" data-id="" class="flex flex-col ">

        <label for="create-new-title" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Titulo</label>
        <input id="create-new-title" type="text" name="title"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="create-new-url" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Url de la fuente</label>
        <input id="create-new-url" type="url" name="source_url"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="create-new-description" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Descripción</label>
        <input id="create-new-description" type="text" name="description"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="create-new-category" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Categoria</label>
        <input id="create-new-category" type="text" name="category"
            class="w-full px-4 py-2 rounded-md bg-[#232323] border-[1px] border-gray-500 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#e7452e]">

        <label for="create-new-image" class="block text-gray-300 text-sm font-bold mb-2 mt-4">Imagen</label>
        <input id="create-new-image" type="file" name="image"
            class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer">
        <div class="w-full max-w-xs aspect-square mt-2 rounded overflow-hidden bg-gray-800">
            <img id="create-notice-image-preview" src="" alt="Previsualización de imagen"
                class="w-full h-full object-cover" />
        </div>

        <div class="flex flex-col sm:flex-row mt-8 gap-4">
            <button id="btn-save-create-news" type="submit"
                class="w-full md:w-[200px] px-4 py-2 rounded-md bg-[#e7452e] hover:bg-orange-600 text-white font-semibold transition">
                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Guardar
            </button>
            <button id="btn-cancel-create-news" type="button"
                class="w-full md:w-[200px] px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white font-semibold transition">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Volver
            </button>
        </div>
    </form>


</div>

@push('scripts')
    <script type="module" src="{{ asset('js/noticias/crearNoticias.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const imageInput = document.getElementById("create-new-image");
            const previewImg = document.getElementById("create-notice-image-preview");

            if (imageInput && previewImg) {
                imageInput.addEventListener("change", () => {
                    const file = imageInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewImg.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewImg.src = "";
                    }
                });
            }
        });
    </script>
@endpush
