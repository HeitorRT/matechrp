<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderPaymentMethodEnum;
use App\Enums\OrderStatusEnum;
use App\Helpers\Acess\Authorize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\OrderStoreRequest;
use App\Http\Requests\Admin\Order\OrderUpdateRequest;
use App\Http\Resources\Admin\Order\OrderResource;
use App\Models\Campaign;
use App\Models\Installment;
use App\Models\Order;
use App\Services\Admin\InstallmentService;
use App\Services\Admin\OrderService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use function Symfony\Component\Routing\Loader\Configurator\collection;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected OrderService $orderService;
    /**
     * @var InstallmentService
     */
    private $installmentService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService, InstallmentService $installmentService)
    {
        $this->orderService = $orderService;
        $this->installmentService = $installmentService;
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        Authorize::abortIfNot('order_update');

        return inertia('Admin/Order/Create', [
            'paymentMethods' => OrderPaymentMethodEnum::toArray(),
            'statuses' => OrderStatusEnum::toArray(),
            'campaigns' => Campaign::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * @param OrderStoreRequest $orderStoreRequest
     * @return RedirectResponse
     */
    public function store(OrderStoreRequest $orderStoreRequest): RedirectResponse
    {
        Authorize::abortIfNot('order_store');

        $order = $this->orderService->store($orderStoreRequest->validated());

        return redirect()->route('admin.order.edit', $order);
    }

    /**
     * @param Order $order
     * @return Response
     */
    public function edit(Order $order): Response
    {
        Authorize::abortIfNot('order_update');

//        dd(Installment::selectRaw('*, year(expiration_at) as year')->where('order_id', $order->id)->orderBy('expiration_at','asc')->get());

        return inertia('Admin/Order/Edit', [
            'order' => new OrderResource($order),
            'paymentMethods' => OrderPaymentMethodEnum::toArray(),
            'statuses' => OrderStatusEnum::toArray(),
            'campaigns' => Campaign::select('id', 'name')->orderBy('name')->get(),
            'installmentYears' => Installment::selectRaw('distinct year(expiration_at) as year')->get(),
            'installments' => $this->installmentService->getInstallmentsByYear($order->id),
        ]);
    }

     /**
     * @param Order $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        return inertia('Admin/Order/Show', [
            'order' => new OrderResource($order),
            'paymentMethods' => OrderPaymentMethodEnum::toArray(),
            'statuses' => OrderStatusEnum::toArray(),
            'campaigns' => Campaign::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * @param OrderUpdateRequest $orderUpdateRequest
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(OrderUpdateRequest $orderUpdateRequest, Order $order): RedirectResponse
    {
        Authorize::abortIfNot('order_update');

        $order = $this->orderService->update($order, $orderUpdateRequest->validated());

        return redirect()->route('admin.order.edit', $order);
    }


     /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function cancel(Order $order): RedirectResponse
    {
        Authorize::abortIfNot('order_cancel');

        $this->orderService->cancel($order);

        return redirect()->back();
    }
}
