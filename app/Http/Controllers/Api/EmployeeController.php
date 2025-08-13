<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Models\Employee;
use App\Models\Models\Institute;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
      public function index(Request $request)
    {
        $this->authorize('viewAny', Employee::class);

        $q = Employee::query()->with(['user', 'institute']);

        if ($request->filled('institute_id')) {
            $q->where('institute_id', (int) $request->institute_id);
        }
        if ($request->filled('user_id')) {
            $q->where('user_id', (int) $request->user_id);
        }
        if ($request->filled('nationality')) {
            $q->where('nationality', (string) $request->nationality);
        }
        if ($request->filled('search')) {
            $s = (string) $request->search;
            $q->where(function ($w) use ($s) {
                $w->where('job_title', 'like', "%{$s}%")
                  ->orWhere('address', 'like', "%{$s}%")
                  ->orWhere('qualifications', 'like', "%{$s}%");
            });
        }

        return $q->latest('id')->paginate($request->integer('per_page') ?: 15);
    }

    public function store(EmployeeStoreRequest $request)
    {
        // السماح بإنشاء موظف داخل معهد معيّن
        $institute = Institute::findOrFail($request->institute_id);
        $this->authorize('create', [Employee::class, $institute]);

        $employee = Employee::create($request->validated());
        return $employee->load(['user', 'institute']);
    }

    public function show(Employee $employee)
    {
        $this->authorize('view', $employee);

        return $employee->load(['user', 'institute']);
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee->update($request->validated());
        return $employee->fresh()->load(['user', 'institute']);
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $employee->delete();
        return response()->noContent();
    }
}
