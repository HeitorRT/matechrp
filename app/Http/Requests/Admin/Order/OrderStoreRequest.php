<?php

namespace App\Http\Requests\Admin\Order;

use App\Enums\OrderPaymentMethodEnum;
use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class OrderStoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'payment_method' => "required|in:" . implode(',', OrderPaymentMethodEnum::toValues()),
            'payment_value' => 'required',
            'status' => "required|in:" . implode(',', OrderStatusEnum::toValues()),
			'hiring_start_at' => 'required|date_format:d/m/Y',
            'hiring_end_at' => 'required|date_format:d/m/Y',
            'student_id' => 'required|exists:students,id',
            'campaign_id' => ' nullable|exists:campaigns,id',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $dateFormatForExample = now()->format('d/m/Y');

        $paymentMethods = Arr::join(OrderPaymentMethodEnum::toLabels(), ', ', ' ou ');

        return [
            'payment_method.required' => "Insira a forma de pagamento",
            'payment_method.in' => "A forma de pagamento deve ser {$paymentMethods}",
            'payment_value.required' => "Insira o valor de pagamento",
            'status.required' => "Insira o status do pedido",
            'hiring_start_at.required' => "Insira a data de contratação",
            'hiring_start_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
            'hiring_end_at.required' => "Insira a data final de contratação",
            'hiring_end_at.date_format' => "Informe a data e hora corretamente. Exemplo: {$dateFormatForExample}",
            'student_id.required' => "Insira um aluno para o pedido",
        ];
    }
}
