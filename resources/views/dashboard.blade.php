@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="rounded-lg bg-blue-600 px-6 py-8 sm:px-8 sm:py-10">
        <p class="text-sm font-medium text-blue-200">Dashboard</p>
        <h2 class="mt-2 text-2xl font-semibold text-white sm:text-3xl">Selamat datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-3 max-w-2xl text-sm text-blue-100">
            Selamat datang di LibraLite, sistem manajemen perpustakaan Anda.
            Pilih menu di samping untuk mulai mengelola data perpustakaan.
        </p>
    </div>
@endsection
