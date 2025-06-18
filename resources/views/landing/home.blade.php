@extends('layouts.landing')

@section('title', 'Home')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: "Montserrat", sans-serif;
        }

        .gradient-text {
            background: linear-gradient(180deg, #7dbbaf 0%, #a3d1c9 50%, #7dbbaf 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            position: relative;
        }

        .gradient-subtext {
            background: linear-gradient(90deg, #1f4a4a 0%, #3a7a7a 50%, #1f4a4a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        .leaf-icon {
            position: absolute;
            z-index: 50;
            width: 90px;
            height: auto;
            opacity: 0.9;
        }

        @media (min-width: 768px) {
            .leaf-icon {
                width: 110px;
            }
        }
    </style>

    <div class="relative min-h-screen flex flex-col items-center justify-center text-center"
        style="background: linear-gradient(180deg, #d3c9be 0%, #f3d3b3 100%)">
        
        
        <main class="w-full flex-1 flex flex-col items-center justify-center px-4 sm:px-6 md:px-8 lg:px-10 xl:px-12 mt-24"
            style="max-width: 1200px; margin: 0 auto;">
            
            <div class="w-full flex justify-center relative">
                {{-- Gambar Es Teh DI BELAKANG TULISAN --}}
                <img src="{{ asset('images/es teh.png') }}" alt="Es Teh"
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] max-w-[90vw] opacity-70 z-0 pointer-events-none select-none" />

                {{-- Leaf at top-right of the title --}}
                <img src="{{ asset('images/leaf.png') }}" alt="Leaf Top Right"
                    class="leaf-icon right-[-5px] top-[-10px] rotate-[15deg]">

                {{-- Leaf at bottom-left of the title --}}
                <img src="{{ asset('images/leaf.png') }}" alt="Leaf Bottom Left"
                    class="leaf-icon left-[-40px] bottom-[-50px] rotate-[-160deg]">

                <h1 aria-label="Title"
                    class="gradient-text text-[8rem] sm:text-[10rem] md:text-[11rem] lg:text-[12rem] xl:text-[13rem] font-extrabold leading-[0.9] select-none text-center"
                    style="font-feature-settings: 'liga' off">
                    Rooted in Freshness
                </h1>
            </div>

            <div
                class="mt-12 flex flex-wrap justify-center gap-3 gradient-subtext text-xs sm:text-sm font-semibold tracking-widest select-none text-center">
                <span>HOME BREWED</span>
                <span>·</span>
                <span>AUTHENTIC TASTE</span>
                <span>·</span>
                <span>100% FRESH</span>
            </div>

            <div class="flex justify-center">
                <a href="{{ route('menu') }}" aria-label="Discover"
                    class="mt-16 inline-flex items-center justify-center px-8 py-3 border border-[#1f4a4a] text-[#1f4a4a] text-sm font-semibold tracking-widest rounded-full hover:scale-105 transition-transform duration-300"
                    style="font-feature-settings: 'liga' off; text-decoration: none;">
                    EXPLORE MENU
                </a>
            </div>
        </main>
    </div>
@endsection
