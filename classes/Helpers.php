<?php namespace Initbiz\InitDry\Classes;

use Auth;
use Cms\Classes\Page;
use Cms\Classes\Theme;

class Helpers
{
    public static function getUser()
    {
        if (!$user = Auth::getUser()) {
            return null;
        }

        $user->touchLastSeen();

        return $user;
    }

    public static function getFileListToDropdown()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public static function getPageUrl($pageCode, $theme = null)
    {
        if (!$theme) {
            $theme = Theme::getActiveTheme();
        }

        $page = Page::loadCached($theme, $pageCode);
        if (!$page) {
            return;
        }

        $url = Page::url($page->getBaseFileName());

        return $url;
    }
}
