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
    * Display contents the create of profiles Permission.
    *
    * @param void
    *
    * @return boolean with the Permission of update
    */
   static function canCreate() {
      return self::canUpdate();
   }

   /**
    * Display contents the title of profiles Permission.
    *
    * @param void
    *
    * @return void
    */
   static function title() {
      echo '<script type="text/javascript" src="../js/buttonsFunctions.js"></script>';
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
    * Display contents the summary of profiles Permission.
    *
    * @param int $start
    *
    * @return void
    */
   static function configPage($start) {
      $numrows = self::getCountProfilesUsers();

      Html::printPager($start, $numrows, $_SERVER['PHP_SELF'], '');
   }

   /**
    * Display contents the title name of profiles Permission.
    *
    * @param int $nb
    *
    * @return string of the localized name of the type
    */
   static function getTypeName($nb = 0) {
      return __('Permissions');
   }

   /**
    * Display contents the search URL of profiles Permission.
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
    * Display contents the form URL of profiles Permission.
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
    * Display contents the form body of profiles Permission.
    *
    * @param void
    *
    * @return void
    */
   public static function showForm() {
      echo '<div class="glpi_tabs new_form_tabs">';
      echo '   <div id="tabspanel" class="center-h">';
      echo '      <div class="center vertical ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-vertical ui-helper-clearfix ui-corner-left">';
      echo '           <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">';
      echo '              <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="ui-tabs-1" aria-labelledby="ui-id-2" aria-selected="true">';
      echo '                 <a title="Block" href="#" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">';
      echo self::getTypeName();
      echo '                 </a>';
      echo '              </li>';
      echo '           </ul>';
      echo '           <div id="ui-tabs-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom table-form" aria-live="polite" aria-labelledby="ui-id-2" role="tabpanel" aria-expanded="true" aria-hidden="false">';
      echo '               <div class="form-custom">';
      echo '                   <div class="top-form">New Profile Permissions Gitlab</div>';
      echo '                   <div class="flex">';
      echo '                     <div class="top-form left label-form"><label for="dropdown__profiles_id$profilerand">' .  __('Profile') . '</label></div>';
      echo '                     <div class="left value-form">';
      $profilerand = mt_rand();
      Profile::dropdownUnder(['name'  => '_profiles_id',
                              'rand'  => $profilerand,
                              'value' => 0]);
      echo '                     </div>';
      echo '                   </div>';
      echo '                   <div class="button">';
      echo '                       <div class="primary-button" onClick="addProfile('.$profilerand.','.$_SESSION['glpiID'].')">' . __('Add') . '</div>';
      echo '                   </div>';
      echo '               </div>';
      echo '           </div>';
      echo '       </div>';
      echo '   </div>';
      echo '</div>';
   }
   
   /**
    * Display contents the principal form of profiles Permission.
    *
    * @param int $start
    *
    * @return void
    */
   static function massiveActions($start) {
      self::headMassiveActions(true);

      self::tableMassiveActions($start);

      self::headMassiveActions(false);
   }

   static function dialogActions() {
      echo '<div id="favDialog" role="dialog" title="Actions" style="width: 40% !important; height: 30% !important">';
      echo '   <div>';
      echo '      <div id="no_information" class="body-dialog">';
      echo '         <img src="/pics/warning.png" alt="Warning"><br><br>';
      echo '         <span class="b">No selected items</span><br>';
      echo '      </div>';  
      echo '      <div id="options_to_select" class="body-dialog">'; 
      echo '         <div class="inline" style="margin-right:10px">Action: </div>';
      $dropdown = self::dropdownActions(['value' => 'actions']); 
      echo '      </div>';
      echo '      <div id="button_confirm_action" style="margin:15px" class="body-dialog">';
      echo '         <div class="primary-button" onClick="removePermission(' . $dropdown . ')">Post</div>';
      echo '      </div>';
      echo '   </div>';
      echo '</div>';
   }

   /**
    * Display contains the options of search in permissions profiles.
    *
    * @param void
    *
    * @return array $tab
    */
   function rawSearchOptions() {
      $tab = [];

      $tab[] = [
         'id'            => 1,
         'table'         => self::getTable(),
         'field'         => 'profile',
         'name'          => __("Profile"),
         'massiveaction' => false,
      ];

      $tab[] = [
         'id'            => 2,
         'table'         => self::getTable(),
         'field'         => 'user',
         'name'          => __("Created By"),
         'massiveaction' => false,
      ];

      return $tab;
   }

   /**
    * Display contents the principal head of profiles Permission.
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
      echo '<div class="primary-button" title="Actions" onClick="openActions()">'. __('Actions') . '</div>';
      echo '</td>';
      echo '</tr>';
      echo '</tbody>';
      echo '</table>';
      echo '</form>';
   }

   /**
    * Display contents the principal table of profiles Permission.
    *
    * @param int $start
    *
    * @return void
    */
   private static function tableMassiveActions($start) {
      echo '<div class="center">';
      echo '<table border="0" class="tab_cadrehov">';
      self::titleTable(1);
      self::bodyTable($start);
      self::titleTable(2);
      echo '</table>';
      echo '</div>';
   }

   /**
    * Display contents the title of principal Table of profiles Permission.
    *
    * @param void
    *
    * @return void
    */
   private static function titleTable($id) {
      echo '<thread>';
      echo '<tbody id="principal_' . $id . '">';
      echo '<tr class="tab_bg_2">';
      echo '<th class="left">';

      $checkboxName = mt_rand();
      Html::showCheckbox(['name' => 'checkAll_' . $checkboxName, 'checked' => false]);

      echo '<script type="text/javascript">';
      echo 'setClickCheckAll("' . $checkboxName . '", true)';
      echo '</script>';

      echo '</th>';
      echo '<th class="left" style="width:30%">';
      echo '<a href="#">Profile</a>';
      echo '</th>';
      echo '<th class="left" style="width:35%">';
      echo '<a href="#">Created By</a>';
      echo '</th>';
      echo '<th>';
      echo '<a href="#">Created At</a>';
      echo '</th>';
      echo '<th style="width:100px">';
      echo '<a href="#">ID</a>';
      echo '</th>';
      echo '</tr>';
      echo '</tbody>';
      echo '</thread>';
   }

   /**
    * Display contents the body of the principal table of profiles Permission.
    *
    * @param int $start
    *
    * @return void
    */
   private static function bodyTable($start) {
      $limit = $_SESSION['glpilist_limit'];

      $result = self::getProfilesUsers();

      echo '<tbody id="data">';

      $count = 0;
      $countStart = 0;
      foreach($result as $row) {
         if ($start <= $count) {
            if ($countStart < $limit) {
               $profile = $row['profile'];
               $user    = $row['firstname_user'] . ' ' . $row['realname_user'];
               $created = $row['created_at'];
               $id      = $row['id'];
            
               echo '<tr class="tab_bg_2">';
               echo '<td width="10" valign="top">';

               $checkboxName = mt_rand();

               Html::showCheckbox(['name' => 'checkAll_' . $checkboxName . '_' . $id, 'checked' => false]);

               echo '<script type="text/javascript">';
               echo 'setClickCheckAll("' . $checkboxName . '_' . $id . '", false)';
               echo '</script>';

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
               echo $id;
               echo '</td>';
               echo '</tr>';
            }
            $countStart++;
         }
         $count++;        
      }
      echo '</tbody>';
   }

   /**
    * Display contents the profiles of profiles Permission.
    *
    * @param void
    *
    * @return array contents the columns of table glpi_plugin_gitlab_profiles_users
    */
   private static function getProfilesUsers() {
      global $DB;
      $result = $DB->request('SELECT `p`.`name` AS `profile`, `u`.`firstname` AS `firstname_user`, 
                                     `u`.`realname` AS `realname_user`, `pu`.`created_at`, `pu`.`id` 
                              FROM `glpi_plugin_gitlab_profiles_users` AS `pu`
                                    LEFT JOIN `glpi_profiles` AS `p` ON (`p`.`id` = `pu`.`profile_id`)
                                    LEFT JOIN `glpi_users` AS `u` ON (`u`.`id` = `pu`.`user_id`)');
      return $result;
   }

   /**
    * Display return registers amount.
    *
    * @param void
    *
    * @return int $amount
    */
   private static function getCountProfilesUsers() {
      global $DB;
      $result = $DB->request(['FROM' => 'glpi_plugin_gitlab_profiles_users', 'COUNT' => 'amount']);
      
      foreach($result as $row) {
         $amount = $row['amount'];
      }

      return $amount;
   }

   /**
    * Display contents at the component of permission profiles.
    *
    * @param array $options
    *
    * @return Dropdown component
    */
    static function dropdownActions(array $options = []) {
      $p = [
         'name'     => 'actions',
         'value'    => 0,
         'showtype' => 'normal',
         'display'  => true,
      ];
   
      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }
   
      $values = []; 
      $values[0] = '----';
      $values[1] = __('Permanently Delete');

      return Dropdown::showFromArray($p['name'], $values, $p);
   }
}