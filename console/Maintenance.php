<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Console;

use Illuminate\Console\Command;
use Cms\Models\MaintenanceSetting;
use Symfony\Component\Console\Input\InputArgument;

class Maintenance extends Command
{
    protected $name = 'maintenance';
    protected $description = 'Enable or disable the maintenance mode';

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['action', InputArgument::OPTIONAL, 'Either enable, disable or toggle'],
        ];
    }

    public function handle()
    {
        $action = $this->argument('action') ?? 'toggle';

        if ($action === 'enable') {
            $this->enableMaintenance();
        } elseif ($action === 'disable') {
            $this->disableMaintenance();
        } elseif ($action === 'toggle') {
            $this->toggleMaintenance();
        }
    }

    protected function enableMaintenance()
    {
        MaintenanceSetting::set(['is_enabled' => true]);
        $this->info('Maintenance enabled');
    }

    protected function disableMaintenance()
    {
        MaintenanceSetting::set(['is_enabled' => false]);
        $this->info('Maintenance disabled');
    }

    protected function toggleMaintenance()
    {
        $currentState = MaintenanceSetting::get('is_enabled', false);

        if ($currentState) {
            $this->disableMaintenance();
        } else {
            $this->enableMaintenance();
        }
    }
}
