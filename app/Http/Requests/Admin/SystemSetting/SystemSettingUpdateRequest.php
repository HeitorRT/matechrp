<?php

namespace App\Http\Requests\Admin\SystemSetting;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'script' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }
}
