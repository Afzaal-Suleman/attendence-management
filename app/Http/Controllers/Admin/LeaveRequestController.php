<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;

class LeaveRequestController extends Controller
{
    // Show all leave requests
    public function index()
    {
        // Eager load user info
        $leaves = Leave::with('user')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.leaves.index', compact('leaves'));
    }

    // Optional: Approve leave
    public function approve(Leave $leave)
    {
        $leave->status = 'approved';
        $leave->save();

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave approved successfully!');
    }

    // Optional: Reject leave
    public function reject(Leave $leave)
    {
        $leave->status = 'rejected';
        $leave->save();

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave rejected successfully!');
    }
}