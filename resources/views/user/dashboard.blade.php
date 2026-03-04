@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')

<h1 class="text-3xl font-bold mb-6">User Dashboard</h1>

<div class="bg-white p-6 rounded shadow w-1/2">
    <h2 class="text-xl font-semibold mb-4">My Attendance Status</h2>

    @if($todayAttendance)
    <div class="text-green-700 font-semibold">
         You marked attendance today as: {{ $todayAttendance->status }}
    </div>
@else
    <div class="text-red-700 font-semibold">
         You have not marked attendance today.
    </div>
@endif
    <div class="card md:col-span-2">
    <h3 class="section-header">Today's Attendance</h3>
    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('attendances.mark') }}">
            @csrf
            <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div>
                    <p class="text-gray-900 font-medium">Check In</p>
                    <p class="text-gray-500 text-sm">Start your work day</p>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Check In
                </button>
                
            </div>
            @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

        <!-- Display error message -->
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
        </form>
        
        <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg">
            <div>
                <p class="text-gray-900 font-medium">Check Out</p>
                <p class="text-gray-500 text-sm">End your work day</p>
            </div>
            <button disabled class="px-4 py-2 bg-red-400 text-white font-medium rounded-lg cursor-not-allowed opacity-60">
                Check Out
            </button>
        </div>
    </div>
</div>
</div>

@endsection