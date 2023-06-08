<?php

namespace App\Http\Requests\Admin\Notification;

use Illuminate\Foundation\Http\FormRequest;

class NotificationIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Add prefix 'filters' before field rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'filters.name' => 'nullable|string',
        ];
    }

    /**
     * Add prefix 'filters' before field messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}
