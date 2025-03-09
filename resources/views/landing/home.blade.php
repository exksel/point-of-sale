@extends('layouts.landing')

@section('title', 'Home')

@section('content')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px;
            background: url('{{ asset("images/home.jpg") }}') no-repeat center center/cover;
            color: white;
            height: 100vh;
            box-sizing: border-box;
            position: relative;
        }
        /* Overlay agar background lebih gelap */
        .container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7); /* Overlay lebih gelap */
            z-index: 1;
        }
        /* Pastikan teks dan gambar tetap terang di atas overlay */
        .text-content, .image-content {
            position: relative;
            z-index: 2; /* Supaya tetap terlihat jelas */
        }
        .text-content {
            max-width: 50%;
        }
        .text-content h1 {
            font-size: 48px;
            margin: 0 0 20px 0;
        }
        .text-content p {
            font-size: 18px;
            margin: 0 0 20px 0;
        }
        .text-content .btn {
            background-color: #FFA500;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .image-content img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
        }
  </style>
  <div class="container">
   <div class="text-content">
    <h1>Enjoy Our Delicious Beverages</h1>
    <p>Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos.</p>
    <a class="btn" href="{{ route('menu') }}" class="{{ Request::is('menu') ? 'active' : '' }}">OUR MENU</a>
   </div>
   <div class="image-content">
    <img alt="Ice Tea" src="{{ asset('images/icetea.png') }}" width="800"/>
   </div>
  </div>
@endsection
