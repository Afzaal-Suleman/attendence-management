@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Request New Leave</h1>

    <form action="{{ route('user.leaves.store') }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label for="start_date" class="block font-semibold mb-1">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                   class="w-full border px-3 py-2 rounded">
            @error('start_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="end_date" class="block font-semibold mb-1">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                   class="w-full border px-3 py-2 rounded">
            @error('end_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="reason" class="block font-semibold mb-1">Reason (optional)</label>
            <textarea name="reason" id="reason" class="w-full border px-3 py-2 rounded">{{ old('reason') }}</textarea>
            @error('reason')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Submit Request
        </button>
    </form>
</div>
@endsection