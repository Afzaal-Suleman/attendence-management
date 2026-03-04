@extends('layouts.app')

@section('title', 'My Attendance')

@section('content')
<div class="container mx-auto px-4 py-4">
    <!-- Header with user info -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Attendance</h1>
            <p class="text-gray-600 text-sm">Welcome back, <span class="font-semibold text-indigo-600">{{ auth()->user()->name }}</span>!</p>
        </div>
        <div class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-lg text-sm">
            <span class="font-semibold">{{ date('F Y') }}</span>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col" style="height: calc(100vh - 180px);">
        <div class="px-4 py-3 bg-gray-50 border-b flex-shrink-0">
            <h2 class="text-lg font-semibold text-gray-800">Monthly Attendance Calendar</h2>
        </div>
        
        <!-- Scrollable Calendar Container -->
        <div class="overflow-y-auto flex-1 p-4">
            <!-- Month Navigation -->
            {{-- <div class="flex justify-between items-center mb-3">
                <div class="flex space-x-1">
                    <button class="p-1 rounded-lg bg-gray-100 hover:bg-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <span class="font-semibold text-gray-700 px-2 py-1 text-sm">{{ now()->format('F Y') }}</span>
                    <button class="p-1 rounded-lg bg-gray-100 hover:bg-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- View Toggle -->
                <div class="flex space-x-1 bg-gray-100 rounded-lg p-0.5">
                    <button class="px-2 py-0.5 text-xs rounded-md bg-white shadow-sm">Month</button>
                    <button class="px-2 py-0.5 text-xs rounded-md hover:bg-white/50">Week</button>
                    <button class="px-2 py-0.5 text-xs rounded-md hover:bg-white/50">Day</button>
                </div>
            </div> --}}

            <!-- Day headers -->
            <div class="grid grid-cols-7 gap-1 mb-1 sticky top-0 bg-white z-10">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="text-center text-xs font-semibold text-gray-600 py-1 {{ $loop->first ? 'text-red-500' : '' }} {{ $loop->last ? 'text-red-500' : '' }}">
                        {{ substr($day, 0, 3) }}
                    </div>
                @endforeach
            </div>

            <!-- Calendar days grid -->
            <div class="grid grid-cols-7 gap-1">
                @php
                    $firstDay = now()->startOfMonth();
                    $daysInMonth = now()->daysInMonth;
                    $startingDayOfWeek = $firstDay->dayOfWeek;
                    $totalRows = ceil(($startingDayOfWeek + $daysInMonth) / 7);
                @endphp

                <!-- Empty cells for days before month starts -->
                @for($i = 0; $i < $startingDayOfWeek; $i++)
                    <div class="bg-gray-50 rounded border border-gray-100" style="min-height: 70px;"></div>
                @endfor

                <!-- Actual days of the month -->
                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $currentDate = now()->setDay($day)->format('Y-m-d');
                        $attendance = $attendances->firstWhere('date', $currentDate);
                        $isToday = $currentDate === now()->format('Y-m-d');
                        $isWeekend = in_array(now()->setDay($day)->dayOfWeek, [0, 6]);
                    @endphp
                    
                    <div class="border rounded p-1 {{ $isToday ? 'border-indigo-500 bg-indigo-50' : ($isWeekend ? 'border-gray-200 bg-gray-50' : 'border-gray-200') }}" style="min-height: 70px;">
                        <div class="flex flex-col h-full">
                            <div class="flex justify-between items-start">
                                <span class="text-xs font-semibold {{ $isToday ? 'text-indigo-600' : ($isWeekend ? 'text-red-500' : 'text-gray-700') }}">
                                    {{ $day }}
                                </span>
                                @if($attendance)
                                    @php
                                        $statusColors = [
                                            'present' => 'bg-green-100 text-green-800',
                                            'late' => 'bg-yellow-100 text-yellow-800',
                                            'absent' => 'bg-red-100 text-red-800',
                                            'holiday' => 'bg-purple-100 text-purple-800',
                                            'leave' => 'bg-blue-100 text-blue-800'
                                        ];
                                        $colorClass = $statusColors[$attendance->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="text-[10px] px-1 rounded-full {{ $colorClass }}">
                                        {{ substr($attendance->status, 0, 3) }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($attendance && isset($attendance->check_in))
                                <div class="mt-auto text-[9px] text-gray-500">
                                    <div>{{ $attendance->check_in }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endfor

                <!-- Empty cells for days after month ends -->
                @php
                    $remainingCells = ($totalRows * 7) - ($startingDayOfWeek + $daysInMonth);
                @endphp
                @for($i = 0; $i < $remainingCells; $i++)
                    <div class="bg-gray-50 rounded border border-gray-100" style="min-height: 70px;"></div>
                @endfor
            </div>

            <!-- Mini Summary -->
            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">P: {{ $attendances->where('status', 'present')->count() }}</span>
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">L: {{ $attendances->where('status', 'late')->count() }}</span>
                <span class="px-2 py-1 bg-red-100 text-red-700 rounded">A: {{ $attendances->where('status', 'absent')->count() }}</span>
                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">LV: {{ $attendances->where('status', 'leave')->count() }}</span>
                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded">H: {{ $attendances->where('status', 'holiday')->count() }}</span>
                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded">T: {{ $attendances->count() }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-2 bg-gray-50 border-t flex-shrink-0 text-xs text-gray-500 flex justify-between">
            <span>Calendar</span>
            <span>{{ $totalRows }}w • {{ $daysInMonth }}d</span>
        </div>
    </div>
    
</div>
@endsection



