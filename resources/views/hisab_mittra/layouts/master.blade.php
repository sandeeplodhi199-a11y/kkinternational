<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hisab Mittra — Premium All-in-One Business Management & SaaS Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Hisab Mittra is India’s premium enterprise business operating platform. Seamlessly manage HRM, Biometric Attendance, Payroll, CRM, Sales Pipeline, and Accounting.')">
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS with Luxury Light Green, Royal/Ice Blue & Radiant Orange Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // 1. LIGHT GREEN PALETTE (Base theme & fresh surfaces)
                        mint: {
                            DEFAULT: '#F0F8F5',
                            50:      '#F8FCFA',
                            100:     '#F0F8F5',
                            200:     '#DCF2E7',
                            300:     '#BEE5D1',
                            400:     '#86D0A9',
                        },
                        green: {
                            DEFAULT: '#10B981',
                            hover:   '#059669',
                            dark:    '#065F46',
                            soft:    '#DCF2E7',
                        },

                        // 2. BLUE PALETTE (Royal Sapphire & Celestial Ice Blue)
                        peri: {
                            DEFAULT: '#2563EB',
                            mist:    '#EFF5FD',
                            light:   '#E2EDFC',
                            border:  '#BFDBFE',
                            dark:    '#1E3A8A',
                        },
                        aqua: {
                            DEFAULT: '#2563EB',
                            hover:   '#1D4ED8',
                            dark:    '#1E3A8A',
                            light:   '#EFF6FF',
                            soft:    '#DBEAFE',
                            border:  '#93C5FD',
                        },

                        // 3. ORANGE PALETTE (Warm Radiant Brand Accent)
                        orange: {
                            DEFAULT: '#F97316',
                            hover:   '#EA580C',
                            light:   '#FFF7ED',
                            soft:    '#FFEDD5',
                            border:  '#FED7AA',
                            dark:    '#C2410C',
                        },

                        // LUXURY TYPOGRAPHY (Midnight Slate & Crisp Body)
                        navy: {
                            DEFAULT: '#0F172A',
                            body:    '#334155',
                            muted:   '#475569',
                            subtle:  '#64748B',
                            border:  '#CBD5E1',
                        },

                        // Backward-compatible aliases mapped to the new luxury palette
                        ivory: {
                            DEFAULT: '#F0F8F5',
                            50:      '#F8FCFA',
                            100:     '#F0F8F5',
                            200:     '#EFF5FD',
                            300:     '#E2EDFC',
                        },
                        champagne: {
                            DEFAULT: '#F97316',
                            light:   '#FFF7ED',
                            soft:    '#FFEDD5',
                            border:  '#FED7AA',
                            dark:    '#EA580C',
                        },
                        burgundy: {
                            DEFAULT: '#2563EB',
                            hover:   '#1D4ED8',
                            dark:    '#1E3A8A',
                            light:   '#EFF6FF',
                            soft:    '#DBEAFE',
                            border:  '#93C5FD',
                        },
                        charcoal: {
                            DEFAULT: '#0F172A',
                            light:   '#334155',
                            muted:   '#475569',
                            subtle:  '#64748B',
                            border:  '#BFDBFE',
                        },
                        mauve: {
                            DEFAULT: '#2563EB',
                            light:   '#EFF5FD',
                            soft:    '#DBEAFE',
                            border:  '#BFDBFE',
                            dark:    '#1E3A8A',
                        },
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    boxShadow: {
                        'soft-elevation':  '0 10px 30px -10px rgba(15, 23, 42, 0.05), 0 2px 6px 0 rgba(16, 185, 129, 0.05)',
                        'luxury-card':     '0 15px 35px -5px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(191, 219, 254, 0.50)',
                        'aqua-glow':       '0 10px 25px -5px rgba(37, 99, 235, 0.35)',
                        'orange-glow':     '0 10px 25px -5px rgba(249, 115, 22, 0.35)',
                        'champagne-glow':  '0 10px 25px -5px rgba(249, 115, 22, 0.35)',
                        'burgundy-glow':   '0 10px 25px -5px rgba(37, 99, 235, 0.35)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EBF8FE;
            background-image: 
                radial-gradient(circle 900px at 0% 0%, rgba(186, 230, 253, 0.85) 0%, rgba(224, 242, 254, 0.50) 40%, transparent 70%),
                radial-gradient(circle 950px at 100% 5%, rgba(254, 215, 170, 0.75) 0%, rgba(255, 247, 237, 0.45) 40%, transparent 70%),
                radial-gradient(circle 850px at 50% 50%, rgba(167, 243, 208, 0.65) 0%, rgba(236, 253, 245, 0.40) 45%, transparent 75%),
                radial-gradient(circle 1000px at 0% 95%, rgba(186, 230, 253, 0.70) 0%, rgba(224, 242, 254, 0.40) 45%, transparent 75%),
                radial-gradient(circle 950px at 100% 95%, rgba(254, 215, 170, 0.80) 0%, rgba(255, 237, 213, 0.50) 45%, transparent 75%),
                linear-gradient(135deg, #E0F2FE 0%, #ECFDF5 50%, #FFF7ED 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            color: #1E293B;
            overflow-x: hidden;
        }

        /* Glassmorphism styles matching reference */
        .glass-header {
            background: rgba(248, 250, 252, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .glass-modal {
            background: rgba(248, 250, 252, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Subtle scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track  { background: #E0F2FE; }
        ::-webkit-scrollbar-thumb  { background: #BAE6FD; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #38BDF8; }

        /* Simple Black Typography (Overrides colorful gradients site-wide) */
        .text-gradient-burgundy,
        .text-gradient-aqua,
        .text-gradient-gold {
            background: none !important;
            -webkit-background-clip: unset !important;
            -webkit-text-fill-color: #000000 !important;
            color: #000000 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-style: normal !important;
        }

        /* Hero contrast & accent */
        .text-aqua {
            color: #38BDF8; /* Luminous celestial azure on dark hero */
        }

        /* High-contrast crisp white text on primary aqua buttons */
        button.bg-aqua,
        a.bg-aqua,
        [class*="from-aqua"] {
            color: #FFFFFF !important;
        }
        button.bg-aqua:hover,
        a.bg-aqua:hover,
        [class*="from-aqua"]:hover {
            color: #FFFFFF !important;
        }
        button.bg-aqua i,
        a.bg-aqua i,
        [class*="from-aqua"] i {
            color: #FFFFFF !important;
        }

        /* Subtle grid background pattern */
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right,  rgba(191, 219, 254, 0.15) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(191, 219, 254, 0.15) 1px, transparent 1px);
        }

        /* ========================================================================= */
        /* DYNAMIC MOTION SYSTEM (SITE-WIDE) */
        /* ========================================================================= */

        /* Smooth Top Scroll Progress Bar */
        #scroll-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3.5px;
            width: 0%;
            background: linear-gradient(90deg, #2563EB, #10B981, #F97316);
            z-index: 9999;
            transition: width 0.1s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.5);
        }

        /* Scroll Reveal Base Classes */
        .motion-reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .motion-fade-in {
            opacity: 0;
            transform: scale(0.96);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .motion-slide-left {
            opacity: 0;
            transform: translateX(-35px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .motion-slide-right {
            opacity: 0;
            transform: translateX(35px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        /* Visible State Triggered via Intersection Observer */
        .motion-visible {
            opacity: 1 !important;
            transform: translate(0, 0) scale(1) !important;
        }

        /* Stagger Delays */
        .delay-100 { transition-delay: 100ms !important; }
        .delay-200 { transition-delay: 200ms !important; }
        .delay-300 { transition-delay: 300ms !important; }
        .delay-400 { transition-delay: 400ms !important; }
        .delay-500 { transition-delay: 500ms !important; }
        .delay-600 { transition-delay: 600ms !important; }

        /* Dynamic Floating Micro-Animations */
        @keyframes motionFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-7px); }
        }

        @keyframes motionFloatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }

        @keyframes motionFloatReverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(8px); }
        }

        @keyframes rippleMotion {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .motion-float {
            animation: motionFloat 4s ease-in-out infinite;
        }

        .motion-float-slow {
            animation: motionFloatSlow 6s ease-in-out infinite;
        }

        .motion-float-reverse {
            animation: motionFloatReverse 5s ease-in-out infinite;
        }

        /* Dynamic Card Hover Physics */
        .motion-card,
        .hover-lift {
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .motion-card:hover,
        .hover-lift:hover {
            transform: translateY(-6px) scale(1.004) !important;
            box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(37, 99, 235, 0.25) !important;
        }

        /* Shimmer Sheen Beam on Primary Buttons */
        .btn-shimmer {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-shimmer::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -80%;
            width: 50%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.35) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(25deg);
            transition: all 0.8s ease;
            pointer-events: none;
        }
        .btn-shimmer:hover::before {
            left: 150%;
        }

        /* Active Click Dynamic Bounce */
        button:active,
        a.btn-shimmer:active,
        .btn-action:active {
            transform: scale(0.97) !important;
            transition: transform 0.1s ease !important;
        }

        /* 1. Dynamic Cursor Glow Follower Spotlight (Desktop) */
        #cursor-glow-follower {
            position: fixed;
            top: 0;
            left: 0;
            width: 420px;
            height: 420px;
            margin-left: -210px;
            margin-top: -210px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, rgba(16, 185, 129, 0.04) 40%, transparent 70%);
            pointer-events: none;
            z-index: 9998;
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform, left, top;
        }
        #cursor-glow-follower.is-hovering {
            transform: scale(1.4);
            background: radial-gradient(circle, rgba(37, 99, 235, 0.12) 0%, rgba(249, 115, 22, 0.05) 45%, transparent 70%);
        }
        @media (hover: none), (pointer: coarse) {
            #cursor-glow-follower { display: none !important; }
        }

        /* 2. Dynamic Click Particle Burst */
        .click-particle {
            position: fixed;
            pointer-events: none;
            border-radius: 50%;
            z-index: 99999;
            will-change: transform, opacity;
            animation: particleBurst 0.65s cubic-bezier(0.12, 0.8, 0.32, 1) forwards;
        }
        @keyframes particleBurst {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(var(--tx), var(--ty)) scale(0);
                opacity: 0;
            }
        }

        /* 3. Global 3D Card Tilt & Cursor Sheen */
        .motion-card-tilt {
            transform-style: preserve-3d;
            transition: transform 0.12s ease-out, box-shadow 0.3s ease;
            will-change: transform;
            position: relative;
        }
        .card-cursor-sheen {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: radial-gradient(circle 260px at var(--mx, 50%) var(--my, 50%), rgba(255, 255, 255, 0.25), transparent 70%);
            mix-blend-mode: overlay;
            z-index: 10;
        }

        /* 4. Floating Back to Top Button (Positioned cleanly above the corner WhatsApp button) */
        #back-to-top-btn {
            position: fixed;
            bottom: 86px;
            right: 20px;
            z-index: 993;
            opacity: 0;
            transform: translateY(16px) scale(0.85);
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
            pointer-events: none;
        }
        #back-to-top-btn.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        #back-to-top-btn:hover {
            transform: translateY(-3px) scale(1.06);
            box-shadow: 0 14px 28px -6px rgba(37, 99, 235, 0.35);
        }

        /* 5. Floating WhatsApp Button (Docked right in the Bottom Corner) */
        #floating-support-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 996;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #floating-support-btn:hover {
            transform: translateY(-2px) scale(1.05);
        }




        /* Respect Accessibility: User Reduced Motion Preference */
        @media (prefers-reduced-motion: reduce) {
            .motion-reveal,
            .motion-fade-in,
            .motion-slide-left,
            .motion-slide-right,
            .motion-float,
            .motion-float-slow,
            .motion-float-reverse,
            .click-particle,
            #cursor-glow-follower {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
                display: none !important;
            }
        }
    </style>
    @yield('extra_css')
</head>
<body class="min-h-screen flex flex-col text-navy antialiased selection:bg-aqua-soft selection:text-aqua-dark">
    <!-- TOP SCROLL PROGRESS BAR -->
    <div id="scroll-progress-bar"></div>

    <!-- STICKY NAVBAR -->
    <header id="main-navbar" class="sticky top-0 z-40 transition-all duration-300 glass-header border-b border-peri-border/40">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex items-center justify-between h-20 transition-all duration-300 w-full" id="navbar-inner">
                
                <!-- Logo -->
                <a href="{{ route('hisab.home') }}" class="flex items-center group shrink-0">
                    <img src="/images/hisab-mittra-logo.png" alt="Hisab Mittra" class="h-11 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>

                <!-- Desktop Navigation Menu (Centered) -->
                <nav class="hidden lg:flex items-center gap-7 text-xs font-bold text-navy-body mx-auto">
                    <a href="{{ route('hisab.home') }}" class="hover:text-aqua-dark transition-colors {{ Request::routeIs('hisab.home') ? 'text-aqua-dark font-extrabold' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('hisab.features') }}" class="hover:text-aqua-dark transition-colors {{ Request::routeIs('hisab.features') ? 'text-aqua-dark font-extrabold' : '' }}">
                        Features
                    </a>
                    <a href="{{ route('hisab.hrm') }}" class="hover:text-aqua-dark transition-colors {{ Request::routeIs('hisab.hrm') ? 'text-aqua-dark font-extrabold' : '' }}">
                        HRM & Attendance
                    </a>
                    <a href="{{ route('hisab.crm') }}" class="hover:text-aqua-dark transition-colors {{ Request::routeIs('hisab.crm') ? 'text-aqua-dark font-extrabold' : '' }}">
                        CRM & Pipeline
                    </a>
                    <a href="{{ route('hisab.pricing') }}" class="hover:text-aqua-dark transition-colors {{ Request::routeIs('hisab.pricing') ? 'text-aqua-dark font-extrabold' : '' }}">
                        Pricing
                    </a>

                    <!-- Resources Dropdown -->
                    <div class="relative group py-2">
                        <button class="flex items-center gap-1.5 hover:text-aqua-dark transition-colors cursor-pointer {{ Request::routeIs('hisab.blog') || Request::routeIs('hisab.about') || Request::routeIs('hisab.contact') || Request::routeIs('hisab.help') ? 'text-aqua-dark font-extrabold' : '' }}">
                            <span>Resources</span>
                            <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200 group-hover:rotate-180"></i>
                        </button>
                        
                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-2xl shadow-luxury-card border border-peri-border/50 py-2.5 hidden group-hover:block transition-all duration-200 z-50">
                            <a href="{{ route('hisab.blog') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-semibold text-navy hover:bg-aqua-soft hover:text-aqua-dark transition">
                                <i class="fa-regular fa-newspaper text-aqua-dark/80 w-4 text-center"></i>
                                <div>
                                    <div>Articles & Guides</div>
                                    <div class="text-[10px] text-navy-subtle font-normal">Payroll & Sales compliance</div>
                                </div>
                            </a>
                            <a href="{{ route('hisab.about') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-semibold text-navy hover:bg-aqua-soft hover:text-aqua-dark transition">
                                <i class="fa-regular fa-building text-aqua-dark/80 w-4 text-center"></i>
                                <div>
                                    <div>About Us</div>
                                    <div class="text-[10px] text-navy-subtle font-normal">Our team & vision</div>
                                </div>
                            </a>
                            <a href="{{ route('hisab.help') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-semibold text-navy hover:bg-aqua-soft hover:text-aqua-dark transition">
                                <i class="fa-regular fa-circle-question text-aqua-dark/80 w-4 text-center"></i>
                                <div>
                                    <div>Help Center & FAQs</div>
                                    <div class="text-[10px] text-navy-subtle font-normal">Setup & knowledge base</div>
                                </div>
                            </a>
                            <a href="{{ route('hisab.contact') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-semibold text-navy hover:bg-aqua-soft hover:text-aqua-dark transition">
                                <i class="fa-regular fa-envelope text-aqua-dark/80 w-4 text-center"></i>
                                <div>
                                    <div>Contact Sales & Support</div>
                                    <div class="text-[10px] text-navy-subtle font-normal">We're here 24/7</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Right Action Buttons (Right Corner) -->
                <div class="hidden sm:flex items-center gap-3 shrink-0 ml-auto lg:ml-0">
                    <!-- Login Button -->
                    <a href="{{ route('crm.login') }}" class="px-4 py-2.5 rounded-xl border border-peri-border hover:border-aqua text-navy hover:text-aqua-dark font-bold text-xs bg-white/80 transition-all duration-200 hover:shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-lock text-[11px] text-aqua-dark"></i>
                        <span>Login</span>
                    </a>

                    <!-- Book a Demo Button -->
                    <a href="{{ route('hisab.demo') }}" class="px-5 py-2.5 rounded-xl border border-aqua-border bg-aqua hover:bg-aqua-hover text-white font-extrabold text-xs transition-all duration-200 hover:shadow-md active:scale-95 shadow-sm">
                        Book a Demo
                    </a>
                </div>

                <!-- Mobile Hamburger Toggle -->
                <button type="button" onclick="toggleMobileNav()" class="lg:hidden p-2.5 rounded-xl border border-peri-border text-navy hover:text-aqua-dark bg-white ml-3 shrink-0" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars text-base"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div id="mobile-nav-drawer" class="lg:hidden hidden px-4 pt-3 pb-6 border-t border-peri-border/60 bg-mint/95 backdrop-blur-xl">
            <div class="space-y-2 text-sm font-bold text-navy">
                <a href="{{ route('hisab.home') }}" class="block px-3 py-2 rounded-xl hover:bg-aqua-soft hover:text-aqua-dark">Home</a>
                <a href="{{ route('hisab.features') }}" class="block px-3 py-2 rounded-xl hover:bg-aqua-soft hover:text-aqua-dark">Features Overview</a>
                <a href="{{ route('hisab.hrm') }}" class="block px-3 py-2 rounded-xl hover:bg-aqua-soft hover:text-aqua-dark">HRM & Biometric Attendance</a>
                <a href="{{ route('hisab.crm') }}" class="block px-3 py-2 rounded-xl hover:bg-aqua-soft hover:text-aqua-dark">CRM & Sales Pipeline</a>
                <a href="{{ route('hisab.pricing') }}" class="block px-3 py-2 rounded-xl hover:bg-aqua-soft hover:text-aqua-dark">Pricing & Plans</a>
                <a href="{{ route('hisab.blog') }}" class="block px-3 py-2 rounded-xl hover:bg-aqua-soft hover:text-aqua-dark">Resources & Guides</a>
                <a href="{{ route('hisab.about') }}" class="block px-3 py-2 rounded-xl hover:bg-aqua-soft hover:text-aqua-dark">About Hisab Mittra</a>
                <a href="{{ route('hisab.contact') }}" class="block px-3 py-2 rounded-xl hover:bg-aqua-soft hover:text-aqua-dark">Contact Support</a>
            </div>

            <div class="mt-4 pt-4 border-t border-peri-border/40 space-y-2.5">
                @if(Auth::check())
                    <a href="{{ route('crm.admin.dashboard') }}" class="w-full py-2.5 px-4 rounded-xl bg-aqua text-aqua-dark font-bold text-xs flex items-center justify-center gap-2 shadow-sm">
                        <span>Admin Dashboard</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                @else
                    <a href="{{ route('crm.login') }}" class="w-full py-2.5 px-4 rounded-xl border border-aqua text-aqua-dark font-bold text-xs flex items-center justify-center gap-2 bg-white">
                        <i class="fa-solid fa-lock text-[10px]"></i>
                        <span>Login to Admin Panel</span>
                    </a>
                @endif
                <a href="{{ route('hisab.demo') }}" class="w-full py-2.5 px-4 rounded-xl bg-aqua-soft border border-aqua-border text-navy font-bold text-xs text-center block">
                    Book a Product Demo
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN BODY CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white/95 backdrop-blur-md text-navy border-t border-slate-200/80 pt-16 pb-12 mt-0">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 max-w-[1500px] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 pb-12 border-b border-slate-200/70">
                
                <!-- Col 1: Brand & Bio (4 cols) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center">
                        <img src="/images/hisab-mittra-logo.png" alt="Hisab Mittra" class="h-12 sm:h-13 w-auto object-contain">
                    </div>
                    <p class="text-sm sm:text-base font-bold text-navy leading-relaxed max-w-md">
                        Built for Indian enterprises, MSMEs, retail chains, and tech companies. A single integrated platform replacing fragmented HR, biometric attendance, payroll, WhatsApp CRM, and accounting software.
                    </p>
                    <div class="pt-1">
                        <div class="text-xs font-black uppercase tracking-wider text-black mb-2">Security & Compliance</div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-1 rounded-lg bg-blue-50 border border-blue-200/80 text-xs font-extrabold text-blue-700 flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-shield-check text-blue-600"></i> ISO 27001
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200/80 text-xs font-extrabold text-emerald-700 flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-lock text-emerald-600"></i> SOC-2 Type II
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200/80 text-xs font-extrabold text-amber-700 flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-server text-amber-600"></i> 100% India Hosted
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Platform Modules (3 cols) -->
                <div class="lg:col-span-3">
                    <h5 class="text-base font-extrabold uppercase tracking-wider text-navy mb-5">Core Modules</h5>
                    <ul class="space-y-3 text-sm sm:text-base font-bold text-navy">
                        <li><a href="{{ route('hisab.hrm') }}" class="hover:text-blue-700 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-blue-600"></i> HR & Employee Management</a></li>
                        <li><a href="{{ route('hisab.hrm') }}" class="hover:text-blue-700 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-blue-600"></i> Biometric & Face Attendance</a></li>
                        <li><a href="{{ route('hisab.hrm') }}" class="hover:text-blue-700 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-blue-600"></i> PF / ESI / TDS Payroll</a></li>
                        <li><a href="{{ route('hisab.crm') }}" class="hover:text-blue-700 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-blue-600"></i> Visual Deal Pipeline</a></li>
                        <li><a href="{{ route('hisab.crm') }}" class="hover:text-blue-700 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-blue-600"></i> WhatsApp & Email CRM</a></li>
                        <li><a href="{{ route('hisab.features') }}" class="hover:text-blue-700 transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-blue-600"></i> Invoicing & Accounting</a></li>
                    </ul>
                </div>

                <!-- Col 3: Company & Resources (2 cols) -->
                <div class="lg:col-span-2">
                    <h5 class="text-base font-extrabold uppercase tracking-wider text-navy mb-5">Company</h5>
                    <ul class="space-y-3 text-sm sm:text-base font-bold text-navy">
                        <li><a href="{{ route('hisab.about') }}" class="hover:text-blue-700 transition">About Hisab Mittra</a></li>
                        <li><a href="{{ route('hisab.pricing') }}" class="hover:text-blue-700 transition">Pricing & Plans</a></li>
                        <li><a href="{{ route('hisab.blog') }}" class="hover:text-blue-700 transition">Payroll & Blog</a></li>
                        <li><a href="{{ route('hisab.help') }}" class="hover:text-blue-700 transition">Help Center & Docs</a></li>
                        <li><a href="{{ route('hisab.contact') }}" class="hover:text-blue-700 transition">Contact Support</a></li>
                    </ul>
                </div>

                <!-- Col 4: Enterprise Contact & Support (3 cols) -->
                <div class="lg:col-span-3">
                    <h5 class="text-base font-extrabold uppercase tracking-wider text-navy mb-5">Get In Touch</h5>
                    <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200/80 shadow-sm space-y-3.5">
                        <div class="flex items-start gap-3 text-sm font-semibold text-navy">
                            <i class="fa-solid fa-location-dot text-blue-600 mt-1 shrink-0"></i>
                            <span>DLF Cyber City, Gurugram, Haryana - 122002</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm font-bold text-navy">
                            <i class="fa-solid fa-phone text-blue-600 shrink-0"></i>
                            <a href="tel:+919876543210" class="hover:text-blue-700 transition">+91 98765 43210</a>
                        </div>
                        <div class="flex items-center gap-3 text-sm font-bold text-navy">
                            <i class="fa-solid fa-envelope text-blue-600 shrink-0"></i>
                            <a href="mailto:support@hisabmittra.com" class="hover:text-blue-700 transition">support@hisabmittra.com</a>
                        </div>
                        <button type="button" onclick="openDemoModal()" class="w-full mt-2 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs transition shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-calendar-check"></i> Book a Live Demo
                        </button>
                    </div>
                </div>

            </div>

            <!-- Bottom Row: Legal & Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm font-bold text-navy">
                <div>
                    &copy; {{ date('Y') }} Hisab Mittra Technologies Pvt. Ltd. All rights reserved. Made for Indian Businesses.
                </div>
                <div class="flex flex-wrap items-center gap-6 font-bold">
                    <a href="javascript:void(0)" class="hover:text-blue-700 transition">Privacy Policy</a>
                    <a href="javascript:void(0)" class="hover:text-blue-700 transition">Terms of Service</a>
                    <a href="javascript:void(0)" class="hover:text-blue-700 transition">Security Architecture</a>
                    <a href="javascript:void(0)" class="hover:text-blue-700 transition">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ========================================================================= -->
    <!-- GLOBAL DYNAMIC INTERACTIVE WIDGETS & FLOATING HUD -->
    <!-- ========================================================================= -->

    <!-- 1. Cursor Glow Follower Spotlight (Desktop) -->
    <div id="cursor-glow-follower"></div>




    <!-- 3. Floating WhatsApp Button (Docked in Corner) -->
    <div id="floating-support-btn" class="group">
        <a href="https://wa.me/919876543210?text=Hi%20Hisab%20Mittra%20team,%20I%20would%20like%20to%20learn%20more%20about%20the%20platform." target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp" title="Chat on WhatsApp" class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-white shadow-2xl shadow-emerald-600/40 flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 border-2 border-white">
            <i class="fa-brands fa-whatsapp text-2xl sm:text-3xl text-white"></i>
        </a>
    </div>

    <!-- Floating Support Interactive Quick Drawer Modal -->
    <div id="support-drawer" class="fixed bottom-16 right-4 sm:right-5 w-80 max-w-[calc(100vw-32px)] rounded-3xl bg-white border border-slate-200 shadow-2xl p-5 z-[999] hidden opacity-0 transition-all duration-300">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h4 class="text-xs font-black text-black">Hisab Mittra Direct Desk</h4>
                    <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active Specialists Online
                    </span>
                </div>
            </div>
            <button type="button" onclick="toggleSupportDrawer()" class="text-slate-400 hover:text-black text-xs p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="mt-4 space-y-2.5 text-xs">
            <a href="https://wa.me/919876543210?text=Hi%20Hisab%20Mittra%20team,%20I%20would%20like%20to%20learn%20more%20about%20the%20platform." target="_blank" class="p-3 rounded-2xl bg-emerald-50 hover:bg-emerald-100/80 border border-emerald-200 text-emerald-900 font-bold flex items-center justify-between transition group">
                <div class="flex items-center gap-2.5">
                    <i class="fa-brands fa-whatsapp text-lg text-emerald-600"></i>
                    <span>Chat on WhatsApp</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-emerald-600 transition-transform group-hover:translate-x-1"></i>
            </a>

            <a href="{{ route('hisab.demo') }}" class="p-3 rounded-2xl bg-blue-50 hover:bg-blue-100/80 border border-blue-200 text-blue-900 font-bold flex items-center justify-between transition group">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-calendar-check text-blue-600 text-sm"></i>
                    <span>Schedule 1-on-1 Demo</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-blue-600 transition-transform group-hover:translate-x-1"></i>
            </a>

            <a href="tel:+919876543210" class="p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-800 font-bold flex items-center justify-between transition group">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-phone text-slate-600 text-xs"></i>
                    <span>Call: +91 98765 43210</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>

    <!-- 4. Floating Back to Top Button with SVG Circular Progress -->
    <button type="button" id="back-to-top-btn" onclick="scrollToTop()" class="w-12 h-12 rounded-full bg-white border border-slate-200 shadow-xl flex items-center justify-center text-blue-600 relative group active:scale-90 transition-all" title="Back to top">
        <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 48 48">
            <circle cx="24" cy="24" r="20" class="stroke-slate-200" stroke-width="3" fill="none" />
            <circle id="scroll-circle-progress" cx="24" cy="24" r="20" class="stroke-blue-600 transition-all duration-100" stroke-width="3" stroke-linecap="round" fill="none" stroke-dasharray="125.6" stroke-dashoffset="125.6" />
        </svg>
        <i class="fa-solid fa-arrow-up text-sm transition-transform group-hover:-translate-y-0.5"></i>
    </button>

    <!-- GLOBAL JAVASCRIPT HELPERS & DYNAMIC MOTION ENGINE -->
    <script>
        // Sticky Navbar Compact on Scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('main-navbar');
            const inner = document.getElementById('navbar-inner');
            if (window.scrollY > 30) {
                navbar.classList.add('shadow-md');
                inner.classList.remove('h-20');
                inner.classList.add('h-16');
            } else {
                navbar.classList.remove('shadow-md');
                inner.classList.remove('h-16');
                inner.classList.add('h-20');
            }
        });

        // Mobile Nav Drawer Toggle
        function toggleMobileNav() {
            const drawer = document.getElementById('mobile-nav-drawer');
            drawer.classList.toggle('hidden');
        }

        // Demo Page Navigation Handler (Direct Full Page)
        function openDemoModal() {
            window.location.href = "{{ route('hisab.demo') }}";
        }

        // Floating Support Drawer Toggle
        function toggleSupportDrawer() {
            const drawer = document.getElementById('support-drawer');
            if (drawer.classList.contains('hidden')) {
                drawer.classList.remove('hidden');
                setTimeout(() => {
                    drawer.classList.remove('opacity-0');
                    drawer.classList.add('opacity-100');
                }, 10);
            } else {
                drawer.classList.remove('opacity-100');
                drawer.classList.add('opacity-0');
                setTimeout(() => {
                    drawer.classList.add('hidden');
                }, 300);
            }
        }

        // Dismiss Toast
        function dismissToast() {
            const toast = document.getElementById('live-activity-toast');
            if (toast) {
                toast.classList.remove('show');
            }
        }

        // Scroll to Top Smoothly
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Close Support Drawer on outside click
        document.addEventListener('click', (e) => {
            const drawer = document.getElementById('support-drawer');
            const btn = document.getElementById('floating-support-btn');
            if (drawer && !drawer.classList.contains('hidden')) {
                if (!drawer.contains(e.target) && !btn.contains(e.target)) {
                    toggleSupportDrawer();
                }
            }
        });

        // =========================================================================
        // GLOBAL DYNAMIC MOTION ENGINE (IntersectionObserver + Counters + Cursor + 3D Tilt)
        // =========================================================================
        document.addEventListener('DOMContentLoaded', () => {
            
            // 1. Top Reading / Scroll Progress Bar & Circular Progress Back-to-Top
            const progressBar = document.getElementById('scroll-progress-bar');
            const backToTopBtn = document.getElementById('back-to-top-btn');
            const scrollCircle = document.getElementById('scroll-circle-progress');
            const circleLength = 125.6; // 2 * PI * 20

            window.addEventListener('scroll', () => {
                const scrollTop = window.scrollY || document.documentElement.scrollTop;
                const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
                
                if (progressBar) {
                    progressBar.style.width = progress + '%';
                }

                if (backToTopBtn && scrollCircle) {
                    if (scrollTop > 280) {
                        backToTopBtn.classList.add('visible');
                    } else {
                        backToTopBtn.classList.remove('visible');
                    }
                    const offset = circleLength - (progress / 100) * circleLength;
                    scrollCircle.style.strokeDashoffset = offset;
                }
            }, { passive: true });

            // 2. Cursor Glow Follower Spotlight (Desktop Smooth Lerp)
            const cursorFollower = document.getElementById('cursor-glow-follower');
            if (cursorFollower && window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
                let mouseX = window.innerWidth / 2;
                let mouseY = window.innerHeight / 2;
                let currentX = mouseX;
                let currentY = mouseY;
                let isCursorVisible = false;

                document.addEventListener('mousemove', (e) => {
                    mouseX = e.clientX;
                    mouseY = e.clientY;
                    if (!isCursorVisible) {
                        isCursorVisible = true;
                        cursorFollower.style.opacity = '1';
                    }
                });

                document.addEventListener('mouseleave', () => {
                    isCursorVisible = false;
                    cursorFollower.style.opacity = '0';
                });

                function animateCursor() {
                    currentX += (mouseX - currentX) * 0.15;
                    currentY += (mouseY - currentY) * 0.15;
                    cursorFollower.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;
                    requestAnimationFrame(animateCursor);
                }
                requestAnimationFrame(animateCursor);

                // Hover bloom on interactive elements
                document.querySelectorAll('a, button, [role="button"], input, select, .motion-card, .glass-card').forEach(target => {
                    target.addEventListener('mouseenter', () => cursorFollower.classList.add('is-hovering'));
                    target.addEventListener('mouseleave', () => cursorFollower.classList.remove('is-hovering'));
                });
            }

            // 3. Global 3D Card Tilt Engine for all Cards & Grid Boxes
            const tiltCards = document.querySelectorAll(
                '.motion-card, .glass-card, [class*="rounded-3xl bg-white"], [class*="rounded-2xl bg-white"], .pricing-interactive-card, section > div > div.grid > div'
            );

            tiltCards.forEach(card => {
                if (card.classList.contains('no-tilt') || card.closest('#support-drawer')) return;
                
                card.classList.add('motion-card-tilt');
                
                // Add sheen element if not present
                if (!card.querySelector('.card-cursor-sheen')) {
                    const sheen = document.createElement('div');
                    sheen.className = 'card-cursor-sheen';
                    card.appendChild(sheen);
                }

                card.addEventListener('mousemove', (e) => {
                    if (window.innerWidth < 1024) return;
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    // Subtle tilt angles (max +/- 6 deg)
                    const rotateX = ((centerY - y) / centerY) * 6;
                    const rotateY = ((x - centerX) / centerX) * 6;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.018, 1.018, 1.018)`;
                    
                    const sheen = card.querySelector('.card-cursor-sheen');
                    if (sheen) {
                        sheen.style.opacity = '1';
                        sheen.style.setProperty('--mx', `${x}px`);
                        sheen.style.setProperty('--my', `${y}px`);
                    }
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
                    const sheen = card.querySelector('.card-cursor-sheen');
                    if (sheen) {
                        sheen.style.opacity = '0';
                    }
                });
            });

            // 4. Dynamic Multi-Color Particle Burst on Click
            document.addEventListener('click', (e) => {
                const colors = ['#2563EB', '#10B981', '#F97316', '#38BDF8'];
                const particleCount = 10;
                const clickX = e.clientX;
                const clickY = e.clientY;

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('span');
                    particle.className = 'click-particle';
                    
                    const size = Math.random() * 6 + 4; // 4px to 10px
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    const angle = (Math.PI * 2 * i) / particleCount + (Math.random() - 0.5);
                    const distance = Math.random() * 45 + 30; // 30px to 75px
                    const tx = Math.cos(angle) * distance;
                    const ty = Math.sin(angle) * distance;

                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    particle.style.backgroundColor = color;
                    particle.style.left = `${clickX - size / 2}px`;
                    particle.style.top = `${clickY - size / 2}px`;
                    particle.style.setProperty('--tx', `${tx}px`);
                    particle.style.setProperty('--ty', `${ty}px`);

                    document.body.appendChild(particle);

                    setTimeout(() => {
                        particle.remove();
                    }, 650);
                }
            });

            // 5. Live Social Proof Enterprise Activity Ticker
            const liveActivities = [
                { icon: 'fa-file-invoice-dollar', text: 'Shree Ram Textiles (Surat) processed 142 employee salaries in 4 mins', time: 'Just now' },
                { icon: 'fa-fingerprint', text: 'Apollo PolyClinic (Pune) clocked in 48 doctors & nurses via QR Kiosk', time: '1m ago' },
                { icon: 'fa-brands fa-whatsapp', text: 'Krishna Auto (Jaipur) dispatched 85 WhatsApp automated payslips', time: '2m ago' },
                { icon: 'fa-shield-halved', text: 'Vardhaman Logistics (Delhi NCR) generated EPFO ECR file with 0 errors', time: '3m ago' },
                { icon: 'fa-briefcase', text: 'FinEdge Advisory (Bangalore) closed ₹8.4L deal on Hisab Mittra CRM', time: 'Just now' }
            ];

            let activityIdx = 0;
            const toast = document.getElementById('live-activity-toast');
            const toastIcon = document.getElementById('toast-icon');
            const toastText = document.getElementById('toast-text');
            const toastTime = document.getElementById('toast-time');

            function showNextActivity() {
                if (!toast) return;
                const act = liveActivities[activityIdx];
                toastIcon.className = `fa-solid ${act.icon} text-sm`;
                toastText.textContent = act.text;
                toastTime.textContent = act.time;

                toast.classList.add('show');

                // Hide after 6 seconds
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 6000);

                activityIdx = (activityIdx + 1) % liveActivities.length;
            }

            // Start after 3.5 seconds, repeats every 16 seconds
            setTimeout(() => {
                showNextActivity();
                setInterval(showNextActivity, 16000);
            }, 3500);

            // 6. Auto-Enhance Cards & Feature Sections with Scroll Stagger
            const autoTargets = document.querySelectorAll(
                'section > div > div.grid > div, ' +
                '.glass-card, ' +
                '[class*="rounded-3xl bg-white"], ' +
                '[class*="rounded-2xl bg-white"], ' +
                '.shadow-luxury-card, ' +
                '.shadow-soft-elevation'
            );
            autoTargets.forEach((el, index) => {
                if (!el.classList.contains('motion-reveal') && !el.classList.contains('motion-fade-in') && !el.classList.contains('motion-slide-left') && !el.classList.contains('motion-slide-right')) {
                    el.classList.add('motion-reveal');
                    const delay = (index % 4) * 100;
                    if (delay > 0) {
                        el.classList.add(`delay-${delay}`);
                    }
                }
            });

            // 7. Auto Shimmer on Primary Action Buttons
            document.querySelectorAll('a[class*="bg-aqua"], button[class*="bg-aqua"], a[class*="bg-blue"], button[class*="bg-blue"], a[class*="bg-emerald"], button[class*="bg-emerald"]').forEach(btn => {
                btn.classList.add('btn-shimmer');
            });

            // 8. Intersection Observer for Scroll Reveals
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('motion-visible');
                        
                        // Trigger number counters inside this revealed element
                        const counters = entry.target.querySelectorAll('[data-counter]');
                        counters.forEach(runCounter);

                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.10,
                rootMargin: '0px 0px -30px 0px'
            });

            document.querySelectorAll('.motion-reveal, .motion-fade-in, .motion-slide-left, .motion-slide-right, [data-motion]').forEach(el => {
                revealObserver.observe(el);
            });

            // 9. Dynamic Count-Up Numbers Engine
            function runCounter(counterEl) {
                if (counterEl.dataset.counterDone) return;
                counterEl.dataset.counterDone = 'true';

                const rawText = counterEl.dataset.counter || counterEl.innerText.trim();
                const match = rawText.match(/^([^0-9]*)([0-9,.]+)(.*)$/);
                if (!match) return;

                const prefix = match[1] || '';
                const numStr = match[2].replace(/,/g, '');
                const suffix = match[3] || '';
                const target = parseFloat(numStr);
                if (isNaN(target)) return;

                const hasDecimals = numStr.includes('.');
                const decimalPlaces = hasDecimals ? numStr.split('.')[1].length : 0;
                const duration = 1600;
                const startTime = performance.now();

                function easeOutQuart(t) {
                    return 1 - Math.pow(1 - t, 4);
                }

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easedProgress = easeOutQuart(progress);
                    const currentVal = target * easedProgress;

                    let formattedNum = hasDecimals 
                        ? currentVal.toFixed(decimalPlaces) 
                        : Math.round(currentVal).toLocaleString('en-IN');

                    counterEl.innerText = `${prefix}${formattedNum}${suffix}`;

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counterEl.innerText = rawText;
                    }
                }

                requestAnimationFrame(updateCounter);
            }

            document.querySelectorAll('[data-counter]').forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    runCounter(el);
                }
            });

            // 10. Interactive Click Ripple Effect on Buttons
            document.addEventListener('click', (e) => {
                const target = e.target.closest('.btn-shimmer, .btn-ripple, button, a.rounded-2xl');
                if (!target) return;

                const rect = target.getBoundingClientRect();
                const ripple = document.createElement('span');
                const diameter = Math.max(rect.width, rect.height);
                const radius = diameter / 2;

                ripple.style.width = ripple.style.height = `${diameter}px`;
                ripple.style.left = `${e.clientX - rect.left - radius}px`;
                ripple.style.top = `${e.clientY - rect.top - radius}px`;
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.35)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'rippleMotion 0.6s linear';
                ripple.style.pointerEvents = 'none';

                target.style.position = target.style.position || 'relative';
                target.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });

        });
    </script>
    @yield('extra_js')
</body>
</html>
