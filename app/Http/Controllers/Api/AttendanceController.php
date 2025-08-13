<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Models\Attendance;

class AttendanceController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
         $this->authorize('viewAny', Attendance::class); //

        $q = Attendance::query()->with(['user','circle']);

        if ($request->filled('user_id')) {
            $q->where('user_id', (int) $request->user_id);
        }
        if ($request->filled('circle_id')) {
            $q->where('circle_id', (int) $request->circle_id);
        }
        if ($request->filled('status')) {
            $q->where('status', (string) $request->status); // e.g. present/absent/late
        }
        if ($request->filled('date_from')) {
            $q->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $q->whereDate('created_at', '<=', $request->date_to);
        }

        return $q->latest('id')->paginate($request->integer('per_page') ?: 15);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Attendance::class);

        $data = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'circle_id'   => 'required|exists:circles,id',
            'status'      => 'required|string|in:present,absent,late',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i|after:start_time',
        ]);

        $attendance = Attendance::create($data);
        return $attendance->load(['user','circle']);
    }

    public function show(Attendance $attendance)
    {
        $this->authorize('view', $attendance);
        return $attendance->load(['user','circle']);
    }

    public function update(Request $request, Attendance $attendance)
    {
         $this->authorize('update', $attendance);

        $data = $request->validate([
            'user_id'     => 'sometimes|exists:users,id',
            'circle_id'   => 'sometimes|exists:circles,id',
            'status'      => 'sometimes|string|in:present,absent,late',
            'start_time'  => 'nullable|date_format:H:i',
            'end_time'    => 'nullable|date_format:H:i|after:start_time',
        ]);

        $attendance->update($data);
        return $attendance->fresh()->load(['user','circle']);
    }

    public function destroy(Attendance $attendance)
    {
        $this->authorize('delete', $attendance);

        $attendance->delete();
        return response()->noContent();
    }
}
