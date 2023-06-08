<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Acess\Authorize;
use App\Helpers\Http\DataQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Indication\IndicationIndexRequest;
use App\Http\Requests\Admin\Indication\IndicationStoreRequest;
use App\Http\Requests\Admin\Indication\IndicationUpdateRequest;
use App\Http\Resources\Admin\IndicationResource;
use App\Models\Indication;
use App\Services\Admin\IndicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class IndicationController extends Controller
{
    /**
     * @var IndicationService
     */
    protected IndicationService $indicationService;

    /**
     * @param IndicationService $indicationService
     */
    public function __construct(IndicationService $indicationService)
    {
        $this->indicationService = $indicationService;
    }

    /**
     * @param IndicationIndexRequest $request
     * @return Response
     */
    public function index(IndicationIndexRequest $request): Response
    {
        Authorize::abortIfNot('indication_index');

        $dataQuery = new DataQuery($request);

        $indications = $this->indicationService->index(
            $dataQuery->filters(),
            $dataQuery->rowsPerPage(),
            $dataQuery->orderBy('name'),
            $dataQuery->sort()
        );

        return inertia('Admin/Indication/Index', [
            'indications' => IndicationResource::collection($indications),
            'query' => $dataQuery->query(),

            'canIndicationStore' => Authorize::any('indication_store'),
            'canIndicationEdit' => Authorize::any('indication_update'),
            'canIndicationDestroy' => Authorize::any('indication_destroy'),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        Authorize::abortIfNot('indication_store');

        return inertia('Admin/Indication/Create');
    }

    /**
     * @param IndicationStoreRequest $indicationStoreRequest
     * @return RedirectResponse
     */
    public function store(IndicationStoreRequest $indicationStoreRequest): RedirectResponse
    {
        Authorize::abortIfNot('indication_store');

        $indication = $this->indicationService->store($indicationStoreRequest->validated());

        return redirect()->route('admin.indication.edit', $indication);
    }

    /**
     * @param Indication $indication
     * @return Response
     */
    public function edit(Indication $indication): Response
    {
        Authorize::abortIfNot('indication_update');

        return inertia('Admin/Indication/Edit', [
            'indication' => new IndicationResource($indication),
            'canIndicationDestroy' => Authorize::any('indication_destroy'),
        ]);
    }

    /**
     * @param Indication $indication
     * @return Response
     */
    public function show(Indication $indication): Response
    {
        return inertia('Admin/Indication/Show', [
            'indication' => new IndicationResource($indication)
        ]);
    }

    /**
     * @param IndicationUpdateRequest $indicationUpdateRequest
     * @param Indication $indication
     * @return RedirectResponse
     */
    public function update(IndicationUpdateRequest $indicationUpdateRequest, Indication $indication): RedirectResponse
    {
        Authorize::abortIfNot('indication_update');

        $indication = $this->indicationService->update($indication, $indicationUpdateRequest->validated());

        return redirect()->route('admin.indication.index');
    }

    /**
     * @param Indication $indication
     * @return RedirectResponse
     */
    public function destroy(Indication $indication): RedirectResponse
    {
        Authorize::abortIfNot('indication_destroy');

        $this->indicationService->delete($indication);

        return redirect()->route('admin.indication.index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyMultiples(Request $request): RedirectResponse
    {
        Authorize::abortIfNot('indication_destroy');

        $request->validate(['ids' => 'required|array|in:' . Indication::get()->pluck('id')->join(',')]);

        $this->indicationService->deleteMultiple($request->get('ids', []));

        return redirect()->route('admin.indication.index');
    }
}
