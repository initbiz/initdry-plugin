<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Console;

use Db;
use Schema;
use Illuminate\Console\Command;
use System\Classes\PluginManager;

/**
 * Removes RainLab.Notify rules whose rule, action or condition classes no longer exist.
 * Uses Db instead of the models because they instantiate the missing classes when fetched.
 */
class CleanNotificationRules extends Command
{
    protected $name = 'initdry:cleannotificationrules';

    protected $description = 'Remove RainLab.Notify rules referencing classes that no longer exist';

    public function handle()
    {
        if (
            !PluginManager::instance()->hasPlugin('RainLab.Notify') ||
            !Schema::hasTable('rainlab_notify_notification_rules')
        ) {
            $this->info('RainLab.Notify is not installed, nothing to clean');
            return;
        }

        foreach (Db::table('rainlab_notify_notification_rules')->get() as $rule) {
            $actions = Db::table('rainlab_notify_rule_actions')->where('rule_host_id', $rule->id)->get();

            $conditions = collect();
            $level = Db::table('rainlab_notify_rule_conditions')->where('rule_host_id', $rule->id)->get();
            while ($level->isNotEmpty()) {
                $conditions = $conditions->merge($level);
                $level = Db::table('rainlab_notify_rule_conditions')
                    ->whereIn('rule_parent_id', $level->pluck('id'))
                    ->get();
            }

            $classNames = collect([$rule->class_name])
                ->merge($actions->pluck('class_name'))
                ->merge($conditions->pluck('class_name'))
                ->filter();

            $missingClasses = [];
            foreach ($classNames as $className) {
                if (!class_exists($className)) {
                    $missingClasses[] = $className;
                }
            }

            if (empty($missingClasses)) {
                continue;
            }

            Db::transaction(function () use ($rule, $actions, $conditions) {
                Db::table('rainlab_notify_rule_actions')->whereIn('id', $actions->pluck('id'))->delete();
                Db::table('rainlab_notify_rule_conditions')->whereIn('id', $conditions->pluck('id'))->delete();
                Db::table('rainlab_notify_notification_rules')->where('id', $rule->id)->delete();
            });
        }
    }
}
