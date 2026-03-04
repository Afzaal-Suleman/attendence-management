@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">My Leaves</h1>

    <a href="{{ route('user.leaves.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Request New Leave
    </a>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 mt-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full mt-4 border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Start Date</th>
                <th class="px-4 py-2 border">End Date</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Reason</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $leave)
                <tr class="text-center border-t">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $leave->start_date }}</td>
                    <td class="px-4 py-2 border">{{ $leave->end_date }}</td>
                    <td class="px-4 py-2 border">
                        @if($leave->status == 'pending')
                            <span class="text-yellow-600 font-semibold">{{ ucfirst($leave->status) }}</span>
                        @elseif($leave->status == 'approved')
                            <span class="text-green-600 font-semibold">{{ ucfirst($leave->status) }}</span>
                        @else
                            <span class="text-red-600 font-semibold">{{ ucfirst($leave->status) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">{{ $leave->reason ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        {{-- <a href="{{ route('user.leaves.edit', $leave->id) }}" class="text-blue-600 hover:underline">Edit</a> --}}
                        
                        <form action="{{ route('user.leaves.destroy', $leave->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline ml-2">
                                Delete 
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No leaves found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection