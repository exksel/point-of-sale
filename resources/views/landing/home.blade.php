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
          overflow: hidden;
      }
      .container::before {
          content: "";
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(0, 0, 0, 0.6);
          z-index: 1;
      }
      .text-content, .image-content {
          position: relative;
          z-index: 2;
      }
      .text-content {
          max-width: 50%;
          animation: fadeInLeft 1s ease-in-out;
      }
      .text-content h1 {
          font-size: 52px;
          margin: 0 0 20px 0;
          font-weight: 700;
          text-transform: uppercase;
          letter-spacing: 2px;
      }
      .text-content p {
          font-size: 20px;
          margin-bottom: 20px;
          line-height: 1.6;
      }
      .btn {
          background: linear-gradient(45deg, #FFA500, #FF4500);
          color: white;
          padding: 15px 30px;
          text-decoration: none;
          font-size: 18px;
          border-radius: 30px;
          font-weight: bold;
          transition: all 0.3s ease-in-out;
          display: inline-block;
          box-shadow: 0 4px 10px rgba(255, 69, 0, 0.5);
      }
      .btn:hover {
          transform: scale(1.1);
          background: linear-gradient(45deg, #FF4500, #FFA500);
      }
      .image-content {
          animation: fadeInRight 1s ease-in-out;
      }
      .image-content img {
          max-width: 100%;
          height: auto;
          border-radius: 50%;
          transition: transform 0.3s ease-in-out;
      }
      .image-content img:hover {
          transform: scale(1.05);
      }

      /* Animations */
      @keyframes fadeInLeft {
          from {
              opacity: 0;
              transform: translateX(-50px);
          }
          to {
              opacity: 1;
              transform: translateX(0);
          }
      }
      @keyframes fadeInRight {
          from {
              opacity: 0;
              transform: translateX(50px);
          }
          to {
              opacity: 1;
              transform: translateX(0);
          }
      }
  </style>

  <div class="container">
      <div class="text-content">
          <h1>Enjoy Our Delicious Beverages</h1>
          <p>Temukan sensasi kesegaran yang tak terlupakan dengan minuman pilihan terbaik kami.</p>
          <a class="btn" href="{{ route('menu') }}">OUR MENU</a>
      </div>
      <div class="image-content">
          <img alt="Ice Tea" src="{{ asset('images/icetea.png') }}" width="800"/>
      </div>
  </div>
@endsection
