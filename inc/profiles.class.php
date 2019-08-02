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
 * Summary of PluginGitlabIntegrationProfiles
 * */
class PluginGitlabIntegrationProfiles extends CommonDBTM {
    
    static $rightname = 'config';
    
    /**
    * Display contents the permition create of profiles permitions.
    *
    * @param void
    *
    * @return boolean with the permition
    */
    static function canCreate() {
        return self::canUpdate();
    }
  
    /**
    * Display contents the link of profiles permitions
    *
    * @param void
    *
    * @return void
    */
    static function titleList() {
        echo "<div class='center'><a class='vsubmit' href='regenerate_files.php'><i class='pointer fa fa-refresh'></i>&nbsp;".
              __("Permitions Gitlab", "gitlabintegration")."</a></div>";
    }

    /**
    * Display contents the menu name of profiles permitions
    *
    * @param void
    *
    * @return string with the menu name
    */
    static function getTypeName($nb = 0) {
        return __("Permitions Gitlab", "gitlabintegration");
    }
}