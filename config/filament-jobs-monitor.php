<?php

return [
    'resources' => [
        'enabled' => true,
        'label' => 'Pekerjaan',
        'plural_label' => 'Pekerjaan',
        'navigation_group' => 'Pengaturan',
        'navigation_icon' => 'heroicon-o-cpu-chip',
        'navigation_sort' => null,
        'navigation_count_badge' => false,
        'resource' => Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource::class,
    ],
    'pruning' => [
        'enabled' => true,
        'retention_days' => 7,
    ],
];
