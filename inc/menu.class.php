<?php
/*
 -------------------------------------------------------------------------
GLPI - Gestionnaire Libre de Parc Informatique
Copyright (C) 2003-2019 by the INDEPNET Development Team.

http://indepnet.net/   http://glpi-project.org
-------------------------------------------------------------------------

LICENSE

This file is part of GLPI.

GLPI is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

GLPI is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with GLPI. If not, see <http://www.gnu.org/licenses/>.
--------------------------------------------------------------------------
 */

/**
 * Summary of PluginGitlabIntegrationMenu
 * */

class PluginGitlabIntegrationMenu extends CommonGLPI {
   
    static $rightname = 'entity';

    /**
    * Display contents the menu name of profiles Permission.
    *
    * @param void
    *
    * @return string with the menu name
    */
    static function getMenuName() {
        return __("Permissions Gitlab", "gitlabintegration");
    }

    /**
    * Display contents the menu option of profiles Permissions.
    *
    * @param void
    *
    * @return array with the menu option
    */
    static function getMenuContent() {

        if (!Session::haveRight('entity', READ)) {
            return;
        }

        $front_fields = "/plugins/gitlabintegration/front";
        $menu = [];
        $menu['title'] = self::getMenuName();
        $menu['page']  = "$front_fields/profiles.php";

        $itemtypes = ['PluginGitlabIntegrationProfiles' => 'profiles'];

        foreach ($itemtypes as $itemtype => $option) {
            $menu['options'][$option]['title']           = $itemtype::getTypeName(2);
            $menu['options'][$option]['page']            = $itemtype::getSearchURL(false);
            $menu['options'][$option]['links']['search'] = $itemtype::getSearchURL(false);
            $menu['options'][$option]['links']['add']    = $itemtype::getFormURL(false);
        }
        return $menu;
    }
}