<?php

namespace App\Services\Admin;

use App\Models\Installment;

class InstallmentService
{

    /**
     * @param int $order_id
     * @return array
     */
    public function getInstallmentsByYear(int $order_id): array
    {
        $installments = Installment::selectRaw('*, year(expiration_at) as year')
                            ->where('order_id', $order_id)
                            ->orderBy('expiration_at','asc')
                            ->get();

        return $installments->groupBy('year')->toArray();

    }
}
