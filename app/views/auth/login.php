<?php
$pageTitle = 'Login - Music Smart Links';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<div style='padding: 15px; background-color: #f8f9fa; border: 1px solid #ddd; margin-bottom: 20px;'>";
    echo "<h4>Form Submission Debug</h4>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo "</div>";
}
ob_start();
?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center p-4">
                        <h1 class="h3 mb-0">Log In to Your Account</h1>
                    </div>
                    <div class="card-body p-5">
                        <form action="/login" method="POST">
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                                    <label for="remember" class="form-check-label">Remember me</label>
                                </div>
                                
                                <a href="/forgot-password" class="text-decoration-none">Forgot password?</a>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-4">
                                Log In
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <p class="mb-4">Or log in with</p>
                            
                            <div class="d-grid gap-2">
                                <a href="/auth/google" class="btn btn-outline-secondary btn-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-google me-2" viewBox="0 0 16 16">
                                        <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                    </svg>
                                    Continue with Google
                                </a>
                                
                                <a href="/auth/spotify" class="btn btn-outline-success btn-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-spotify me-2" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.669 11.538a.498.498 0 0 1-.686.165c-1.879-1.147-4.243-1.407-7.028-.77a.499.499 0 0 1-.222-.973c3.048-.696 5.662-.397 7.77.892a.5.5 0 0 1 .166.686zm.979-2.178a.624.624 0 0 1-.858.205c-2.15-1.321-5.428-1.704-7.972-.932a.625.625 0 0 1-.362-1.194c2.905-.881 6.517-.454 8.986 1.063a.624.624 0 0 1 .206.858zm.084-2.268C10.154 5.56 5.9 5.419 3.438 6.166a.748.748 0 1 1-.434-1.432c2.825-.857 7.523-.692 10.492 1.07a.747.747 0 1 1-.764 1.288z"/>
                                    </svg>
                                    Continue with Spotify
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light py-3 text-center">
                        <p class="mb-0">
                            Don't have an account? <a href="/register" class="text-decoration-none fw-bold">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include BASE_PATH . '/app/views/layout.php';
?>