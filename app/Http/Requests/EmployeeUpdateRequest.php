<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('employee')?->id ?? null;
        return [
            //
            'user_id'        => 'sometimes|exists:users,id|unique:employees,user_id,' . $id,
            'institute_id'   => 'sometimes|exists:institutes,id',
            'job_title'      => 'nullable|string|max:150',
            'cv_file'        => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:50',
            'qualifications' => 'nullable|string|max:500',
            'birth_date'     => 'nullable|date',
            'nationality'    => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:255',
            'id_document'    => 'nullable|string|max:255',
        ];
    }
public function messages(): array
    {
        return [
            'user_id.exists'       => 'المستخدم غير موجود.',
            'user_id.unique'       => 'هذا المستخدم مسجّل بالفعل كموظف.',
            'institute_id.exists'  => 'المعهد غير موجود.',
            'birth_date.date'      => 'صيغة تاريخ الميلاد غير صحيحة.',
        ];
    }
   
}
