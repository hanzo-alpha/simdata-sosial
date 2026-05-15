<?php

declare(strict_types=1);

namespace App\Traits;

use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Filament\Facades\Filament;

trait HasWidgetShield
{
    protected static ?string $widgetPermissionKey = null;

    public static function canView(): bool
    {
        $permission = static::getWidgetPermission();
        $user = Filament::auth()?->user();

        return $permission && $user ? $user->can($permission) : parent::canView();
    }

    protected static function getWidgetPermission(): ?string
    {
        if (null === static::$widgetPermissionKey) {
            $widget = FilamentShield::getWidgets()[static::class] ?? null;
            static::$widgetPermissionKey = $widget ? array_key_first($widget['permissions']) : null;
        }

        return static::$widgetPermissionKey;
    }
}
