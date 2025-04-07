<!-- Hero Section -->
<section class="hero bg-dark text-white py-5">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="display-text mb-4">Build your fan base and music career</h1>
            <p class="lead mb-5">Create beautiful smart links for your music across all platforms with just one link.</p>
            <?php if (isset($authController) && $authController->isLoggedIn()): ?>
                <a href="/dashboard/create" class="btn btn-primary btn-lg">Create Your Smart Link</a>
            <?php else: ?>
                <a href="/register" class="btn btn-primary btn-lg">Start for Free</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Brand logos -->
    <div class="container mt-5">
        <div class="platform-logos text-center">
            <div class="row justify-content-center mt-4">
                <div class="col-auto px-3 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-spotify" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.669 11.538a.498.498 0 0 1-.686.165c-1.879-1.147-4.243-1.407-7.028-.77a.499.499 0 0 1-.222-.973c3.048-.696 5.662-.397 7.77.892a.5.5 0 0 1 .166.686zm.979-2.178a.624.624 0 0 1-.858.205c-2.15-1.321-5.428-1.704-7.972-.932a.625.625 0 0 1-.362-1.194c2.905-.881 6.517-.454 8.986 1.063a.624.624 0 0 1 .206.858zm.084-2.268C10.154 5.56 5.9 5.419 3.438 6.166a.748.748 0 1 1-.434-1.432c2.825-.857 7.523-.692 10.492 1.07a.747.747 0 1 1-.764 1.288z"/>
                    </svg>
                </div>
                <div class="col-auto px-3 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-apple" viewBox="0 0 16 16">
                        <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43Zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282Z"/>
                        <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43Zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282Z"/>
                    </svg>
                </div>
                <div class="col-auto px-3 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-youtube" viewBox="0 0 16 16">
                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                    </svg>
                </div>
                <div class="col-auto px-3 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                        <path d="M12.012 3.992L8.008 7.996 4.004 3.992 0 7.996 4.004 12l4.004-4.004L12.012 12l-4.004 4.004L12.012 20l4.004-4.004L20.02 20l3.972-4.004L20.02 12l-4.004 4.004L12.012 12l4.004-4.004-4.004-4.004z"/>
                    </svg>
                </div>
                <div class="col-auto px-3 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                        <path d="M18.81 4.16v3.03H24V4.16m-18.818 0v3.03h5.197V4.16m-5.197 4.57v3.03h5.189V8.73m12.627 0v3.03H24V8.73m-12.62 0v3.03h5.195V8.73M0 13.35v3.022h5.189v-3.03m6.315 0v3.022h5.195v-3.03m6.308 0v3.022H24v-3.03m-18.81 4.56v3.03h5.189v-3.03m6.315 0v3.03h5.195v-3.03"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2>For every thing you do</h2>
            <p class="lead">Marketing tools built specifically for music promotion</p>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
                    <div class="position-absolute end-0 top-0 p-2">
                        <span class="badge bg-warning text-dark">Coming Soon</span>
                    </div>
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                    </div>
                    <h3>Artist Bio Links</h3>
                    <p>Connect fans to all of your content with a single link in bio.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
                    <div class="position-absolute end-0 top-0 p-2">
                        <span class="badge bg-warning text-dark">Coming Soon</span>
                    </div>
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 18V5l12-2v13"></path>
                            <circle cx="6" cy="18" r="3"></circle>
                            <circle cx="18" cy="16" r="3"></circle>
                        </svg>
                    </div>
                    <h3>Pre-Save Links</h3>
                    <p>Build momentum ahead of your music release.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 border-primary">
                    <div class="position-absolute end-0 top-0 p-2">
                        <span class="badge bg-success">Available Now</span>
                    </div>
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <h3>Release Links</h3>
                    <p>Get more streams with links to your music in all services.</p>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
                    <div class="position-absolute end-0 top-0 p-2">
                        <span class="badge bg-warning text-dark">Coming Soon</span>
                    </div>
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <h3>Contest & Unlock Pages</h3>
                    <p>Reward your fans with prizes for taking actions you want.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
                    <div class="position-absolute end-0 top-0 p-2">
                        <span class="badge bg-warning text-dark">Coming Soon</span>
                    </div>
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                    <h3>Tour and Event Links</h3>
                    <p>Sell more tickets to shows with a link to all your dates.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
                    <div class="position-absolute end-0 top-0 p-2">
                        <span class="badge bg-warning text-dark">Coming Soon</span>
                    </div>
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3z"></path>
                            <path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                        </svg>
                    </div>
                    <h3>Podcast Links</h3>
                    <p>Drive listeners to your Podcast with links to all platforms.</p>
                </div>
            </div>
        </div>
    </div>
</section> 2 0 0 1 2-2h3z"></path>
                            <path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2

<!-- Fan Management Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="coming-soon-container">
                    <span class="badge bg-warning text-dark">Coming Soon</span>
                    <h2>Your fans are your most valuable asset</h2>
                </div>
                <p class="lead mb-4">Fan Base Management</p>
                <p class="mb-4">Know who your fans are and contact them directly with dozens of ways to collect, organize and sync fan contact info.</p>
                <a href="/register" class="btn btn-primary">Deepen fan relationships</a>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <!-- Replace image with an icon -->
                    <div class="p-5 d-flex justify-content-center align-items-center bg-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" class="bi bi-people text-primary" viewBox="0 0 16 16">
                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Analytics Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <div class="coming-soon-container">
                    <span class="badge bg-warning text-dark">Coming Soon</span>
                    <h2>Know what works and use it to grow</h2>
                </div>
                <p class="lead mb-4">Analytics and Insights</p>
                <p class="mb-4">Track fan behaviors across your links, get artist level insights and send it all to your ad retargeting platforms.</p>
                <a href="/register" class="btn btn-primary">Grow with fan insights</a>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="card">
                    <!-- Replace image with an icon -->
                    <div class="p-5 d-flex justify-content-center align-items-center bg-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" class="bi bi-bar-chart text-primary" viewBox="0 0 16 16">
                            <path d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Example Smart Link -->
<section class="bg-dark py-5 text-center text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">There is no better time in history to be an artist</h2>
                <div class="row align-items-center mt-5">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="testimonial">
                            <p class="lead font-italic">"It's quick, easy, and accessible for people to check out my music!"</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="smart-link-example">
                            <!-- Example smart link card -->
                            <div class="card bg-dark text-white border border-light">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-music-note-beamed" viewBox="0 0 16 16">
                                            <path d="M6 13c0 1.105-1.12 2-2.5 2S1 14.105 1 13c0-1.104 1.12-2 2.5-2s2.5.896 2.5 2zm9-2c0 1.105-1.12 2-2.5 2s-2.5-.895-2.5-2 1.12-2 2.5-2 2.5.895 2.5 2z"/>
                                            <path fill-rule="evenodd" d="M14 11V2h1v9h-1zM6 3v10H5V3h1z"/>
                                            <path d="M5 2.905a1 1 0 0 1 .9-.995l8-.8a1 1 0 0 1 1.1.995V3L5 4V2.905z"/>
                                        </svg>
                                    </div>
                                    <h5>Smart Link Example</h5>
                                    <p class="small mb-4">Click to listen on your favorite platform</p>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-light">Spotify</button>
                                        <button class="btn btn-outline-light">Apple Music</button>
                                        <button class="btn btn-outline-light">YouTube Music</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Simple Pricing</h2>
            <p class="lead">Start free and upgrade when you need more</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card h-100">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h3 class="mb-4">Free</h3>
                            <p class="text-muted mb-4">Perfect for new artists just getting started</p>
                            <h2 class="display-4 mb-4">$0</h2>
                            <p class="text-muted mb-5">Forever</p>
                        </div>
                        <ul class="list-unstyled mb-5">
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Up to 3 smart links
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Basic analytics (7-day retention)
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Modern, responsive design
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="/register" class="btn btn-outline-primary btn-lg w-100">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5 mb-4">
                <div class="card h-100 border-primary">
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-primary">POPULAR</span>
                    </div>
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h3 class="mb-4">Premium</h3>
                            <p class="text-muted mb-4">For serious artists who want more</p>
                            <h2 class="display-4 mb-4">$12</h2>
                            <p class="text-muted mb-5">per year</p>
                        </div>
                        <ul class="list-unstyled mb-5">
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Unlimited smart links
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Advanced analytics (unlimited retention)
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Modern, responsive design
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Custom background options
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Priority support
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="/register" class="btn btn-primary btn-lg w-100">Start Free Trial</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h2 class="mb-4">Start building your smart links today</h2>
        <p class="lead mb-5">Join thousands of artists already marketing themselves with JAE Smartlink</p>
        <a href="/register" class="btn btn-light btn-lg">Get Started for Free</a>
    </div>
</section>