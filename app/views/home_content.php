<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
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
    <div class="container mt-6">
        <div class="platform-logos text-center">
            <div class="row justify-content-center mt-5">
                <div class="col-auto px-4 py-3"><img src="/images/platforms/spotify.svg" alt="Spotify" height="40"></div>
                <div class="col-auto px-4 py-3"><img src="/images/platforms/apple-music.svg" alt="Apple Music" height="40"></div>
                <div class="col-auto px-4 py-3"><img src="/images/platforms/youtube.svg" alt="YouTube" height="40"></div>
                <div class="col-auto px-4 py-3"><img src="/images/platforms/tidal.svg" alt="Tidal" height="40"></div>
                <div class="col-auto px-4 py-3"><img src="/images/platforms/deezer.svg" alt="Deezer" height="40"></div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="text-center mb-5">
            <h2>For every thing you do</h2>
            <p class="lead">Marketing tools built specifically for music promotion</p>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
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
                <div class="card feature-card h-100">
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
</section>

<!-- Fan Management Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="mb-4">Your fans are your most valuable asset</h2>
                <p class="lead mb-4">Fan Base Management</p>
                <p class="mb-4">Know who your fans are and contact them directly with dozens of ways to collect, organize and sync fan contact info.</p>
                <a href="/register" class="btn btn-primary">Deepen fan relationships</a>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <img src="/images/fan-management.jpg" alt="Fan Management" class="card-img-top">
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
                <h2 class="mb-4">Know what works and use it to grow</h2>
                <p class="lead mb-4">Analytics and Insights</p>
                <p class="mb-4">Track fan behaviors across your links, get artist level insights and send it all to your ad retargeting platforms.</p>
                <a href="/register" class="btn btn-primary">Grow with fan insights</a>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="card">
                    <img src="/images/analytics-dashboard.jpg" alt="Analytics Dashboard" class="card-img-top">
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
                            <img src="/images/smart-link-example.jpg" alt="Smart Link Example" class="img-fluid rounded shadow">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Simple Pricing</h2>
            <p class="lead">Start free and upgrade when you need more</p>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h3 class="mb-4">Free</h3>
                            <p class="text-muted mb-4">Perfect for new artists just getting started</p>
                            <h2 class="display-4 mb-4">$0</h2>
                            <p class="text-muted mb-5">Forever</p>
                        </div>
                        <ul class="list-unstyled mb-5">
                            <li class="mb-3"><span class="text-primary mr-2">✓</span> Up to 3 smart links</li>
                            <li class="mb-3"><span class="text-primary mr-2">✓</span> Basic analytics (7-day retention)</li>
                            <li class="mb-3"><span class="text-primary mr-2">✓</span> Modern, responsive design</li>
                        </ul>
                        <div class="text-center">
                            <a href="/register" class="btn btn-outline-primary btn-block">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-primary">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h3 class="mb-4">Premium</h3>
                            <p class="text-muted mb-4">For serious artists who want more</p>
                            <h2 class="display-4 mb-4">$12</h2>
                            <p class="text-muted mb-5">per year</p>
                        </div>
                        <ul class="list-unstyled mb-5">
                            <li class="mb-3"><span class="text-primary mr-2">✓</span> Unlimited smart links</li>
                            <li class="mb-3"><span class="text-primary mr-2">✓</span> Advanced analytics (unlimited retention)</li>
                            <li class="mb-3"><span class="text-primary mr-2">✓</span> Modern, responsive design</li>
                            <li class="mb-3"><span class="text-primary mr-2">✓</span> Custom background options</li>
                            <li class="mb-3"><span class="text-primary mr-2">✓</span> Priority support</li>
                        </ul>
                        <div class="text-center">
                            <a href="/register" class="btn btn-primary btn-block">Start Free Trial</a>
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
        <p class="lead mb-5">Join thousands of artists already marketing themselves with Music Smart Links</p>
        <a href="/register" class="btn btn-light btn-lg">Get Started for Free</a>
    </div>
</section>