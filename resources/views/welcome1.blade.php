<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rynow Infotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://rynow.in/public/favicon.ico" type="image/x-icon">

    <style>
    .fade {
        animation: fadeIn 1.2s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bg-waves {
        background:
            radial-gradient(circle at 20% 20%, #d8f3ff 0%, transparent 45%),
            radial-gradient(circle at 80% 10%, #ffe4ff 0%, transparent 50%),
            radial-gradient(circle at 0% 80%, #e8ffe6 0%, transparent 50%),
            radial-gradient(circle at 100% 90%, #fff3d4 0%, transparent 55%);
    }

    .glow-text {
        text-shadow: 0 0 15px rgba(80, 80, 255, 0.3);
    }

    .underline-anim {
        background-size: 200% 3px;
        background-position: 0 100%;
        background-repeat: no-repeat;
        padding-bottom: 3px;
        transition: background-position 0.5s ease;
    }

    .underline-anim:hover {
        background-position: 100% 100%;
    }

    /* BG Animation */
    .bg-animated {
        background: radial-gradient(circle at 20% 20%, #d8faff, transparent 60%),
            radial-gradient(circle at 80% 10%, #ffe0ff, transparent 60%),
            radial-gradient(circle at 0% 90%, #e5ffe3, transparent 60%),
            radial-gradient(circle at 100% 90%, #fff3d4, transparent 60%);
        animation: bgMove 12s ease-in-out infinite alternate;
    }

    @keyframes bgMove {
        0% {
            background-position: 0 0, 100% 0, 0 100%, 100% 100%;
        }

        100% {
            background-position: 10% 10%, 90% 20%, 5% 80%, 85% 90%;
        }
    }
    </style>

    <style>
    /* Full Button Zoom In / Zoom Out Animation */
    .zoom-anim {
        animation: zoomInOut 2.2s ease-in-out infinite;
        transform-origin: center;
    }

    @keyframes zoomInOut {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.12);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Optional hover effect */
    .zoom-anim:hover {
        transform: scale(1.17);
        transition: 0.3s ease;
    }
    </style>

</head>

<body class="bg-white bg-waves text-gray-900 font-sans">

    <section class="min-h-screen flex flex-col justify-center items-center text-center px-6 fade">

        <!-- Gradient, Glow Title -->
        <h1 class="text-4xl md:text-5xl font-extrabold glow-text 
      bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 
      text-transparent bg-clip-text">
            Welcome to Rynow Infotech
        </h1>

        <p class="text-gray-800 mt-3 text-lg md:text-xl tracking-wide">
            Smart Digital & CRM Solutions for Growing Businesses
        </p>

        <!-- About Text with animated underline -->
        <p class="mt-6 max-w-3xl text-gray-800 text-lg leading-relaxed">
            We build powerful
            <span
                class="font-bold underline-anim bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 bg-[length:100%_3px] bg-bottom bg-no-repeat text-blue-700">
                CRM Systems, Websites, Mobile Apps & Digital Marketing Solutions
            </span>
            to automate operations and scale your business faster.
        </p>

        <!-- Colorful Service Tags -->
        <div class="flex flex-wrap justify-center gap-4 mt-10 text-base font-semibold">

            <span class="px-6 py-2 rounded-full 
       bg-gradient-to-r from-blue-300 to-blue-400 text-white shadow-lg shadow-blue-200">
                CRM Solutions
            </span>

            <span class="px-6 py-2 rounded-full 
       bg-gradient-to-r from-indigo-300 to-indigo-400 text-white shadow-lg shadow-indigo-200">
                Web & App Dev
            </span>

            <span class="px-6 py-2 rounded-full 
       bg-gradient-to-r from-pink-300 to-purple-400 text-white shadow-lg shadow-pink-200">
                Digital Marketing
            </span>

            <span class="px-6 py-2 rounded-full 
       bg-gradient-to-r from-green-300 to-green-400 text-white shadow-lg shadow-green-200">
                Custom Software
            </span>

        </div>

        <!--  Videos -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 w-full max-w-5xl">
            <iframe class="w-full h-28 md:h-32 rounded-xl shadow-xl" src="https://www.youtube.com/embed/eTTXci9WVRQ"
                allowfullscreen></iframe>

            <iframe class="w-full h-28 md:h-32 rounded-xl shadow-xl" src="https://www.youtube.com/embed/eTTXci9WVRQ"
                allowfullscreen></iframe>

            <iframe class="w-full h-28 md:h-32 rounded-xl shadow-xl" src="https://www.youtube.com/embed/eTTXci9WVRQ"
                allowfullscreen></iframe>

            <iframe class="w-full h-28 md:h-32 rounded-xl shadow-xl" src="https://www.youtube.com/embed/eTTXci9WVRQ"
                allowfullscreen></iframe>
        </div>
        <a href="{{ url('login') }}" class="zoom-anim inline-flex items-center mt-14 px-14 py-3 rounded-full text-white text-lg font-bold
  bg-gradient-to-r from-green-500 via-emerald-500 to-lime-500">
            🔐 Login to CRM
        </a>



        <!-- Contact -->
        <div class="mt-6 text-sm text-gray-800">
            📞 +91-9999-691410 | +91-7982-688494 <br>
            📧 <a href="mailto:pankaj@rynow.in" class="text-blue-700 font-semibold hover:underline">pankaj@rynow.in</a>
        </div>

        <!-- Footer -->
        <p class="text-xs text-gray-600 mt-8">
            © 2025 Rynow Infotech ·
            <a href="https://rynow.in" class="text-blue-600 hover:underline">rynow.in</a>
        </p>

    </section>
</body>

</html>