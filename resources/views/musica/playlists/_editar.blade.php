<div id="playlist-edit-section" class="flex-col hidden w-full max-w-[900px] p-6 sm:p-8 bg-[#181818] rounded-lg shadow text-white gap-7">
  <h3 class="text-left font-bold text-lg">Editar Playlist</h3>

  <!-- Formulario -->
  <form id="edit-playlist-form" enctype="multipart/form-data" class="flex flex-col gap-5">

    <!-- Título -->
    <div>
      <label for="edit-playlist-title" class="block text-gray-300 text-sm font-bold mb-2">Título</label>
      <input id="edit-playlist-title" name="title" type="text"
        class="w-full px-3 py-2 rounded bg-[#1e1e1e] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#e7452e] text-white"
        required />
    </div>

    <!-- Descripción -->
    <div>
      <label for="edit-playlist-description" class="block text-gray-300 text-sm font-bold mb-2">Descripción</label>
      <textarea id="edit-playlist-description" name="description" rows="3"
        class="w-full px-3 py-2 rounded bg-[#1e1e1e] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#e7452e] text-white"></textarea>
    </div>

    <!-- Imagen portada -->
    <div>
      <label for="edit-playlist-file" class="block text-gray-300 text-sm font-bold mb-2">Portada</label>
      <input id="edit-playlist-file" type="file" name="cover_image_path" accept="image/*"
        class="w-full text-white file:bg-[#e7452e] file:text-white file:font-bold file:px-4 file:py-2 file:border-none file:rounded-md file:cursor-pointer" />

      <!-- Previsualización -->
      <div class="w-full max-w-xs aspect-square mt-2 rounded overflow-hidden bg-gray-800">
        <img id="edit-playlist-image-preview" src="" alt="Previsualización"
          class="w-full h-full object-cover hidden" />
        <div id="edit-playlist-placeholder"
          class="w-full h-full flex items-center justify-center text-gray-500">
          <i class="fa-solid fa-image text-4xl"></i>
        </div>
      </div>
    </div>

    <!-- Canciones en la playlist -->
    <div>
      <h4 class="text-md font-semibold mb-2">Canciones de la playlist</h4>
      <table class="w-full border border-gray-700 rounded text-sm">
        <thead class="bg-[#222] text-gray-400">
          <tr>
            <th class="px-4 py-2 text-left">#</th>
            <th class="px-4 py-2 text-left">Título</th>
            <th class="px-4 py-2 text-left">Artista</th>
            <th class="px-4 py-2 text-center">Acciones</th>
          </tr>
        </thead>
        <tbody id="playlist-songs-table" class="divide-y divide-gray-700">
          <!-- Canciones de la playlist cargadas dinámicamente -->
        </tbody>
      </table>
    </div>

    <!-- Agregar canción -->
    <div class="mt-4">
      <label for="edit-add-song-select" class="block text-gray-300 text-sm font-bold mb-2">Agregar canción</label>
      <select id="edit-add-song-select"
        class="w-full px-3 py-2 rounded bg-[#1e1e1e] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#e7452e] text-white">
        <option value="">Seleccionar canción...</option>
        <!-- Opciones de canciones disponibles se cargan aquí -->
      </select>
      <button id="btn-add-song-to-playlist" type="button"
        class=" px-4 py-2 mt-5 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold transition">
        Agregar canción
      </button>
    </div>

    <!-- Acciones -->
    <div class="flex justify-between gap-4 mt-4">
      <button id="btn-save-edit-playlist" type="submit"
        class="px-4 py-2 bg-[#e7452e] hover:bg-orange-600 text-white rounded-md font-semibold transition">
        Guardar
      </button>
      <button id="btn-cancel-edit-playlist" type="button"
        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-semibold transition">
        Volver
      </button>
    </div>

  </form>
</div>

@push('scripts')
  <script type="module" src="{{ asset('js/musica/playlists/editarPlaylist.js') }}"></script>
@endpush