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

define('GLPI_ROOT', '../../..');

/**
 * Summary of PluginGitlabIntegrationProfiles
 * */

class PluginGitlabIntegrationProfiles extends CommonDBTM {
   static $rightname = 'profiles';
   
   static function canCreate() {
      return self::canUpdate();
   }

   static function title() {
      echo "<table class='tab_glpi'><tbody>";
      echo "<tr>";
      echo "<td width='45px'>";
      echo"<img src='".GLPI_ROOT."/plugins/gitlabintegration/img/just-logo.png' height='35px' alt='Gitlab STW' title='Gitlab STW'>";
      echo "</td>";
      echo "<td>";
      echo "<a class='vsubmit' href='https://gitlab.stwautomacao.com.br' target='_blank'>Gitlab STW</a>";
      echo "</td>";
      echo "</tr>";
      echo "</tbody></table>";
   }

   static function configPage() {
      $numrows = 0;
      Html::printPager($values['start'], $numrows, $_SERVER['PHP_SELF'], '');
   }

   // Should return the localized name of the type
   static function getTypeName($nb = 0) {
      return 'Permitions Gitlab';
   }
}