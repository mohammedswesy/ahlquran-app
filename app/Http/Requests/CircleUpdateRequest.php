<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CircleUpdateRequest extends FormRequest
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
        return [
            //
             'name'         => 'sometimes|string|max:255',
            'institute_id' => 'sometimes|exists:institutes,id',
            'type'         => ['sometimes', 'string', Rule::in(['hifz','tajweed','arabic'])],
            'start_time'   => 'nullable|date_format:H:i',
            'end_time'     => 'nullable|date_format:H:i|after:start_time',
        ];
    }
      public function messages(): array
    {
        return [
            'name.string'          => 'اسم الحلقة يجب أن يكون نصًا.',
            'institute_id.exists'  => 'المعهد غير موجود.',
            'type.in'              => 'نوع الحلقة غير صالح.',
            'start_time.date_format'=> 'صيغة وقت البداية يجب أن تكون HH:MM.',
            'end_time.date_format'  => 'صيغة وقت النهاية يجب أن تكون HH:MM.',
            'end_time.after'        => 'وقت النهاية يجب أن يكون بعد وقت البداية.',
        ];
    }
}
