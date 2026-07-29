<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>YELI — Your English Learning Interface</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.7s ease-out forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.25s;
        }

        .delay-3 {
            animation-delay: 0.4s;
        }

        .delay-4 {
            animation-delay: 0.55s;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center bg-[#FDF6E9] text-[#1c2438] px-4">

    <div class="text-center mb-10">
        <img src="{{ asset('/images/logo-yeli.png') }}" alt="YELI Logo" class="h-16 mx-auto mb-4 fade-in-up delay-1">

        <h1 class="text-4xl font-bold tracking-tight fade-in-up delay-2">YELI</h1>

        <p class="text-[#F0AD18] font-semibold tracking-widest text-sm mt-1 fade-in-up delay-2">
            YOUR ENGLISH LEARNING INTERFACE
        </p>

        <p class="text-slate-600 mt-4 max-w-md mx-auto fade-in-up delay-3">
            Welcome to YELI App! 👋 <br />
            Please, select your role before login to application
        </p>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 fade-in-up delay-4">
        <a href="{{ route('filament.student.pages.dashboard') }}"
            class="px-8 py-3 rounded-full bg-[#F0AD18] text-[#1c2438] font-semibold text-center hover:opacity-90 hover:scale-105 transition">
            Student
        </a>

        <a href="{{ route('filament.lecturer.pages.dashboard') }}"
            class="px-8 py-3 rounded-full border border-[#1c2438]/30 text-[#1c2438] font-semibold text-center hover:bg-[#1c2438]/5 hover:scale-105 transition">
            Lecturer
        </a>
    </div>

</body>

</html>
