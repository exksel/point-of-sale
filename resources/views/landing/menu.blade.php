@extends('layouts.landing')

@section('title', 'Menu')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>
<style>
    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: "Montserrat", sans-serif;
    }

    html, body {
        margin: 0;
        padding: 0;
        background-color: #f3d3b3; /* Sama dengan warna akhir gradien */
        font-family: "Montserrat", sans-serif;
    }

    #menu-section {
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .gradient-subtext {
        background: linear-gradient(90deg, #1f4a4a 0%, #3a7a7a 50%, #1f4a4a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
    }
</style>

{{-- Menu Section --}}
<div id="menu-section" class="w-full py-20 px-6 sm:px-12 lg:px-24"
    style="background: linear-gradient(180deg, #d3c9be 0%, #f3d3b3 100%)">
    
    <div class="mb-12 text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold gradient-subtext mb-3">Our Best Menu</h1>
        <div class="flex flex-wrap justify-center gap-2 text-xs sm:text-sm font-semibold tracking-widest gradient-subtext">
            <span>TASTE THE FRESHNESS</span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
        @foreach ($products as $product)
            <div class="bg-[#f0e4d7] rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300 transform hover:scale-[1.03] text-center border border-[#e3d5c5]">
                <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-[#7dbbaf] shadow">
                    @php
                        $defaultImage = 'https://placehold.jp/50/c0c0c0/808080/1024x1024.png?text=Es+Teh+Desa';
                    @endphp
                    <img src="{{ asset($product->image ?? $defaultImage) }}"
                         onerror="this.onerror=null;this.src='{{ $defaultImage }}';"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                </div>

                <h2 class="text-xl font-bold text-[#1f4a4a]">{{ $product->name }}</h2>
                <p class="text-sm text-[#3a7a7a] font-medium mt-1 mb-3">
                    Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-700 leading-relaxed">
                    {{ $product->description }}
                </p>
            </div>
        @endforeach
    </div>
    <div class="h-10"></div> <!-- Spacer 40px -->
</div>
@endsection
