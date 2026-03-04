<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Services\WhatsAppService;

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

        $whatsapp = new WhatsAppService();
        $user = auth()->user();
        $whatsapp->send($user->phone, "Hi {$user->name}, your attendance has been marked for today.");


        return back()->with('success', 'Attendance marked.');
    }
    public function myAttendance(Request $request)
    {
        $userId = $request->user()->id;
        $attendances = Attendance::where('user_id', $userId)->orderByDesc('date')->get();

        return view('user.myAttendance', compact('attendances'));
    }

    public function allAttendance()
    {
        $attendances = Attendance::all();
        return view('user.myAttendance', compact('attendances'));
    }
}
