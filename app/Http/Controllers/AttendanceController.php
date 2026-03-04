<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
    $user = $request->user(); 
    $todayAttendance = \App\Models\Attendance::where('user_id', $user->id)
                        ->where('date', now()->toDateString())
                        ->first();
     $attendances = Attendance::where('user_id', $user->id)
                        ->orderByDesc('date')
                        ->get();

    return view('user.dashboard', compact('todayAttendance', 'attendances'));
    }
    public function mark(Request $request)
    {
        $user = $request->user();
        $date = now()->toDateString();

        $exists = Attendance::where('user_id', $user->id)->where('date', $date)->exists();
        if ($exists) {
            return back()->with('error', 'You have already marked attendance for today.');
        }

        $att = Attendance::create([
            'user_id' => $user->id,
            'date' => $date,
            'status' => 'present',
        ]);

        // placeholder WhatsApp notification
        // app()->make('App\Services\NotificationService')->sendWhatsApp($user, "Attendance marked for $date");

        return back()->with('success', 'Attendance marked.');
    }
    public function myAttendance(Request $request)
    {
        $userId = $request->user()->id;
        $attendances = Attendance::where('user_id', $userId)
                        ->orderByDesc('date')
                        ->get();

        return view('user.myAttendance', compact('attendances'));
    }

    public function allAttendance()
    {
        $attendances = Attendance::all();
        return view('user.myAttendance', compact('attendances'));
    }
}
