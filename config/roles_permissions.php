<?php
return [
    'roles' => ['admin','manager','user','guest'],
    'permissions' => ['reports.index','reports.show','reports.edit','reports.delete'],
    'install' => [
        'admin' => ['reports.index','reports.show','reports.edit','reports.delete'],
    ],
];
