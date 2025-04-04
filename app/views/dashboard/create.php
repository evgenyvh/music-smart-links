<?php
$pageTitle = 'Create Smart Link - Music Smart Links';
ob_start();

// Load music platforms from database (this would need to be implemented)
// For now, we'll use hardcoded platforms for demonstration
$musicPlatforms = [
    ['id' => 1, 'name' => 'Spotify', 'icon' => 'spotify-icon.png', 'base_url' => 'https://open.spotify.com/'],
    ['id' => 2, 'name' => 'Apple Music', 'icon' => 'apple-music-icon.png', 'base_url' => 'https://music.apple.com/'],
    ['id' => 3, 'name' => 'YouTube Music', 'icon' => 'youtube-music-icon.png', 'base_url' => 'https://music.youtube.com/'],
    ['id' => 4, 'name' => 'Amazon Music', 'icon' => 'amazon-music-icon.png', 'base_url' => 'https://music.amazon.com/'],
    ['id' => 5, 'name' => 'Tidal', 'icon' => 'tidal-icon.png', 'base_url' => 'https://tidal.com/'],
    ['id' => 6, 'name' => 'Deezer', 'icon' => 'deezer-icon.png', 'base_url' => 'https://www.deezer.com/'],
    ['id' => 7, 'name' => 'SoundCloud', 'icon' => 'soundcloud-icon.png', 'base_url' => 'https://soundcloud.com/'],
    ['id' => 8, 'name' => 'Bandcamp', 'icon' => 'bandcamp-icon.png', 'base_url' => 'https://bandcamp.com/'],
];
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center mb-6">
        <a href="/dashboard" class="text-indigo-600 hover:text-indigo-800 mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold">Create New Smart Link</h1>
    </div>
    
    <form action="/dashboard/create" method="POST" id="smartLinkForm" class="space-y-6">
        <div x-data="{ loading: false, metadata: null, artworkUrl: null, title: '', artistName: '' }">
            <div class="mb-4">
                <label for="spotify_url" class="block text-gray-700 font-bold mb-2">Spotify Link *</label>
                <div class="flex">
                    <input type="url" id="spotify_url" name="spotify_url" required placeholder="https://open.spotify.com/track/..." 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        x-on:input="artworkUrl = null; title = ''; artistName = ''">
                    <button type="button" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-700 transition duration-300"
                        x-on:click="
                            loading = true;
                            fetch('/api/extract-metadata', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: 'spotify_url=' + encodeURIComponent(document.getElementById('spotify_url').value)
                            })
                            .then(response => response.json())
                            .then(data => {
                                loading = false;
                                if (data.success) {
                                    metadata = data.data;
                                    artworkUrl = metadata.artwork_url;
                                    title = metadata.title;
                                    artistName = metadata.artist_name;
                                    document.getElementById('title').value = title;
                                    document.getElementById('artist_name').value = artistName;
                                    document.getElementById('artwork_url').value = artworkUrl;
                                } else {
                                    alert('Could not extract metadata. Please fill in the details manually.');
                                }
                            })
                            .catch(error => {
                                loading = false;
                                console.error('Error:', error);
                                alert('An error occurred. Please fill in the details manually.');
                            })
                        ">
                        <template x-if="!loading">Extract Metadata</template>
                        <template x-if="loading">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                    </button>
                </div>
                <p class="text-sm text-gray-600 mt-1">Enter a Spotify link to your track, album, or playlist.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label for="title" class="block text-gray-700 font-bold mb-2">Title *</label>
                        <input type="text" id="title" name="title" required placeholder="My Awesome Track"
                            x-model="title"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label for="artist_name" class="block text-gray-700 font-bold mb-2">Artist Name</label>
                        <input type="text" id="artist_name" name="artist_name" placeholder="Artist Name"
                            x-model="artistName"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label for="artwork_url" class="block text-gray-700 font-bold mb-2">Artwork URL</label>
                        <input type="url" id="artwork_url" name="artwork_url" placeholder="https://example.com/artwork.jpg"
                            x-model="artworkUrl"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <p class="text-sm text-gray-600 mt-1">Leave empty to use artwork from Spotify (if available).</p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Artwork Preview</label>
                    <div class="border border-gray-300 rounded-lg w-full aspect-square flex items-center justify-center overflow-hidden">
                        <template x-if="artworkUrl">
                            <img :src="artworkUrl" alt="Artwork preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!artworkUrl">
                            <div class="text-gray-400 text-center p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>No artwork</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-xl font-bold mb-4">Music Platform Links</h2>
            
            <div x-data="{ platforms: [] }" class="space-y-4">
                <template x-for="(platform, index) in platforms" :key="index">
                    <div class="flex space-x-4">
                        <div class="w-1/3">
                            <select :name="'platform[' + index + ']'" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Platform</option>
                                <?php foreach ($musicPlatforms as $platform): ?>
                                    <option value="<?= $platform['id'] ?>"><?= htmlspecialchars($platform['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="flex-1">
                            <input type="url" :name="'platform_url[' + index + ']'" placeholder="https://..." 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <button type="button" @click="platforms.splice(index, 1)" 
                                class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-200 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
                
                <button type="button" @click="platforms.push({})" 
                    class="flex items-center text-indigo-600 hover:text-indigo-800 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Platform Link
                </button>
            </div>
            
            <div class="mt-6 text-gray-600">
                <p>Don't see a platform you need? <a href="#" class="text-indigo-600 hover:underline">Request a new platform</a></p>
            </div>
        </div>
        
        <div class="border-t border-gray-200 pt-6 flex justify-between">
            <a href="/dashboard" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                Cancel
            </a>
            
            <button type="submit" class="bg-indigo-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                Create Smart Link
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
include BASE_PATH . '/app/views/layout.php';
