@extends('layouts.landing')

@section('title', 'About Us')

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

        /* Gradient text for the subtext */
        .gradient-subtext {
            background: linear-gradient(90deg, #1f4a4a 0%, #3a7a7a 50%, #1f4a4a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
    </style>

    <div class="relative min-h-screen flex flex-col items-center justify-center text-center"
        style="background: linear-gradient(180deg, #d3c9be 0%, #f3d3b3 100%)">
        <main class="w-full flex-1 flex flex-col items-center justify-center px-4 sm:px-6 md:px-8 lg:px-10 xl:px-12 mt-24"
            style="max-width: 1200px; margin: 0 auto;">
            <div class="w-full flex justify-center">
                <h1 aria-label="Zero Impact"
                    class="gradient-text text-[8rem] sm:text-[10rem] md:text-[11rem] lg:text-[12rem] xl:text-[13rem] font-extrabold leading-[0.9] select-none text-center"
                    style="font-feature-settings: 'liga' off">
                    Know Us
                </h1>
            </div>
            <div class="mt-12 flex flex-wrap justify-center gap-3 gradient-subtext text-xs sm:text-sm font-semibold tracking-widest select-none text-center">
                Es Teh Desa hadir bukan hanya sebagai penyaji minuman, melainkan sebagai penghubung antara rasa, kenangan, dan nilai tradisi. Kami berkomitmen menghadirkan kesegaran alami melalui teh khas pedesaan yang diracik dengan bahan-bahan pilihan dan disajikan secara tradisional.
                Kami percaya bahwa dalam kesederhanaan terdapat cita rasa yang otentik dan memuaskan. Setiap gelas es teh membawa pengalaman yang membangkitkan nostalgia, menghadirkan kehangatan kampung halaman, serta menciptakan momen tenang di tengah hiruk pikuk kehidupan. 
                Es Teh Desa bukan sekadar minuman ini adalah rasa, cerita, dan pengalaman yang tulus dari desa untuk Anda.
            </div>
            <div class="flex justify-center">
                <div class="mt-16 inline-flex items-center justify-center px-8 py-3 border border-[#1f4a4a] text-[#1f4a4a] text-sm font-semibold tracking-widest rounded-full"
                    style="font-feature-settings: 'liga' off;">
                    <i class="fab fa-whatsapp mr-2"></i> 0877-2527-4082
                </div>
            </div>

        </main>

    </div>
@endsection
