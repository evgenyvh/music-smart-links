<div class="relative">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16 rounded-lg shadow-xl">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Promote Your Music Everywhere</h1>
            <p class="text-xl mb-8">Create beautiful smart links to share your music across all platforms with just one link.</p>
            <?php if (isset($authController) && $authController->isLoggedIn()): ?>
                <a href="/dashboard/create" class="bg-white text-indigo-600 font-bold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">Create Your Smart Link</a>
            <?php else: ?>
                <a href="/register" class="bg-white text-indigo-600 font-bold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">Get Started for Free</a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Why Choose Music Smart Links?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-12 w-12">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Quick and Easy</h3>
                    <p class="text-gray-600">Set up your smart link in seconds. Just paste your Spotify link and we'll do the rest.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-12 w-12">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Detailed Analytics</h3>
                    <p class="text-gray-600">Track page views and platform clicks to see where your audience is listening.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-12 w-12">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Professional Look</h3>
                    <p class="text-gray-600">Beautiful landing pages with modern design that represent your brand professionally.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- How It Works Section -->
    <div class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                    <h3 class="text-xl font-bold mb-2">Paste Your Spotify Link</h3>
                    <p class="text-gray-600">Simply paste your Spotify track, album, or playlist link.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                    <h3 class="text-xl font-bold mb-2">Add Your Other Links</h3>
                    <p class="text-gray-600">Add links to other platforms like Apple Music, Tidal, and more.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                    <h3 class="text-xl font-bold mb-2">Share Your Smart Link</h3>
                    <p class="text-gray-600">Share your unique link with fans across all your channels.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pricing Section -->
    <div class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Simple Pricing</h2>
            
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-md p-8 border-t-4 border-indigo-400">
                    <h3 class="text-2xl font-bold mb-4">Free</h3>
                    <p class="text-gray-600 mb-6">Perfect for new artists just getting started.</p>
                    <div class="text-4xl font-bold mb-6">$0<span class="text-lg text-gray-600 font-normal">/month</span></div>
                    
                    <ul class="mb-8">
                        <li class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Up to 3 smart links</span>
                        </li>
                        <li class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Basic analytics (7-day retention)</span>
                        </li>
                        <li class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Modern, responsive design</span>
                        </li>
                    </ul>
                    
                    <a href="/register" class="block text-center bg-indigo-600 text-white font-bold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">Get Started</a>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-8 border-t-4 border-indigo-600 relative">
                    <div class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg rounded-tr-lg">POPULAR</div>
                    <h3 class="text-2xl font-bold mb-4">Premium</h3>
                    <p class="text-gray-600 mb-6">For serious artists who want more.</p>
                    <div class="text-4xl font-bold mb-6">$12<span class="text-lg text-gray-600 font-normal">/year</span></div>
                    
                    <ul class="mb-8">
                        <li class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Unlimited smart links</span>
                        </li>
                        <li class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Advanced analytics (unlimited retention)</span>
                        </li>
                        <li class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Modern, responsive design</span>
                        </li>
                        <li class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Custom background options</span>
                        </li>
                        <li class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Priority support</span>
                        </li>
                    </ul>
                    
                    <a href="/register" class="block text-center bg-indigo-600 text-white font-bold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">Get Started</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow-xl mb-8">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to Share Your Music?</h2>
            <p class="text-xl mb-8">Create your first smart link in seconds - no credit card required.</p>
            <?php if (isset($authController) && $authController->isLoggedIn()): ?>
                <a href="/dashboard/create" class="bg-white text-indigo-600 font-bold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">Create Your Smart Link</a>
            <?php else: ?>
                <a href="/register" class="bg-white text-indigo-600 font-bold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">Get Started for Free</a>
            <?php endif; ?>
        </div>
    </div>
</div>
