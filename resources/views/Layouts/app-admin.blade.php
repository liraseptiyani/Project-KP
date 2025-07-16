<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Aplikasi Saya')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
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
            height: 70px;
            box-sizing: border-box;
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
            font-weight: 600;
            text-transform: uppercase;
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
            min-width: 120px;
            justify-content: center;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            width: 100%;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            border-radius: 20px;
            z-index: 1001;
            overflow: hidden;
        }

        .dropdown-content a {
            color: #388E3C;
            padding: 6px 12px;
            text-decoration: none;
            display: block;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }

        .arrow {
            transition: transform 0.3s ease;
            font-size: 14px;
        }

        .rotate-down {
            transform: rotate(180deg);
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

        .sidebar ul li.dropdown-menu > a {
            cursor: pointer;
        }

        .sidebar ul li ul.submenu {
            display: none;
            background-color: #388e3c;
        }

        .sidebar ul li ul.submenu li a {
            padding: 12px 40px;
        }

        .sidebar ul li.dropdown-menu.open ul.submenu {
            display: block;
        }

        .content {
            margin-left: 220px;
            padding: 85px 30px 30px;
            box-sizing: border-box;
        }

        /* Modal Logout */
        #logoutModal {
            display: none;
            position: fixed;
            z-index: 2000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
        }

        #logoutModal .modal-content {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            max-width: 400px;
            text-align: center;
        }

        #logoutModal button {
            margin: 5px;
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        #logoutModal .yes-btn {
            background-color: #388E3C;
            color: white;
        }

        #logoutModal .no-btn {
            background-color: #ccc;
            color: black;
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
                {{ Auth::user()->role ?? 'Admin' }} <i class="fas fa-caret-down"></i>
            </button>
            <div class="dropdown-content" id="dropdownContent">
                <a href="#" onclick="event.preventDefault(); openLogoutModal();">Keluar</a>
            </div>
        </div>
    </div>
</header>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- Modal Logout -->
<div id="logoutModal">
    <div class="modal-content">
        <p style="font-weight: bold; margin-bottom: 20px;">Apakah Anda yakin ingin keluar?</p>
        <button class="yes-btn" onclick="confirmLogout()">Yes</button>
        <button class="no-btn" onclick="closeLogoutModal()">No</button>
    </div>
</div>

<aside class="sidebar">
    <ul>
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}"><span>Dashboard</span></a>
</li>

        <li class="dropdown-menu {{ request()->is('jenis*') || request()->is('satuan*') || request()->is('lokasi*') || request()->is('barang*') ? 'open' : '' }}">
            <a href="javascript:void(0)" onclick="toggleDropdown(this)" style="display: flex; align-items: center; gap: 8px;">
                <span>Master Barang</span>
                <i class="fas fa-caret-down arrow"></i>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('jenis.index') }}">Jenis</a></li>
                <li><a href="{{ route('satuan.index') }}">Satuan</a></li>
                <li><a href="{{ route('lokasi.index') }}">Lokasi</a></li>
                <li><a href="{{ route('barang.index') }}">Barang</a></li>
            </ul>
        </li>


        <li class="{{ request()->routeIs('barangmasuk.index') ? 'active' : '' }}">
            <a href="{{ route('barangmasuk.index') }}"><span>Barang Masuk</span></a>
        </li>
        <li class="{{ request()->routeIs('barangkeluar.index') ? 'active' : '' }}">
            <a href="{{ route('barang-keluar.index') }}"><span>Barang Keluar</span></a>
        </li>
        <li class="{{ request()->routeIs('databarang.index') ? 'active' : '' }}">
            <a href="{{ route('databarang.index') }}"><span>Data Barang</span></a>
        </li>
        <li class="{{ request()->routeIs('pengajuan.index') ? 'active' : '' }}">
            <a href="{{ route('admin.pengajuan.index') }}"><span>Pengajuan</span></a>
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

    function toggleDropdown(element) {
        const parent = element.closest('li');
        parent.classList.toggle('open');
        const arrow = element.querySelector('.arrow');
        arrow.classList.toggle('rotate-down', parent.classList.contains('open'));
    }

    function openLogoutModal() {
        document.getElementById('logoutModal').style.display = 'flex';
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }

    function confirmLogout() {
        document.getElementById('logout-form').submit();
    }
</script>

@stack('scripts')

</body>
</html>
