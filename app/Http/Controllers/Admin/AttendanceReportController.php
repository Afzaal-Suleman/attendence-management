<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceReportController extends Controller
{
    // Show today's attendance
    public function today()
    {
        $today = Carbon::today()->toDateString();

        // Present users today
         $presentUsers = Attendance::with('user')
        ->where('date', $today)
        ->where('status', 'present')
        ->get();

        // Absent users today
        $absentUsers = User::whereNotIn('id', function($query) use ($today) {
                $query->select('user_id')
                      ->from('attendances')
                      ->where('date', $today);
            })->get();

        return view('admin.attendance.today', compact('presentUsers', 'absentUsers'));
    }
}