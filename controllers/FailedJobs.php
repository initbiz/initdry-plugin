<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Controllers;

use Artisan;
use Redirect;
use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * Failed Jobs Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class FailedJobs extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array required permissions
     */
    public $requiredPermissions = ['initbiz.initdry.access_failed_jobs'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Initbiz.InitDry', 'failed_jobs');
    }

    public function onRetryAllFailedJobs(): Response
    {
        Artisan::call('queue:retry', ['id' => 'all']);

        return Redirect::refresh();
    }

    public function onRetrySelectedFailedJobs(?array $data = []): Response
    {
        if (empty($data)) {
            $data = post();
        }

        $jobsIds = $data['checked'];

        Artisan::call('queue:retry', ['id' => $jobsIds]);

        return Redirect::refresh();
    }
}
