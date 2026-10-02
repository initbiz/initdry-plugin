<?php

declare(strict_types=1);

return [
    'plugin' => [
        'name' => 'InitDry',
        'description' => 'InIT.biz package with useful classes and helpers',
    ],

    'confirm' => [
        'delete_confirm' => 'Are you sure you want to delete the checked records?',
    ],

    'repeater_prompt' => [
        'add_new_item' => 'Add new item',
    ],

    'permissions' => [
        'settings_tab' => 'inIT DRY',
        'access_manage_public_assets' => 'Manage public assets',
    ],

    'public_asset_setting' => [
        'settings_label' => 'Public assets',
        'settings_description' => 'Set assets available throughout whole app',
        'icon_label' => 'Icon',
        'icon_comment' => 'If not set, we\'ll use October CMS\'s as a default',
        'logo_label' => 'Logo',
        'logo_comment' => 'If not set, we\'ll use October CMS\'s as a default',
    ],

    'jobs' => [
        'queue_category' => 'DB queue',
        'label' => 'Jobs queue',
        'description' => 'Browse jobs queue',
        'record_name' => 'Jobs',
        'manage_title' => 'Queue jobs',
    ],

    'job' => [
        'id' => 'ID',
        'queue' => 'Queue',
        'payload' => 'Payload',
        'attempts' => 'Attempts',
        'reserved_at' => 'Reserved at',
        'available_at' => 'Available at',
        'created_at' => 'Created at',
    ],

    'failed_jobs' => [
        'label' => 'Failed jobs',
        'description' => 'Browse failed jobs',
        'record_name' => 'Failed jobs',
        'manage_title' => 'Failed jobs',
        'retry_all' => 'Retry all',
        'retry_selected' => 'Retry selected',
    ],

    'failed_job' => [
        'id' => 'ID',
        'queue' => 'Queue',
        'payload' => 'Payload',
        'connection' => 'Connection',
        'failed_at' => 'Failed at',
        'exception' => 'Exception',
    ],
];
