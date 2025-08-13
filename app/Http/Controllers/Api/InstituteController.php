<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Models\Institute;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\InstituteStoreRequest;
use App\Http\Requests\InstituteUpdateRequest;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Institute::class);

        $q = Institute::query()->withCount(['employees','circles']);

        if ($request->filled('country_id')) {
            $q->where('country_id', (int) $request->country_id);
        }
        if ($request->filled('city_id')) {
            $q->where('city_id', (int) $request->city_id);
        }
        if ($request->filled('organization_id')) {
            $q->where('organization_id', (int) $request->organization_id);
        }
        if ($request->filled('status')) {
            $q->where('status', (int) $request->status);
        }
        if ($request->filled('search')) {
            $q->where('name', 'like', '%'.(string)$request->search.'%');
        }

        return $q->latest('id')->paginate($request->integer('per_page') ?: 15);
    }

    public function store(InstituteStoreRequest $request)
    {
        $this->authorize('create', Institute::class);

        $data = $request->validated();
        $data['created_by'] = $request->user()->id ?? null;

        return Institute::create($data);
    }

    public function show(Institute $institute)
    {
        $this->authorize('view', $institute);

        return $institute->load(['admins.user','employees.user','circles']);
    }

    public function update(InstituteUpdateRequest $request, Institute $institute)
    {
        $this->authorize('update', $institute);

        $institute->update($request->validated());
        return $institute->fresh();
    }

    public function destroy(Institute $institute)
    {
        $this->authorize('delete', $institute);

        $institute->delete();
        return response()->noContent();
    }
}
