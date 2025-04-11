<?php
$pageTitle = 'Create Smart Link - Music Smart Links';

// Debug any form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('CREATE FORM POST DATA: ' . json_encode($_POST));
    echo "<div style='background-color:#f8f9fa;border:1px solid #ddd;padding:15px;margin-bottom:20px'>";
    echo "<h4>POST Data Received:</h4>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo "</div>";
}

ob_start();

// Load music platforms from database
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

// Get form data from session if form was previously submitted with errors
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);
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
            <!-- Display any error messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="/dashboard/create" method="POST" id="smartLinkForm">
                <!-- Step 1: Enter Spotify URL -->
                <h2 class="h5 mb-3">Step 1: Enter Spotify URL</h2>
                <div class="mb-4">
                    <label for="spotify_url" class="form-label">Spotify Link <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="url" id="spotify_url" name="spotify_url" required class="form-control" 
                            placeholder="https://open.spotify.com/track/..." 
                            value="<?= htmlspecialchars($formData['spotify_url'] ?? '') ?>">
                        <button type="button" id="extract-button" class="btn btn-primary">
                            Extract Metadata
                        </button>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="autoSearch" name="autoSearch" checked>
                        <label class="form-check-label" for="autoSearch">
                            Automatically search for this track on other music platforms
                        </label>
                    </div>
                    <div class="form-text">Enter a Spotify link to your track, album, or playlist.</div>
                </div>

                <!-- Step 2: Basic Information -->
                <h2 class="h5 mb-3">Step 2: Basic Information</h2>
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" required class="form-control"
                                   placeholder="My Awesome Track"
                                   value="<?= htmlspecialchars($formData['title'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="artist_name" class="form-label">Artist Name</label>
                            <input type="text" id="artist_name" name="artist_name" class="form-control"
                                   placeholder="Artist Name"
                                   value="<?= htmlspecialchars($formData['artist_name'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="artwork_url" class="form-label">Artwork URL</label>
                            <input type="url" id="artwork_url" name="artwork_url" class="form-control"
                                   placeholder="https://example.com/artwork.jpg"
                                   value="<?= htmlspecialchars($formData['artwork_url'] ?? '') ?>">
                            <div class="form-text">Leave empty to use artwork from Spotify (if available).</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Artwork Preview</label>
                        <div id="artwork-preview" class="border rounded p-2 d-flex align-items-center justify-content-center" style="height: 200px; background-color: #f8f9fa;">
                            <div class="text-center text-muted" id="no-artwork">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-image mb-2" viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                </svg>
                                <p>No artwork</p>
                            </div>
                            <?php if (!empty($formData['artwork_url'])): ?>
                                <img src="<?= htmlspecialchars($formData['artwork_url']) ?>" id="artwork-img" alt="Artwork preview" class="img-fluid" style="max-height: 180px; max-width: 100%; display: block;">
                            <?php else: ?>
                                <img src="" id="artwork-img" alt="Artwork preview" class="img-fluid" style="max-height: 180px; max-width: 100%; display: none;">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Platform Links -->
                <h2 class="h5 mb-3">Step 3: Add Music Platform Links</h2>
                <div class="mb-4" id="platform-container">
                    <!-- Initial platform row - Spotify (always present) -->
                    <div class="row mb-3 align-items-center platform-row">
                        <div class="col-md-5">
                            <select name="platform[0]" class="form-select platform-select">
                                <option value="">Select Platform</option>
                                <?php foreach ($musicPlatforms as $platform): ?>
                                    <option value="<?= $platform['id'] ?>" <?= (isset($formData['platform'][0]) && $formData['platform'][0] == $platform['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($platform['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <input type="url" name="platform_url[0]" class="form-control platform-url" 
                                placeholder="https://" 
                                value="<?= htmlspecialchars($formData['platform_url'][0] ?? '') ?>">
                        </div>

                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger remove-platform">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-platform" class="btn btn-outline-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg me-2" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Add Platform Link
                </button>

                <div class="mt-3 text-muted">
                    <small>Don't see a platform you need? <a href="#" class="text-decoration-none">Request a new platform</a></small>
                </div>

                <!-- Form Actions -->
                <div class="border-top pt-4 mt-4 d-flex justify-content-between">
                    <a href="/dashboard" class="btn btn-outline-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary" id="submitButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg me-2" viewBox="0 0 16 16">
                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                        </svg>
                        Create Smart Link
                    </button>
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
    const submitButton = document.getElementById('submitButton');
    const platformContainer = document.getElementById('platform-container');
    const addPlatformButton = document.getElementById('add-platform');
    const extractButton = document.getElementById('extract-button');
    const artworkPreview = document.getElementById('artwork-preview');
    const artworkImg = document.getElementById('artwork-img');
    const noArtwork = document.getElementById('no-artwork');
    const artworkUrlInput = document.getElementById('artwork_url');
    
    // Update artwork preview when URL changes
    artworkUrlInput.addEventListener('input', function() {
        const url = this.value.trim();
        if (url) {
            artworkImg.src = url;
            artworkImg.style.display = 'block';
            noArtwork.style.display = 'none';
        } else {
            artworkImg.style.display = 'none';
            noArtwork.style.display = 'block';
        }
    });
    
    // Add platform row
    addPlatformButton.addEventListener('click', function() {
        const platformRows = document.querySelectorAll('.platform-row');
        const newIndex = platformRows.length;
        
        const newRow = document.createElement('div');
        newRow.className = 'row mb-3 align-items-center platform-row';
        newRow.innerHTML = `
            <div class="col-md-5">
                <select name="platform[${newIndex}]" class="form-select platform-select">
                    <option value="">Select Platform</option>
                    <?php foreach ($musicPlatforms as $platform): ?>
                        <option value="<?= $platform['id'] ?>"><?= htmlspecialchars($platform['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <input type="url" name="platform_url[${newIndex}]" class="form-control platform-url" placeholder="https://">
            </div>

            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger remove-platform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                    </svg>
                </button>
            </div>
        `;
        
        platformContainer.appendChild(newRow);
        
        // Add event listener to the new remove button
        newRow.querySelector('.remove-platform').addEventListener('click', function() {
            newRow.remove();
            updatePlatformIndices();
        });
    });
    
    // Remove platform row
    document.querySelectorAll('.remove-platform').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.platform-row').remove();
            updatePlatformIndices();
        });
    });
    
    // Update platform indices when rows are removed
    function updatePlatformIndices() {
        const platformRows = document.querySelectorAll('.platform-row');
        platformRows.forEach((row, index) => {
            row.querySelector('.platform-select').name = `platform[${index}]`;
            row.querySelector('.platform-url').name = `platform_url[${index}]`;
        });
    }
    
    // Extract metadata from Spotify URL
    extractButton.addEventListener('click', function() {
        const spotifyUrl = document.getElementById('spotify_url').value.trim();
        if (!spotifyUrl) {
            alert('Please enter a Spotify URL');
            return;
        }
        
        // Show loading state
        extractButton.disabled = true;
        extractButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        
        // Call the API to extract metadata
        fetch('/api/extract-metadata', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'spotify_url=' + encodeURIComponent(spotifyUrl)
        })
        .then(response => response.json())
        .then(data => {
            // Reset button state
            extractButton.disabled = false;
            extractButton.innerHTML = 'Extract Metadata';
            
            if (data.success) {
                // Update form fields with metadata
                if (data.data) {
                    document.getElementById('title').value = data.data.title || '';
                    document.getElementById('artist_name').value = data.data.artist_name || '';
                    
                    if (data.data.artwork_url) {
                        document.getElementById('artwork_url').value = data.data.artwork_url;
                        artworkImg.src = data.data.artwork_url;
                        artworkImg.style.display = 'block';
                        noArtwork.style.display = 'none';
                    }
                }
                
                // Add Spotify as the first platform if empty
                const firstPlatformSelect = document.querySelector('.platform-select');
                const firstPlatformUrl = document.querySelector('.platform-url');
                
                if (!firstPlatformSelect.value) {
                    firstPlatformSelect.value = '1'; // Spotify ID
                }
                
                if (!firstPlatformUrl.value) {
                    firstPlatformUrl.value = spotifyUrl;
                }
                
                // If auto-search is checked, find matching links
                if (document.getElementById('autoSearch').checked) {
                    findMatchingLinks(spotifyUrl);
                }
            } else {
                alert('Error extracting metadata: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            // Reset button state
            extractButton.disabled = false;
            extractButton.innerHTML = 'Extract Metadata';
            
            console.error('Error:', error);
            alert('An error occurred while extracting metadata.');
        });
    });
    
    // Find matching links on other platforms
    function findMatchingLinks(spotifyUrl) {
        if (!spotifyUrl) return;
        
        // Call the API to find matching links
        fetch('/api/find-matching-links', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'spotify_url=' + encodeURIComponent(spotifyUrl)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.links && data.links.length > 0) {
                // Get existing platform IDs
                const existingPlatforms = Array.from(document.querySelectorAll('.platform-select'))
                    .map(select => select.value);
                
                // Process the links
                data.links.forEach(link => {
                    const platformId = link.platform_id.toString();
                    
                    // Check if this platform is already added
                    if (!existingPlatforms.includes(platformId)) {
                        // Add a new platform row
                        addPlatformButton.click();
                        
                        // Get the newly added row
                        const rows = document.querySelectorAll('.platform-row');
                        const newRow = rows[rows.length - 1];
                        
                        // Set the platform and URL
                        newRow.querySelector('.platform-select').value = platformId;
                        newRow.querySelector('.platform-url').value = link.platform_url;
                        
                        // Add to existing platforms list
                        existingPlatforms.push(platformId);
                    }
                });
                
                console.log('Added platform links:', data.links);
            } else {
                console.log('No matching links found or error:', data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Don't show alert for this as it's not critical
        });
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            // Log form submission
            console.log('Form submit event triggered');
            
            // Validate required fields
            const spotifyUrl = document.getElementById('spotify_url').value.trim();
            const title = document.getElementById('title').value.trim();
            
            if (!spotifyUrl) {
                e.preventDefault();
                alert('Please enter a Spotify URL');
                return false;
            }
            
            if (!title) {
                e.preventDefault();
                alert('Please enter a title');
                return false;
            }
            
            // Add loading state to button
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...';
            }
            
            // Log form data
            console.log('Form data being submitted:');
            const formData = new FormData(form);
            for (const pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            return true;
        });
    }
});
</script>