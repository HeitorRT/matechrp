<?php

namespace App\Http\Requests\Admin\Notification;

use Illuminate\Foundation\Http\FormRequest;

class NotificationUpdateRequest  extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'send_by_email' => 'required|boolean',
            'send_by_whatsapp' => 'required|boolean',
            'send_by_sms' => 'required|boolean',
            'send_by_pusher' => 'required|boolean',
            'content_pusher' => 'nullable|string',
            'content_email' => 'nullable|string',
            'content_sms' => 'nullable|string',
            'content_whatsapp' => 'nullable|string',
            'mandatory' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Preencha o nome'
        ];
    }
}
