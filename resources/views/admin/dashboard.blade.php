@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

<div class="grid grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold">Total Users</h2>
        <p class="text-3xl mt-3">25</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold">Total Present</h2>
        <p class="text-3xl mt-3">18</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold">Total Absent</h2>
        <p class="text-3xl mt-3">7</p>
    </div>

</div>

@endsection