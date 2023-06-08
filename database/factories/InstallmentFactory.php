<?php

namespace Database\Factories;

use App\Enums\InstallmentPaymentMethodEnum;
use App\Enums\InstallmentStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstallmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = fake()->randomElement(InstallmentStatusEnum::toValues());

        $expirationAt = fake()->dateTimeBetween('-12 months', '-10 months');

        $payDayAt = null;

        if ($status === InstallmentStatusEnum::pago()->value) {
            $payDayAt = $expirationAt;

        }

        return [
            'status' => $status,
            'payment_value' => fake()->numberBetween(100, 10000),
            'payment_method' => fake()->randomElement(InstallmentPaymentMethodEnum::toValues()),
            'expiration_at' => $expirationAt,
            'expiration_original_at' => $expirationAt,
            'payday_at' => $payDayAt,
        ];
    }
}
