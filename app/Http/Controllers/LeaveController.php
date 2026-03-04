<?php
namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    // List all leaves
    public function index()
    {
        $leaves = Leave::with('user')->orderByDesc('created_at')->get();
        return view('user.leaves.index', compact('leaves'));
    }

    // Show form to create leave
    public function create()
    {
        return view('user.leaves.create');
    }

    // Store new leave
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        Leave::create([
            'user_id' => $request->user()->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return redirect()->route('user.leaves.index')->with('success', 'Leave requested successfully!');
    }

    // Show single leave
    public function show(Leave $leave)
    {
        return view('user.leaves.show', compact('leave'));
    }

    // Show edit form
    public function edit(Leave $leave)
    {
        return view('user.leaves.edit', compact('leave'));
    }

    // Update leave
    public function update(Request $request, Leave $leave)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'reason' => 'nullable|string',
        ]);

        $leave->update($request->only('status', 'reason'));

        return redirect()->route('user.leaves.index')->with('success', 'Leave updated successfully!');
    }

    // Delete leave
    public function destroy($id)
    {
    $leave = Leave::find($id);
    
    if (!$leave) {
        return redirect()->route('user.leaves.index')
            ->with('error', 'Leave not found!');
    }
    
    $leave->delete();
    
    return redirect()->route('user.leaves.index')
        ->with('success', 'Leave deleted successfully!');
    }
}