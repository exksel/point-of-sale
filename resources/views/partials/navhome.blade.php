<style>
    .navbar {
        background-color: transparent;
        font-family: 'Roboto', sans-serif;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: absolute;
        top: 0;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        z-index: 1000;
    }

    .navbar .logo {
        font-family: 'Great Vibes', cursive;
        font-size: 24px;
        color: #1f4a4a;
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
        color: #1f4a4a;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: color 0.3s;
    }

    .navbar ul li a:hover,
    .navbar ul li a.active {
        color: #3a7a7a;
    }

    .navbar .icons {
        display: flex;
        align-items: center;
    }

    .navbar .icons i {
        color: #1f4a4a;
        margin: 0 10px;
        cursor: pointer;
    }

    .navbar .btn {
        background: linear-gradient(45deg, #7dbbaf, #3a7a7a);
        color: white;
        padding: 7px 15px;
        text-decoration: none;
        font-size: 13px;
        border-radius: 30px;
        font-weight: bold;
        transition: all 0.3s ease-in-out;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(61, 110, 110, 0.3);
        border: none;
    }

    .navbar .btn:hover {
        transform: scale(1.1);
        background: linear-gradient(45deg, #3a7a7a, #7dbbaf);
    }
</style>

<div class="navbar">
    <div class="logo">EsTeh Desa</div>
    <ul>
        <li><a href="{{ route('home') }}" class="{{ Request::is('/') || Request::is('home') ? 'active' : '' }}">HOME</a></li>
        <li><a href="{{ route('menu') }}" class="{{ Request::is('menu*') ? 'active' : '' }}">MENU</a></li>
        <li><a href="{{ route('aboutus') }}" class="{{ Request::is('aboutus*') ? 'active' : '' }}">ABOUT US</a></li>
    </ul>
    <div class="icons">
        <a href="{{ route('login') }}">
            <button class="btn btn-login">Login</button>
        </a>
    </div>    
</div>
