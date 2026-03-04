@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">User Dashboard</h1>
        <p class="text-gray-600 text-sm md:text-base mt-1">Welcome back, <span class="font-semibold text-indigo-600">{{ auth()->user()->name }}</span>!</p>
    </div>

    <!-- Today's Status Card -->
    <div class="bg-white rounded-lg overflow-hidden">
        
        <div class="p-4 md:p-6">
            @isset($todayAttendance)
                @if($todayAttendance)
                    <div class="flex items-center space-x-3 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="bg-green-100 rounded-full p-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-green-800 font-medium">You marked attendance today</p>
                            <p class="text-green-600 text-sm">Status: <span class="font-semibold">{{ ucfirst($todayAttendance->status) }}</span></p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-3 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="bg-yellow-100 rounded-full p-2">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-yellow-800 font-medium">You have not marked attendance today</p>
                            <p class="text-yellow-600 text-sm">Please check in to start your day</p>
                        </div>
                    </div>
                @endif
            @endisset
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Check In/Out Card -->
    <div class="bg-white rounded-lg mb-6 overflow-hidden">
       
        
        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Check In Form -->
                <form method="POST" action="{{ route('attendances.mark') }}" class="flex-1">
                    @csrf
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <p class="text-gray-900 font-medium text-lg">Check In</p>
                                <p class="text-gray-500 text-sm">Start your work day</p>
                            </div>
                            <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Check In Now
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Check Out Button -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-gray-900 font-medium text-lg">Check Out</p>
                            <p class="text-gray-500 text-sm">End your work day</p>
                        </div>
                        <button disabled class="w-full sm:w-auto px-6 py-2 bg-red-400 text-white font-medium rounded-lg cursor-not-allowed opacity-60">
                            Check Out
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-4 py-3">
            <h2 class="text-white font-semibold text-lg">Monthly Statistics</h2>
        </div>
        
        <div class="p-4 md:p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                <!-- Present Card -->
                <div class="bg-green-50 rounded-lg p-3 md:p-4 border border-green-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-600 text-xs md:text-sm font-medium">Present</p>
                            <p class="text-xl md:text-2xl font-bold text-green-700">{{ $attendances->where('status', 'present')->count() ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 p-2 md:p-3 rounded-full">
                            <svg class="w-4 h-4 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Late Card -->
                <div class="bg-yellow-50 rounded-lg p-3 md:p-4 border border-yellow-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-600 text-xs md:text-sm font-medium">Late</p>
                            <p class="text-xl md:text-2xl font-bold text-yellow-700">{{ $attendances->where('status', 'late')->count() ?? 0 }}</p>
                        </div>
                        <div class="bg-yellow-100 p-2 md:p-3 rounded-full">
                            <svg class="w-4 h-4 md:w-6 md:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Absent Card -->
                <div class="bg-red-50 rounded-lg p-3 md:p-4 border border-red-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-600 text-xs md:text-sm font-medium">Absent</p>
                            <p class="text-xl md:text-2xl font-bold text-red-700">{{ $attendances->where('status', 'absent')->count() ?? 0 }}</p>
                        </div>
                        <div class="bg-red-100 p-2 md:p-3 rounded-full">
                            <svg class="w-4 h-4 md:w-6 md:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Days Card -->
                <div class="bg-blue-50 rounded-lg p-3 md:p-4 border border-blue-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-600 text-xs md:text-sm font-medium">Total Days</p>
                            <p class="text-xl md:text-2xl font-bold text-blue-700">{{ $attendances->count() ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-100 p-2 md:p-3 rounded-full">
                            <svg class="w-4 h-4 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection