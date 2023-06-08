<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Acess\Authorize;
use App\Helpers\Http\DataQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Popup\PopupIndexRequest;
use App\Models\Content;
use App\Models\Popup;
use App\Http\Requests\Admin\Popup\PopupStoreRequest;
use App\Http\Requests\Admin\Popup\PopupUpdateRequest;
use App\Http\Resources\Admin\PopupResource;
use App\Services\Admin\PopupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;


class PopupController extends Controller
{
    /**
     * @var PopupService
     */
    protected PopupService $popupService;

    /**
     * @param PopupService $popupService
     */
    public function __construct(PopupService $popupService)
    {
        $this->popupService = $popupService;
    }

    /**
     * @param PopupIndexRequest $request
     * @return Response
     */
    public function index(PopupIndexRequest $request): Response
    {
        Authorize::abortIfNot('popup_index');

        $dataQuery = new DataQuery($request);

        $popups = $this->popupService->index(
            $dataQuery->filters(),
            $dataQuery->rowsPerPage(),
            $dataQuery->orderBy('end_at'),
            $dataQuery->sort()
        );

        return inertia('Admin/Popup/Index', [
            'popups' => PopupResource::collection($popups),
            'query' => $dataQuery->query(),
            'contents' => Content::select('id', 'name')->orderBy('name')->get(),

            'canPopupStore' => Authorize::any('popup_store'),
            'canPopupEdit' => Authorize::any('popup_update'),
            'canPopupDestroy' => Authorize::any('popup_destroy'),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        Authorize::abortIfNot('popup_store');

        $contents = Content::select('id', 'name')->orderBy('name')->get();

        return inertia('Admin/Popup/Create',  [
            'contents' => $contents,
        ]);

    }

    /**
     * @param PopupStoreRequest $popupStoreRequest
     * @return RedirectResponse
     */
    public function store(PopupStoreRequest $popupStoreRequest): RedirectResponse
    {
        Authorize::abortIfNot('popup_store');

        $popup = $this->popupService->store($popupStoreRequest->validated());

        return redirect()->route('admin.popup.edit', $popup);
    }

    /**
     * @param Popup $popup
     * @return Response
     */
    public function edit(Popup $popup): Response
    {
        Authorize::abortIfNot('popup_update');

        return inertia('Admin/Popup/Edit', [
            'contents' => Content::select('id', 'name')->orderBy('name')->get(),
            'popup' => new PopupResource($popup),
            'canPopupDestroy' => Authorize::any('popup_destroy'),
        ]);
    }

     /**
     * @param Popup $popup
     * @return Response
     */
    public function show(Popup $popup): Response
    {
        return inertia('Admin/Popup/Show', [
            'contents' => Content::select('id', 'name')->orderBy('name')->get(),
            'popup' => new PopupResource($popup),
        ]);
    }

    /**
     * @param PopupUpdateRequest $popupUpdateRequest
     * @param Popup $popup
     * @return RedirectResponse
     */
    public function update(PopupUpdateRequest $popupUpdateRequest, Popup $popup): RedirectResponse
    {
        Authorize::abortIfNot('popup_update');

        $popup = $this->popupService->update($popup, $popupUpdateRequest->validated());

        return redirect()->route('admin.popup.index');
    }

    /**
     * @param Popup $popup
     * @return RedirectResponse
     */
    public function destroy(Popup $popup): RedirectResponse
    {
        Authorize::abortIfNot('popup_destroy');

        $this->popupService->delete($popup);

        return redirect()->route('admin.popup.index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyMultiples(Request $request): RedirectResponse
    {
        Authorize::abortIfNot('popup_destroy');

        $request->validate(['ids' => 'required|array|in:' . Popup::get()->pluck('id')->join(',')]);

        $this->popupService->deleteMultiple($request->get('ids', []));

        return redirect()->route('admin.popup.index');
    }
}
