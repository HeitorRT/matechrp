<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SystemSettingDTO;
use App\Helpers\Acess\Authorize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SystemSetting\SystemSettingUpdateRequest;
use App\Services\Admin\SystemSettingService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class SystemSettingController extends Controller
{
    /**
     * @var SystemSettingService
     */
    protected SystemSettingService $systemSettingService;

    /**
     * @param SystemSettingService $systemSettingService
     */
    public function __construct(SystemSettingService $systemSettingService)
    {
        $this->systemSettingService = $systemSettingService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        Authorize::abortIfNot('system_setting_index');

        $systemSetting = new SystemSettingDTO;

        return inertia('Admin/SystemSetting/Index', [
            'systemSetting' => $systemSetting,
            'canSystemSettingEdit' => Authorize::any('system_setting_update'),
        ]);
    }

    /**
     * @param SystemSettingUpdateRequest $systemSettingUpdateRequest
     * @return RedirectResponse
     */
    public function update(SystemSettingUpdateRequest $systemSettingUpdateRequest): RedirectResponse
    {
        Authorize::abortIfNot('system_setting_update');

        $this->systemSettingService->updateOrCreateKeys($systemSettingUpdateRequest->validated());

        return redirect()->route('admin.system-setting.index');
    }
}
