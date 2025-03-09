<style>
    .navbar {
    background-color: #000;
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
    .navbar .order-btn {
        background-color: #ffc107;
        color: #000;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
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
            <button class="order-btn">Login</button>
        </a>
    </div>    
</div>