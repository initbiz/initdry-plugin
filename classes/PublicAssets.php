<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Classes;

use Auth;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use RainLab\User\Models\User;

/**
 * Class with commonly used functions that do not belong to any other helpers
 */
class Helpers
{
    /**
     * Get currently logged in user and timestamp 'last seen'
     *
     * @return User|null
     */
    public static function getUser(): ?User
    {
        // RainLab.User ^3.0
        if (class_exists(\RainLab\User\Classes\TwoFactorManager::class)) {
            if (!$user = Auth::user()) {
                return null;
            }
        } else {
            if (!$user = Auth::getUser()) {
                return null;
            }
        }

        if ($user instanceof User) {
            $user->touchLastSeen();
        }

        return $user;
    }

    /**
     * Helper to be used in models to list all cms pages in dropdown
     * @return array pages base file names
     */
    public static function getFileListToDropdown(): array
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * Get url of page using page code
     * @param  string $pageCode page code
     * @param  Theme $theme     theme object
     * @return string           url
     */
    public static function getPageUrl(string $pageCode, Theme $theme = null): string
    {
        if (!$theme) {
            $theme = Theme::getActiveTheme();
        }

        $page = Page::loadCached($theme, $pageCode);
        if (!$page) {
            return '';
        }

        $url = Page::url($page->getBaseFileName());

        return $url;
    }
}
