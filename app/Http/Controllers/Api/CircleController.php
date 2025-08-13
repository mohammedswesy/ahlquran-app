<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CircleStoreRequest;
use App\Http\Requests\CircleUpdateRequest;
use App\Models\Models\Circle;
use App\Models\Models\Institute;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class CircleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
   public function index(Request $request)
    {
         $this->authorize('viewAny', Circle::class);

        $q = Circle::query()
            ->with(['institute','creator'])
            ->withCount(['students','teachers']); // فعّل لو عندك العلاقات

        if ($request->filled('institute_id')) {
            $q->where('institute_id', $request->integer('institute_id'));
        }
        if ($request->filled('type')) {
            $q->where('type', $request->string('type'));
        }
        if ($request->filled('search')) {
            $s = $request->string('search');
            $q->where('name', 'like', "%{$s}%");
        }

        $q->latest('id');

        return $q->paginate($request->integer('per_page') ?: 15);
    }

    public function store(CircleStoreRequest $request)
    {
        $institute = Institute::findOrFail($request->institute_id);
        // $this->authorize('create', [Circle::class, $institute]);

        $data = $request->validated();
        $data['created_by'] = $request->user()->id ?? null;

        $circle = Circle::create($data);
        return $circle->load(['institute','creator']);
    }

    public function show(Circle $circle)
    {
        // $this->authorize('view', $circle);

        return $circle->load(['institute','creator'])->loadCount(['students','teachers']);
    }

    public function update(CircleUpdateRequest $request, Circle $circle)
    {
        // $this->authorize('update', $circle);

        $circle->update($request->validated());
        return $circle->fresh()->load(['institute','creator'])->loadCount(['students','teachers']);
    }

    public function destroy(Circle $circle)
    {
        // $this->authorize('delete', $circle);

        $circle->delete();
        return response()->noContent();
    }
}
