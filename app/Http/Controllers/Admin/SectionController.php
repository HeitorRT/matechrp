<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Acess\Authorize;
use App\Helpers\Http\DataQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Section\SectionIndexRequest;
use App\Models\Section;
use App\Http\Requests\Admin\Section\SectionStoreRequest;
use App\Http\Requests\Admin\Section\SectionUpdateRequest;
use App\Http\Resources\Admin\SectionResource;
use App\Services\Admin\SectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;


class SectionController extends Controller
{
    /**
     * @var SectionService
     */
    protected SectionService $sectionService;

    /**
     * @param SectionService $sectionService
     */
    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    /**
     * @param SectionIndexRequest $request
     * @return Response
     */
    public function index(SectionIndexRequest $request): Response
    {
        Authorize::abortIfNot('section_index');

        $dataQuery = new DataQuery($request);

        $sections = $this->sectionService->index(
            $dataQuery->filters(),
            $dataQuery->rowsPerPage(),
            $dataQuery->orderBy('sort_number'),
            $dataQuery->sort()
        );

        return inertia('Admin/Section/Index', [
            'sections' => SectionResource::collection($sections),
            'query' => $dataQuery->query(),

            'canSectionStore' => Authorize::any('section_store'),
            'canSectionEdit' => Authorize::any('section_update'),
            'canSectionDestroy' => Authorize::any('section_destroy'),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        Authorize::abortIfNot('section_store');

        return inertia('Admin/Section/Create');
    }

    /**
     * @param SectionStoreRequest $sectionStoreRequest
     * @return RedirectResponse
     */
    public function store(SectionStoreRequest $sectionStoreRequest): RedirectResponse
    {
        Authorize::abortIfNot('section_store');

        $section = $this->sectionService->store($sectionStoreRequest->validated());

        return redirect()->route('admin.section.edit', $section);
    }

    /**
     * @param Section $section
     * @return Response
     */
    public function edit(Section $section): Response
    {
        Authorize::abortIfNot('section_update');

        return inertia('Admin/Section/Edit', [
            'section' => new SectionResource($section),
            'canSectionDestroy' => Authorize::any('section_destroy'),
        ]);
    }

     /**
     * @param Section $section
     * @return Response
     */
    public function show(Section $section): Response
    {
        return inertia('Admin/Section/Show', [
            'section' => new SectionResource($section)
        ]);
    }

    /**
     * @param SectionUpdateRequest $sectionUpdateRequest
     * @param Section $section
     * @return RedirectResponse
     */
    public function update(SectionUpdateRequest $sectionUpdateRequest, Section $section): RedirectResponse
    {
        Authorize::abortIfNot('section_update');

        $section = $this->sectionService->update($section, $sectionUpdateRequest->validated());

        return redirect()->route('admin.section.index');
    }

    /**
     * @param Section $section
     * @return RedirectResponse
     */
    public function destroy(Section $section): RedirectResponse
    {
        Authorize::abortIfNot('section_destroy');

        $this->sectionService->delete($section);

        return redirect()->route('admin.section.index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyMultiples(Request $request): RedirectResponse
    {
        Authorize::abortIfNot('section_destroy');

        $request->validate(['ids' => 'required|array|in:' . Section::canDelete()->get()->pluck('id')->join(',')]);

        $this->sectionService->deleteMultiple($request->get('ids', []));

        return redirect()->route('admin.section.index');
    }

     /**
     * @return Response
     */
    public function sortIndex(): Response
    {
        $sections = Section::orderBy('sort_number')->get();

        return inertia('Admin/Section/SortIndex', [
            'sections' => SectionResource::collection($sections),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:sections,id',
        ]);

        $this->sectionService->reorder($request->get('sections', []));

        return redirect()->route('admin.section.index');
    }
}
