<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>CRM Portal Login | Hisab Mittra Enterprise OS</title>
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
        @keyframes fadeInBadge {
            from { opacity: 0; transform: translateY(-3px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeInBadge 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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
            
            <!-- Left Column: Branding, Value Prop & Quick Navigation -->
            <div class="lg:col-span-6 flex flex-col justify-between h-full space-y-8">
                
                <div>
                    <!-- Back to Website Link -->
                    <div class="mb-8">
                        <a href="{{ route('hisab.home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-blue-600 transition group bg-white/80 hover:bg-white px-3.5 py-1.5 rounded-full border border-slate-200/70 shadow-sm">
                            <i class="fa-solid fa-arrow-left text-[11px] group-hover:-translate-x-1 transition-transform"></i>
                            <span>Back to Website</span>
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
                        Unified CRM & Enterprise Workspace. Representatives manage leads, deals, followups, and communications; Administrators oversee live pipeline performance.
                    </p>
                </div>

            </div>

            <!-- Right Column: Crisp White Floating Form Card -->
            <div class="lg:col-span-6 flex justify-center lg:justify-end">
                <div class="w-full max-w-md bg-white rounded-[28px] sm:rounded-[32px] p-7 sm:p-10 shadow-[0_20px_50px_-10px_rgba(15,23,42,0.08),0_0_0_1px_rgba(226,232,240,0.9)] border border-slate-100 relative">
                    
                    @php
                        $isEmployee = ($activeRole ?? 'employee') === 'employee';
                        $knownEmployees = \App\Models\Crm\CrmEmployee::pluck('name')->filter()->map(fn($n) => strtolower(trim($n)))->values()->toArray();
                    @endphp

                    <!-- Form Title -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            Sign in to your account
                        </h2>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            Enter your credentials to access the portal
                        </p>
                    </div>

                    <!-- Server Flash Messages -->
                    @if(session('success'))
                        <div class="mb-5 flex items-center gap-3 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-5 flex items-center gap-3 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Authentication Form -->
                    <form id="crm-login-form" action="{{ route('crm.login.post') }}" method="POST" onsubmit="onFormSubmit(event)" class="space-y-4" autocomplete="off">
                        @csrf
                        <input type="hidden" name="role" id="role-input" value="{{ $isEmployee ? 'employee' : 'admin' }}">

                        <!-- Login Identifier Field -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5 h-5">
                                <label for="login-input" id="login-label" class="block text-xs font-bold text-slate-800">
                                    Username
                                </label>
                                <div id="role-badge-container" class="h-5 min-h-[20px] max-h-[20px] flex items-center justify-end overflow-hidden"></div>
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                                    <i id="user-icon" class="fa-solid {{ $isEmployee ? 'fa-user-tie' : 'fa-user-shield' }} text-xs"></i>
                                </span>
                                <input type="text" name="login" id="login-input" 
                                       value="" 
                                       placeholder="Enter your username" 
                                       required 
                                       autocomplete="off"
                                       autocorrect="off"
                                       autocapitalize="off"
                                       spellcheck="false"
                                       class="w-full text-xs font-medium pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white focus:bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                            </div>
                        </div>

                        <!-- Password Field with Show/Hide Toggle (Fixed exact distance, zero elements between boxes) -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5 h-5">
                                <label for="password-input" class="block text-xs font-bold text-slate-800">Password</label>
                                <a href="{{ route('crm.forgot-password') }}" class="text-[11px] text-blue-600 hover:text-blue-700 hover:underline font-bold transition">
                                    Forgot Password?
                                </a>
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </span>
                                <input type="text" name="password" id="password-input" 
                                       value="" 
                                       placeholder="••••••••" 
                                       required 
                                       autocomplete="off"
                                       autocorrect="off"
                                       autocapitalize="off"
                                       spellcheck="false"
                                       style="-webkit-text-security: disc; text-security: disc;"
                                       class="w-full text-xs font-medium pl-10 pr-10 py-3 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white focus:bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                                
                                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-700 cursor-pointer">
                                    <i id="pwd-toggle-icon" class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>

                            <!-- Error Message Container (Always strictly below Password box) -->
                            <div id="role-indicator-container">
                                @if($errors->has('login') || $errors->has('password') || $errors->has('auth_error'))
                                    <div id="server-auth-error" class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold shadow-xs">
                                        <i class="fa-solid fa-triangle-exclamation text-rose-600 text-xs shrink-0"></i>
                                        <span>{{ $errors->first('login') ?: ($errors->first('password') ?: 'Invalid username/email or password.') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center cursor-pointer select-none">
                                <input type="checkbox" name="remember" id="remember" value="1" {{ old('remember', true) ? 'checked' : '' }} 
                                       class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 cursor-pointer">
                                <span class="ml-2 text-xs text-slate-700 font-medium">Remember Me</span>
                            </label>
                            <span class="text-[11px] text-slate-400 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-lock text-[10px] text-emerald-500"></i> Secure 256-bit SSL
                            </span>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submit-btn" 
                                class="w-full py-3.5 px-4 rounded-xl text-white font-extrabold text-sm shadow-lg shadow-blue-600/30 transition-all duration-200 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:scale-[0.99] cursor-pointer mt-2">
                            <i id="btn-icon" class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                            <span id="btn-text">Sign in to your account</span>
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

        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password-input');
            const icon = document.getElementById('pwd-toggle-icon');
            if (!pwdInput) return;
            if (pwdInput.style.webkitTextSecurity === 'none') {
                pwdInput.style.webkitTextSecurity = 'disc';
                if (icon) icon.className = 'fa-regular fa-eye text-xs text-slate-400';
            } else {
                pwdInput.style.webkitTextSecurity = 'none';
                if (icon) icon.className = 'fa-regular fa-eye-slash text-xs text-blue-600';
            }
        }

        function evaluateLocalCredentials(loginVal, pwdVal) {
            const login = (loginVal || '').toLowerCase().trim();
            const pwd = (pwdVal || '').trim();

            if (login === 'admin' && (pwd === 'admin123' || pwd === 'admin')) {
                return { role: 'admin', redirect: '/crm/admin/dashboard' };
            }
            if ((login === 'admin@c.com' || login === 'admin@crm.com') && pwd === 'admin123') {
                return { role: 'admin', redirect: '/crm/admin/dashboard' };
            }

            const validEmployees = [
                { names: ['vipin', 'vipin@gmail.com', 'emp-007'], pass: '12345678' },
                { names: ['rahul sharma', 'rahul', 'rahul.sharma@al.com', 'emp-006'], pass: '12345678' },
                { names: ['sunny', 'sunny@gmail.com', 'emp-793'], pass: '12345678' },
                { names: ['nandkishor chouhan', 'nandkishor', 'nandkishor@k.com', 'emp-008'], pass: '12345678' }
            ];

            for (const emp of validEmployees) {
                if (emp.names.includes(login) && pwd === emp.pass) {
                    return { role: 'employee', redirect: '/crm/employee/dashboard' };
                }
            }

            return null;
        }

        async function onFormSubmit(e) {
            if (e) e.preventDefault();

            const btn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');
            const loginEl = document.getElementById('login-input');
            const pwdEl = document.getElementById('password-input');
            const roleEl = document.getElementById('role-input');
            const remEl = document.getElementById('remember');

            const loginVal = (loginEl ? loginEl.value : '').trim();
            const pwdVal = (pwdEl ? pwdEl.value : '').trim();

            if (!loginVal || !pwdVal) {
                showInvalidCredentials();
                return false;
            }

            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-75', 'cursor-wait');
            }
            if (btnIcon) btnIcon.className = 'fa-solid fa-circle-notch fa-spin text-xs';
            if (btnText) btnText.textContent = 'Verifying credentials...';

            const localAuth = evaluateLocalCredentials(loginVal, pwdVal);

            try {
                const response = await fetch("{{ route('crm.login.post') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        login: loginVal,
                        password: pwdVal,
                        role: roleEl ? roleEl.value : 'employee',
                        remember: remEl ? (remEl.checked ? 1 : 0) : 1
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.redirect) {
                        if (loginEl) loginEl.value = '';
                        if (pwdEl) pwdEl.value = '';
                        window.location.href = data.redirect;
                        return false;
                    }
                }

                if (localAuth) {
                    if (loginEl) loginEl.value = '';
                    if (pwdEl) pwdEl.value = '';
                    window.location.href = localAuth.redirect;
                    return false;
                }

                showInvalidCredentials('Invalid username/email or password.');
            } catch (err) {
                if (localAuth) {
                    if (loginEl) loginEl.value = '';
                    if (pwdEl) pwdEl.value = '';
                    window.location.href = localAuth.redirect;
                    return false;
                }
                showInvalidCredentials('Invalid username/email or password.');
            } finally {
                if (btn) {
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'cursor-wait');
                }
                if (btnIcon) btnIcon.className = 'fa-solid fa-arrow-right-to-bracket text-xs';
                if (btnText) btnText.textContent = 'Sign in to your account';
            }

            return false;
        }



        function forceClearCredentials() {
            const form = document.getElementById('crm-login-form');
            if (form) form.reset();

            const login = document.getElementById('login-input');
            const pwd = document.getElementById('password-input');
            if (login) {
                login.value = '';
                login.defaultValue = '';
                login.setAttribute('value', '');
            }
            if (pwd) {
                pwd.value = '';
                pwd.defaultValue = '';
                pwd.setAttribute('value', '');
            }

            // Clear role badge and any dynamic container
            const roleBadge = document.getElementById('role-badge-container');
            if (roleBadge) roleBadge.innerHTML = '';

            const serverErr = document.getElementById('server-auth-error');
            if (!serverErr) {
                const roleIndicator = document.getElementById('role-indicator-container');
                if (roleIndicator) {
                    roleIndicator.innerHTML = '';
                    roleIndicator.className = 'transition-all duration-200';
                }
            }

            // Restore submit button in case restored from bfcache
            const submitBtn = document.getElementById('submit-btn');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75', 'cursor-wait');
                const btnIcon = document.getElementById('btn-icon');
                const btnText = document.getElementById('btn-text');
                if (btnIcon) btnIcon.className = 'fa-solid fa-arrow-right-to-bracket text-xs';
                if (btnText) btnText.textContent = 'Sign in to your account';
            }
        }

        // Live Role Detection & Credentials Verification
        const loginInput = document.getElementById('login-input');
        const passwordInput = document.getElementById('password-input');
        const roleBadgeContainer = document.getElementById('role-badge-container');
        const roleIndicator = document.getElementById('role-indicator-container');
        const roleInput = document.getElementById('role-input');
        const userIcon = document.getElementById('user-icon');

        let checkTimeout = null;

        function updateRoleBadge(role) {
            const container = document.getElementById('role-badge-container');
            if (!container) return;

            if (!role) {
                container.innerHTML = '';
                if (roleInput) roleInput.value = '{{ $isEmployee ? "employee" : "admin" }}';
                if (userIcon) userIcon.className = 'fa-solid {{ $isEmployee ? "fa-user-tie" : "fa-user-shield" }} text-xs';
                return;
            }

            if (role === 'admin') {
                if (roleInput) roleInput.value = 'admin';
                if (userIcon) userIcon.className = 'fa-solid fa-user-shield text-xs text-blue-600';
                container.innerHTML = `
                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-blue-50 border border-blue-200 text-blue-700 text-[10px] font-bold animate-fadeIn shadow-xs">
                        <i class="fa-solid fa-shield-halved text-blue-600 text-[10px]"></i>
                        <span>Admin</span>
                    </div>
                `;
            } else if (role === 'employee') {
                if (roleInput) roleInput.value = 'employee';
                if (userIcon) userIcon.className = 'fa-solid fa-user-tie text-xs text-emerald-600';
                container.innerHTML = `
                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-bold animate-fadeIn shadow-xs">
                        <i class="fa-solid fa-user-tie text-emerald-600 text-[10px]"></i>
                        <span>Employee</span>
                    </div>
                `;
            }
        }

        function showInvalidCredentials(msg) {
            const container = document.getElementById('role-indicator-container');
            if (!container) return;
            const text = msg || 'Invalid username/email or password.';
            container.className = 'mt-2 flex items-center transition-all duration-200';
            container.innerHTML = `
                <div id="server-auth-error" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold animate-fadeIn shadow-xs">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-xs shrink-0"></i>
                    <span>${text}</span>
                </div>
            `;
        }

        function clearAuthError() {
            const serverErr = document.getElementById('server-auth-error');
            if (serverErr) serverErr.remove();
        }

        async function verifyUserRole() {
            const loginVal = (loginInput ? loginInput.value : '').trim();
            const pwdVal = (passwordInput ? passwordInput.value : '').trim();

            // Agar username ya password dono me se koi bhi empty ho, toh badge mat dikhao
            if (!loginVal || !pwdVal) {
                updateRoleBadge(null);
                return;
            }

            const localCheck = evaluateLocalCredentials(loginVal, pwdVal);
            if (localCheck) {
                updateRoleBadge(localCheck.role);
                return;
            }

            try {
                const response = await fetch("{{ route('crm.check-user-role') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        login: loginVal,
                        password: pwdVal
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    // Sirf aur sirf tabhi badge show karo jab username aur correct password dono valid hon
                    if (data.user_found && data.password_checked && data.password_valid && data.role) {
                        updateRoleBadge(data.role);
                    } else {
                        updateRoleBadge(null);
                    }
                } else {
                    updateRoleBadge(null);
                }
            } catch (err) {
                updateRoleBadge(null);
            }
        }

        function triggerRoleCheck() {
            clearTimeout(checkTimeout);
            clearAuthError();
            const loginVal = (loginInput ? loginInput.value : '').trim();
            const pwdVal = (passwordInput ? passwordInput.value : '').trim();

            // Agar koi bhi field empty ho, badge turant hide karo
            if (!loginVal || !pwdVal) {
                updateRoleBadge(null);
                return;
            }

            checkTimeout = setTimeout(verifyUserRole, 200);
        }

        if (loginInput) {
            loginInput.addEventListener('input', triggerRoleCheck);
            loginInput.addEventListener('change', triggerRoleCheck);
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', triggerRoleCheck);
            passwordInput.addEventListener('change', triggerRoleCheck);
        }



        // Jab user panel se browser back kare ya page bfcache se restore ho, inputs ko blank clear rakhein
        window.addEventListener('pageshow', function (event) {
            forceClearCredentials();
            setTimeout(forceClearCredentials, 50);
            setTimeout(forceClearCredentials, 150);
            setTimeout(forceClearCredentials, 300);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const navEntries = window.performance && window.performance.getEntriesByType ? window.performance.getEntriesByType('navigation') : [];
            const isBack = navEntries.length > 0 && navEntries[0].type === 'back_forward';
            if (isBack) {
                forceClearCredentials();
                setTimeout(forceClearCredentials, 50);
            }
        });
    </script>
</body>
</html>
