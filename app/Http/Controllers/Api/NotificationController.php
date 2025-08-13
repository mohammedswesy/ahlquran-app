<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Models\Notification;
class NotificationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
       $this->authorize('viewAny', Notification::class);

        $q = Notification::query()->with(['creator','recipient']);

        if ($request->filled('recipient_id')) {
            $q->where('recipient_id', (int) $request->recipient_id);
        }
        if ($request->filled('created_by')) {
            $q->where('created_by', (int) $request->created_by);
        }
        if ($request->boolean('unread')) {
            $q->whereNull('read_at');
        }

        return $q->latest('id')->paginate($request->integer('per_page') ?: 15);
    }

    public function store(Request $request)
    {
         $this->authorize('create', Notification::class);

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'recipient_id' => 'required|exists:users,id',
        ]);
        $data['created_by'] = $request->user()->id ?? null;

        $notification = Notification::create($data);
        return $notification->load(['creator','recipient']);
    }

    public function show(Notification $notification)
    {
        $this->authorize('view', $notification);
        return $notification->load(['creator','recipient']);
    }

    public function update(Request $request, Notification $notification)
    {
        // $this->authorize('update', $notification);

        $data = $request->validate([
            'title'        => 'sometimes|string|max:255',
            'body'         => 'sometimes|string',
            'recipient_id' => 'sometimes|exists:users,id',
            'read'         => 'sometimes|boolean', // لو بدك تعلمها كمقروءة
        ]);

        if (array_key_exists('read', $data)) {
            $notification->read_at = $data['read'] ? now() : null;
            unset($data['read']);
        }

        $notification->update($data);
        return $notification->fresh()->load(['creator','recipient']);
    }

    public function destroy(Notification $notification)
    {
         $this->authorize('delete', $notification);

        $notification->delete();
        return response()->noContent();
    }

    // اختيارية: فعل مخصص لوسم الإشعار كمقروء
    public function markAsRead(Notification $notification)
    {
         $this->authorize('update', $notification);

        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }
        return response()->json(['status' => 'ok']);
    }
}
