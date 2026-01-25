<?php

declare(strict_types=1);

return [
    'plugin' => [
        'name' => 'InitDry',
        'description' => 'Paczka InIT.biz z przydatnymi klasami i helperami',
    ],

    'confirm' => [
        'delete_confirm' => 'Czy jesteś pewny, że chcesz usunąć zaznaczone elementy?'
    ],

    'repeater_prompt' => [
        'add_new_item' => 'Dodaj nowy element',
    ],

    'permissions' => [
        'settings_tab' => 'inIT DRY',
        'access_manage_public_assets' => 'Zarządzaj publicznymi zasobami',
    ],

    'public_asset_setting' => [
        'settings_label' => 'Publiczne zasoby',
        'settings_description' => 'Ustaw zasoby dostępne publicznie',
        'icon_label' => 'Ikona',
        'icon_comment' => 'Domyślnie użyjemy ikony October CMS',
        'logo_label' => 'Logo',
        'logo_comment' => 'Domyślnie użyjemy loga October CMS',
    ],

    'jobs' => [
        'queue_category' => 'Kolejka bazodanowa',
        'label' => 'Kolejka zadań',
        'description' => 'Przeglądaj zadania w kolejce',
        'record_name' => 'Zadania w kolejce',
        'manage_title' => 'Zadania w kolejce',
    ],

    'job' => [
        'id' => 'ID',
        'queue' => 'Kolejka',
        'payload' => 'Payload',
        'attempts' => 'Liczba prób',
        'reserved_at' => 'Data rezerwacji',
        'available_at' => 'Data dostępności',
        'created_at' => 'Data utworzenia',
    ],

    'failed_jobs' => [
        'label' => 'Nieudane zadania',
        'description' => 'Przeglądaj nieudane zadania z kolejki',
        'record_name' => 'Nieudane zadania',
        'manage_title' => 'Nieudane zadania',
        'retry_all' => 'Ponów wszystkie',
        'retry_selected' => 'Ponów zaznaczone',
    ],

    'failed_job' => [
        'id' => 'ID',
        'queue' => 'Kolejka',
        'payload' => 'Payload',
        'connection' => 'Połączenie',
        'failed_at' => 'Data niepomyślnego wykonania',
        'exception' => 'Wyjątek',
    ],
];
