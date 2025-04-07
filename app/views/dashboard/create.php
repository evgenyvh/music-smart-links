<<<<<<< Tabnine <<<<<<<
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

<div class="dashboard-container py-4">
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Smart Link</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0">Create New Smart Link</h1>
        </div>
        <div class="card-body p-4">
            <form action="/dashboard/create" method="POST" id="smartLinkForm">
                <div x-data="{
                    loading: false,
                    fetchingLinks: false,
                    metadata: null,
                    artworkUrl: '',
                    title: '',
                    artistName: '',
                    platforms: [],
                    platformsMap: <?= json_encode(array_reduce($musicPlatforms, function($result, $item) {
                        $result[$item['id']] = $item;
                        return $result;
                    }, [])) ?>,

                    addPlatform(platformId, platformUrl) {
                        const exists = this.platforms.some(p => p.platformId === platformId);
                        if (!exists) {
                            this.platforms.push({
                                platformId: platformId,
                                platformUrl: platformUrl
                            });
                        }
                    },

                    removePlatform(index) {
                        this.platforms.splice(index, 1);
                    },

                    autoFetchLinks() {
                        const spotifyUrl = document.getElementById('spotify_url').value;
                        if (!spotifyUrl) {
                            alert('Please enter a Spotify URL first');
                            return;
                        }

                        this.fetchingLinks = true;

                        fetch('/api.php?endpoint=find-matching-links', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ spotify_url: spotifyUrl })
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.fetchingLinks = false;

                            if (data.success && data.links && data.links.length > 0) {
                                // Add Spotify as the first platform
                                this.platforms = [{
                                    platformId: 1,
                                    platformUrl: spotifyUrl
                                }];

                                // Add other platforms
                                data.links.forEach(link => {
                                    this.addPlatform(link.platform_id, link.platform_url);
                                });

                                alert(`Found ${data.links.length} matching links on other platforms!`);
                            } else {
                                alert('No matching links found on other platforms. Please add them manually.');
                                if (this.platforms.length === 0) {
                                    this.platforms = [{
                                        platformId: 1,
                                        platformUrl: spotifyUrl
                                    }];
                                }
                            }
                        })
                        .catch(error => {
                            this.fetchingLinks = false;
                            console.error('Error:', error);
                            alert('An error occurred while searching for matching links. Please add them manually.');

                            if (this.platforms.length === 0) {
                                this.platforms = [{
                                    platformId: 1,
                                    platformUrl: spotifyUrl
                                }];
                            }
                        });
                    }
                }">
                    <!-- Step 1: Enter Spotify URL -->
                    <h2 class="h5 mb-3">Step 1: Enter Spotify URL</h2>
                    <div class="mb-4">
                        <label for="spotify_url" class="form-label">Spotify Link <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="url" id="spotify_url" name="spotify_url" required 
                                   class="form-control" 
                                   placeholder="https://open.spotify.com/track/..." 
                                   x-on:input="artworkUrl = ''; title = ''; artistName = ''">
                            <button type="button" 
                                    class="btn btn-primary"
                                    x-on:click="
                                        loading = true;
                                        fetch('/api.php?endpoint=extract-metadata', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({ spotify_url: document.getElementById('spotify_url').value })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            loading = false;
                                            if (data.success) {
                                                metadata = data.metadata;
                                                artworkUrl = metadata.artwork_url;
                                                title = metadata.title;
                                                artistName = metadata.artist_name;
                                                document.getElementById('title').value = title;
                                                document.getElementById('artist_name').value = artistName;
                                                document.getElementById('artwork_url').value = artworkUrl;

                                                // Auto fetch links after metadata is extracted
                                                autoFetchLinks();
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
                                <span x-show="!loading">Extract Metadata</span>
                                <span x-show="loading">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="visually-hidden">Loading...</span>
                                </span>
                            </button>
                        </div>
                        <div class="mt-2">
                            <button type="button" 
                                    class="btn btn-outline-primary btn-sm"
                                    x-on:click="autoFetchLinks()"
                                    x-bind:disabled="loading || fetchingLinks">
                                <span x-show="!fetchingLinks">Auto-find links on other platforms</span>
                                <span x-show="fetchingLinks">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Searching for links...
                                </span>
                            </button>
                            <small class="form-text">Automatically search for this track on other music platforms</small>
                        </div>
                        <div class="form-text">Enter a Spotify link to your track, album, or playlist.</div>
                    </div>

                    <!-- Step 2: Basic Information -->
                    <h2 class="h5 mb-3">Step 2: Basic Information</h2>
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" required 
                                       class="form-control"
                                       placeholder="My Awesome Track"
                                       x-model="title">
                            </div>

                            <div class="mb-3">
                                <label for="artist_name" class="form-label">Artist Name</label>
                                <input type="text" id="artist_name" name="artist_name" 
                                       class="form-control"
                                       placeholder="Artist Name"
                                       x-model="artistName">
                            </div>

                            <div class="mb-3">
                                <label for="artwork_url" class="form-label">Artwork URL</label>
                                <input type="url" id="artwork_url" name="artwork_url" 
                                       class="form-control"
                                       placeholder="https://example.com/artwork.jpg"
                                       x-model="artworkUrl">
                                <div class="form-text">Leave empty to use artwork from Spotify (if available).</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Artwork Preview</label>
                            <div class="border rounded p-2 d-flex align-items-center justify-content-center" style="height: 200px; background-color: #f8f9fa;">
                                <template x-if="artworkUrl">
                                    <img :src="artworkUrl" alt="Artwork preview" class="img-fluid" style="max-height: 180px; max-width: 100%;">
                                </template>
                                <template x-if="!artworkUrl">
                                    <div class="text-center text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-image mb-2" viewBox="0 0 16 16">
                                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                        </svg>
                                        <p>No artwork</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Platform Links -->
                    <h2 class="h5 mb-3">Step 3: Add Music Platform Links</h2>
                    <div class="mb-4">
                        <template x-for="(platform, index) in platforms" :key="index">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-5">
                                    <select :name="'platform[' + index + ']'" class="form-select" x-model="platform.platformId">
                                        <option value="">Select Platform</option>
                                        <?php foreach ($musicPlatforms as $platform): ?>
                                            <option value="<?= $platform['id'] ?>"><?= htmlspecialchars($platform['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <input type="url" :name="'platform_url[' + index + ']'" class="form-control" placeholder="https://" x-model="platform.platformUrl">
                                </div>

                                <div class="col-md-1">
                                    <button type="button" class="btn btn-outline-danger" @click="removePlatform(index)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <button type="button" class="btn btn-outline-primary" @click="addPlatform('', '')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg me-2" viewBox="0 0 16 16">
                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                            </svg>
                            Add Platform Link
                        </button>

                        <div class="mt-3 text-muted">
                            <small>Don't see a platform you need? <a href="#" class="text-decoration-none">Request a new platform</a></small>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="border-top pt-4 mt-4 d-flex justify-content-between">
                        <a href="/dashboard" class="btn btn-outline-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg me-2" viewBox="0 0 16 16">
                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                            </svg>
                            Create Smart Link
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include BASE_PATH . '/app/views/layout.php';
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('smartLinkForm');

    if (form) {
        form.addEventListener('submit', function(e) {
            // Prevent default submission
            e.preventDefault();

            // Validate form
            let isValid = true;
            const spotifyUrl = document.getElementById('spotify_url').value;
            const title = document.getElementById('title').value;

            if (!spotifyUrl) {
                alert('Spotify URL is required');
                isValid = false;
            }

            if (!title) {
                alert('Title is required');
                isValid = false;
            }

            // Check if at least one platform link is added
            const platforms = document.querySelectorAll('select[name^="platform["]');
            const platformUrls = document.querySelectorAll('input[name^="platform_url["]');

            let hasPlatformLinks = false;
            for (let i = 0; i < platforms.length; i++) {
                if (platforms[i].value && platformUrls[i].value) {
                    hasPlatformLinks = true;
                    break;
                }
            }

            if (!hasPlatformLinks) {
                // Just log a warning, don't block submission
                console.warn('No platform links added');
            }

            if (isValid) {
                // Log form data for debugging
                console.log('Submitting form with data:', new FormData(form));

                // Submit the form
                form.submit();
            }
        });
    }
});
</script>
>>>>>>> Tabnine >>>>>>>// {"source":"chat"}