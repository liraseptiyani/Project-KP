<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Divisi | Pengajuan Barang')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .topbar {
            background-color: #388E3C;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            justify-content: space-between;
            box-sizing: border-box;
            height: 70px;
        }

        .topbar .left {
            display: flex;
            align-items: center;
        }

        .topbar img {
            height: 40px;
            margin-right: 15px;
        }

        .topbar h1 {
            font-size: 20px;
            margin: 0;
            font-weight: normal;
        }

        .user-role-container {
            padding-right: 20px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .user-role {
            background-color: white;
            color: #388E3C;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 140px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            border-radius: 5px;
            z-index: 1001;
        }

        .dropdown-content a {
            color: #388E3C;
            padding: 10px 16px;
            text-decoration: none;
            display: block;
            font-weight: bold;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }

        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 220px;
            height: calc(100vh - 70px);
            background-color: #2E7D32;
            padding-top: 20px;
            color: white;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .sidebar ul li a:hover,
        .sidebar ul li.active > a {
            background-color: #1B5E20;
        }

        .content {
            margin-left: 220px;
            padding: 85px 30px 30px 30px;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                padding-top: 10px;
            }
            .sidebar ul li a {
                padding: 12px 10px;
                font-size: 12px;
                text-align: center;
            }
            .sidebar ul li a span {
                display: none;
            }
            .content {
                margin-left: 60px;
                padding: 85px 15px 15px 15px;
            }
        }

        @media (max-width: 480px) {
            .topbar h1 {
                font-size: 16px;
            }
            .topbar img {
                height: 30px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<header class="topbar">
    <div class="left">
        <img src="{{ asset('images/logo tel.png') }}" alt="Logo" />
        <h1>PT TANJUNGENIM LESTARI PULP AND PAPER</h1>
    </div>
    <div class="user-role-container">
        <div class="dropdown" id="userDropdown">
            <button class="user-role" id="userRoleBtn">
                Divisi {{ Auth::user()->username }} <i class="fas fa-caret-down"></i>
            </button>
            <div class="dropdown-content" id="dropdownContent">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
            </div>
        </div>
    </div>
</header>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<aside class="sidebar">
    <ul>
        <li class="{{ request()->routeIs('pengajuan.index') ? 'active' : '' }}">
            <a href="{{ route('pengajuan.index') }}"><span>Pengajuan Barang</span></a>
        </li>
    </ul>
</aside>

<main class="content">
    @yield('content')
</main>

<script>
    const userRoleBtn = document.getElementById('userRoleBtn');
    const dropdown = document.getElementById('userDropdown');

    userRoleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    document.addEventListener('click', () => {
        dropdown.classList.remove('show');
    });
</script>

@stack('scripts')

</body>
</html>
