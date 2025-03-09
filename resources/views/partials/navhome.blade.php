
<style>
    .navbar {
    background-color: #000;
    font-family: 'Roboto', sans-serif;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    }
    .navbar .logo {
        font-family: 'Great Vibes', cursive;
        font-size: 24px;
        color: #fff;
    }
    .navbar ul {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0;
    }
    .navbar ul li {
        margin: 0 15px;
    }
    .navbar ul li a {
        color: #fff;
        text-decoration: none;
        font-size: 16px;
    }
    .navbar ul li a:hover {
        color: #ffc107;
    }
    .navbar .icons {
        display: flex;
        align-items: center;
    }
    .navbar .icons i {
        color: #fff;
        margin: 0 10px;
        cursor: pointer;
    }
    .navbar .btn {
          background: linear-gradient(45deg, #FFA500, #FF4500);
          color: white;
          padding: 7px 15px;
          text-decoration: none;
          font-size: 13px;
          border-radius: 30px;
          font-weight: bold;
          transition: all 0.3s ease-in-out;
          display: inline-block;
          box-shadow: 0 4px 10px rgba(255, 69, 0, 0.5);
      }
      .navbar .btn:hover {
          transform: scale(1.1);
          background: linear-gradient(45deg, #FF4500, #FFA500);
      }
</style>
<div class="navbar">
    <div class="logo">Es Teh</div>
    <ul>
        <li><a href="{{ route('home') }}" class="{{ Request::is('home') ? 'active' : '' }}">HOME</a></li>
        <li><a href="{{ route('menu') }}" class="{{ Request::is('menu') ? 'active' : '' }}">MENU</a></li>
        <li><a href="#">ABOUT</a></li>
    </ul>
    <div class="icons">
        <a href="{{ route('login') }}">
            <button class="btn btn-login">Login</button>
        </a>
    </div>    
</div>