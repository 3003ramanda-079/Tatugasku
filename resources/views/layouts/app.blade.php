<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul', 'Tugas') - TugasKu</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
@php $jmlPengingat = \App\Models\Reminder::jatuhTempo()->count(); @endphp
<header>
    <h1>📚 TugasKu</h1>
    <p>Satu tempat untuk semua tugas kuliahmu — tidak ada lagi deadline yang terlewat.</p>
</header>
<nav class="nav">
    <a href="{{ route('tugas.index') }}" class="{{ request()->routeIs('tugas.*') ? 'active' : '' }}">Tugas</a>
    <a href="{{ route('matkul.index') }}" class="{{ request()->routeIs('matkul.*') ? 'active' : '' }}">Mata Kuliah</a>
    <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">Pengguna</a>
    <a href="{{ route('pengingat.index') }}" class="{{ request()->routeIs('pengingat.*') ? 'active' : '' }}">Pengingat{{ $jmlPengingat > 0 ? " ({$jmlPengingat})" : '' }}</a>
</nav>
<div class="container">
    @if (session('success'))
        <div class="card">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert">
            @foreach ($errors->all() as $pesan)
                <div>{{ $pesan }}</div>
            @endforeach
        </div>
    @endif

    @yield('isi')
</div>
</body>
</html>
