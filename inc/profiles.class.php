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

define('PLUGIN_ROOT', '../../..');

/**
 * Summary of PluginGitlabIntegrationProfiles
 * */

class PluginGitlabIntegrationProfiles extends CommonDBTM {
   static $rightname = 'profiles';
   
   /**
    * Display contents the create of profiles permitions.
    *
    * @param void
    *
    * @return boolean with the permition of update
    */
   static function canCreate() {
      return self::canUpdate();
   }

   /**
    * Display contents the title of profiles permitions.
    *
    * @param void
    *
    * @return void
    */
   static function title() {
      echo "<table class='tab_glpi'><tbody>";
      echo "<tr>";
      echo "<td width='45px'>";
      echo"<img src='".PLUGIN_ROOT."/plugins/gitlabintegration/img/just-logo.png' height='35px' alt='Gitlab STW' title='Gitlab STW'>";
      echo "</td>";
      echo "<td>";
      echo "<a class='vsubmit' href='https://gitlab.stwautomacao.com.br' target='_blank'>Gitlab STW</a>";
      echo "</td>";
      echo "</tr>";
      echo "</tbody></table>";
   }

   /**
    * Display contents the summary of profiles permitions.
    *
    * @param void
    *
    * @return void
    */
   static function configPage() {
      $numrows = 0;
      Html::printPager(0, $numrows, $_SERVER['PHP_SELF'], '');
   }

   /**
    * Display contents the title name of profiles permitions.
    *
    * @param int $nb
    *
    * @return string of the localized name of the type
    */
   static function getTypeName($nb = 0) {
      return 'Permitions Gitlab';
   }

   /**
    * Display contents the search URL of profiles permitions.
    *
    * @param boolean $full
    *
    * @return string contents the search URL
    */
   static function getSearchURL($full = true) {
      global $CFG_GLPI;
      $front_fields = "/plugins/gitlabintegration/front";
      $itemtype = get_called_class();
      $link = "$front_fields/profiles.php?itemtype=$itemtype";
      return $link;
   }

   /**
    * Display contents the form URL of profiles permitions.
    *
    * @param boolean $full
    *
    * @return string contents the form URL
    */
   static function getFormURL($full = true) {
      global $CFG_GLPI;
      $front_fields = "/plugins/gitlabintegration/front";
      $itemtype = get_called_class();
      $link = "$front_fields/profiles.form.php?itemtype=$itemtype";
      return $link;
   }
   
   /**
    * Display contents the principal form of profiles permitions.
    *
    * @param void
    *
    * @return void
    */
   static function massiveActions() {
      self::headMassiveActions(true);

      self::tableMassiveActions();

      self::headMassiveActions(false);
   }

   /**
    * Display contents the principal head of profiles permitions.
    *
    * @param void
    *
    * @return void
    */
   private static function headMassiveActions($top = true) {
      echo '<form name = "massformUser" method="post" action="/front/massiveaction.php">';
      echo '<table class="tab_glpi" width="95%">';
      echo '<tbody>';
      echo '<tr>';
      echo '<td width="30px">';
      if ($top) {
         echo '<img src="/pics/arrow-left-top.png" alt="">';
      } else {
         echo '<img src="/pics/arrow-left.png" alt="">';
      }
      echo '</td>';
      echo '<td width="100%" class="left">';
      echo '<a class="primary-button" onclick="" href="" title="Actions">'. __('Actions') . '</a>';
      echo '</td>';
      echo '</tr>';
      echo '</tbody>';
      echo '</table>';
      echo '</form>';
   }

   /**
    * Display contents the principal table of profiles permitions.
    *
    * @param void
    *
    * @return void
    */
   private static function tableMassiveActions() {
      echo '<div class="center">';
      echo '<table border="0" class="tab_cadrehov">';
      self::titleTable();
      self::bodyTable();
      self::titleTable();
      echo '</table>';
      echo '</div>';
   }

   /**
    * Display contents the title of principal Table of profiles permitions.
    *
    * @param void
    *
    * @return void
    */
   private static function titleTable() {
      echo '<thread>';
      echo '<tr class="tab_bg_2">';
      echo '<th class="left">';
      Html::showCheckbox(['name' => 'checkAll', 'checked' => false]);
      echo '</th>';
      echo '<th class="left" style="width:30%">';
      echo '<a href="#">Profile</a>';
      echo '</th>';
      echo '<th class="left" style="width:20%">';
      echo '<a href="#">Created By</a>';
      echo '</th>';
      echo '<th>';
      echo '<a href="#">Created At</a>';
      echo '</th>';
      echo '<th>';
      echo '<a href="#">Last Update</a>';
      echo '</th>';
      echo '<th style="width:100px">';
      echo '<a href="#">ID</a>';
      echo '</th>';
      echo '</tr>';
      echo '</thread>';
   }

   /**
    * Display contents the body of the principal table of profiles permitions.
    *
    * @param void
    *
    * @return void
    */
   private static function bodyTable() {
      $result = self::getProfilesUsers();

      echo '<tbody>';
      foreach($result as $row) {
         $profile = $row['profile'];
         $user    = $row['firstname_user'] . ' ' . $row['realname_user'];
         $created = $row['created_at'];
         $updated = $row['updated_at'];
         $id      = $row['id'];
      
         echo '<tr class="tab_bg_2">';
         echo '<td width="10" valign="top">';
         Html::showCheckbox(['name' => 'checkAll', 'checked' => false]);
         echo '</td>';
         echo '<td valign="top">';
         echo $profile;
         echo '</td>';
         echo '<td valign="top">';
         echo $user;
         echo '</td>';
         echo '<td valign="top">';
         echo $created;
         echo '</td>';
         echo '<td valign="top">';
         echo $updated;
         echo '</td>';
         echo '<td valign="top">';
         echo $id;
         echo '</td>';
         echo '</tr>';
      
      }
      echo '</tbody>';
   }

   /**
    * Display contents the profiles of profiles permitions.
    *
    * @param void
    *
    * @return array contents the columns of table glpi_plugin_gitlab_profiles_users
    */
   private static function getProfilesUsers() {
      global $DB;
      $result = $DB->request('SELECT `p`.`name` AS `profile`, `u`.`firstname` AS `firstname_user`, 
                                     `u`.`realname` AS `realname_user`, `pu`.`created_at`, `pu`.`updated_at`, `pu`.`id` 
                              FROM `glpi_plugin_gitlab_profiles_users` AS `pu`
                                    LEFT JOIN `glpi_profiles` AS `p` ON (`p`.`id` = `pu`.`profile_id`)
                                    LEFT JOIN `glpi_users` AS `u` ON (`u`.`id` = `pu`.`user_id`)');
      return $result;
   }
}