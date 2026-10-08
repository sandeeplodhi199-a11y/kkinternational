<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | Hisab Mittra Enterprise OS</title>
    <link rel="icon" type="image/png" href="/images/hisab-mittra-icon.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EEF2F6;
        }
        .login-glass-card {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 lg:p-10 relative overflow-hidden">

    <!-- Decorative Corner Ambient Shapes matching reference -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-blue-300/35 blur-3xl pointer-events-none -z-0"></div>
    <div class="absolute -bottom-32 -right-32 w-[28rem] h-[28rem] rounded-full bg-teal-200/40 blur-3xl pointer-events-none -z-0"></div>
    <div class="absolute top-1/4 -right-20 w-80 h-80 rounded-full bg-indigo-200/30 blur-3xl pointer-events-none -z-0"></div>

    <!-- Main Container Modal Card -->
    <div class="w-full max-w-5xl rounded-[32px] sm:rounded-[40px] login-glass-card bg-white/70 border border-white/80 shadow-[0_20px_60px_-15px_rgba(37,99,235,0.12),0_0_0_1px_rgba(255,255,255,0.9)] p-6 sm:p-10 lg:p-14 relative overflow-hidden z-10">
        
        <!-- Subtle inner gradient background -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-100/50 via-white/40 to-emerald-50/40 pointer-events-none -z-10"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Column: Branding & Overview -->
            <div class="lg:col-span-6 flex flex-col justify-between h-full space-y-8">
                <div>
                    <!-- Back to Login Link -->
                    <div class="mb-8">
                        <a href="{{ route('crm.login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-blue-600 transition group bg-white/80 hover:bg-white px-3.5 py-1.5 rounded-full border border-slate-200/70 shadow-sm">
                            <i class="fa-solid fa-arrow-left text-[11px] group-hover:-translate-x-1 transition-transform"></i>
                            <span>Back to Sign In</span>
                        </a>
                    </div>

                    <!-- Logo -->
                    <div class="mb-6">
                        <a href="{{ route('hisab.home') }}" class="inline-block transition-transform hover:scale-105">
                            <img src="/images/hisab-mittra-logo.png" alt="Hisab Mittra" class="h-12 sm:h-14 w-auto object-contain">
                        </a>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                        Fast, Efficient and Productive
                    </h1>

                    <!-- Description Text -->
                    <p class="text-sm sm:text-base text-slate-600 font-medium leading-relaxed max-w-md mt-4">
                        Instant credential recovery. Reset your account credentials securely to regain access to your CRM workspace and workspace.
                    </p>
                </div>
            </div>

            <!-- Right Column: Reset Password Card -->
            <div class="lg:col-span-6 flex justify-center lg:justify-end">
                <div class="w-full max-w-md bg-white rounded-[28px] sm:rounded-[32px] p-7 sm:p-10 shadow-[0_20px_50px_-10px_rgba(15,23,42,0.08),0_0_0_1px_rgba(226,232,240,0.9)] border border-slate-100 relative">
                    
                    <!-- Back link inside card for mobile -->
                    <div class="mb-4">
                        <a href="{{ route('crm.login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-blue-600 transition">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            <span>Back to Sign In</span>
                        </a>
                    </div>

                    <!-- Form Title -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            Reset your password
                        </h2>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            Enter your username or email and choose your new password.
                        </p>
                    </div>

                    <!-- Server Flash Messages -->
                    @if(session('error'))
                        <div class="mb-5 flex items-center gap-3 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Reset Form -->
                    <form id="crm-reset-form" action="{{ route('crm.forgot-password.post') }}" method="POST" onsubmit="onFormSubmit(event)" class="space-y-4">
                        @csrf

                        <!-- Username or Email Field -->
                        <div>
                            <label for="login-input" class="block text-xs font-bold text-slate-800 mb-1.5">
                                Username or Registered Email
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-user-circle text-xs"></i>
                                </span>
                                <input type="text" name="login" id="login-input" 
                                       value="{{ old('login') }}" 
                                       placeholder="Enter your username or email" 
                                       required 
                                       autocomplete="username"
                                       class="w-full text-xs font-medium pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white focus:bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                            </div>
                            @error('login')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password Field -->
                        <div>
                            <label for="password-input" class="block text-xs font-bold text-slate-800 mb-1.5">
                                New Password
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </span>
                                <input type="password" name="password" id="password-input" 
                                       placeholder="Min 6 characters" 
                                       required 
                                       autocomplete="new-password"
                                       class="w-full text-xs font-medium pl-10 pr-10 py-3 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white focus:bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                                
                                <button type="button" onclick="togglePasswordVisibility('password-input', 'pwd-toggle-icon')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-700 cursor-pointer">
                                    <i id="pwd-toggle-icon" class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password Field -->
                        <div>
                            <label for="password-confirm-input" class="block text-xs font-bold text-slate-800 mb-1.5">
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-shield-check text-xs"></i>
                                </span>
                                <input type="password" name="password_confirmation" id="password-confirm-input" 
                                       placeholder="Re-enter new password" 
                                       required 
                                       autocomplete="new-password"
                                       class="w-full text-xs font-medium pl-10 pr-10 py-3 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white focus:bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                                
                                <button type="button" onclick="togglePasswordVisibility('password-confirm-input', 'pwd-confirm-toggle-icon')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-700 cursor-pointer">
                                    <i id="pwd-confirm-toggle-icon" class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submit-btn" 
                                class="w-full py-3.5 px-4 rounded-xl text-white font-extrabold text-sm shadow-lg shadow-blue-600/30 transition-all duration-200 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:scale-[0.99] cursor-pointer mt-4">
                            <i id="btn-icon" class="fa-solid fa-rotate text-xs"></i>
                            <span id="btn-text">Reset Password & Sign In</span>
                        </button>
                    </form>

                    <!-- Footer Note -->
                    <p class="text-center text-[11px] text-slate-400 font-medium mt-6">
                        &copy; {{ date('Y') }} Hisab Mittra Technologies &bull; Secure Portal Access
                    </p>

                </div>
            </div>

        </div>

    </div>

    <!-- Interactive Script -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-regular fa-eye-slash text-xs text-blue-600';
            } else {
                input.type = 'password';
                icon.className = 'fa-regular fa-eye text-xs text-slate-400';
            }
        }

        function onFormSubmit(e) {
            const btn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-wait');
            btnIcon.className = 'fa-solid fa-circle-notch fa-spin text-xs';
            btnText.textContent = 'Updating password...';
        }
    </script>
</body>
</html>
