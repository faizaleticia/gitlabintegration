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
 * Summary of PluginGitlabIntegrationEventLog
 * */
class PluginGitlabIntegrationEventLog {

    /**
    * Display contents at the begining of event log.
    *
    * @param $items_id, $type, $date, $service, $level, $message
    *
    * @return void
    */
    static public function Log($items_id, $type, $date, $service, $level, $message) {
        global $DB;

        $DB->insert(
            'glpi_events', [
                'items_id' => $items_id,
                'type'     => $type,
                'date'     => $date,
                'service'  => $service,
                'level'    => $level,
                'message'  => $message
            ]
        );
    }

    /**
    * Display contents at the error log of event log.
    *
    * @param $error
    *
    * @return void
    */
    static public function ErrorLog($error) {
        if ($error) {
            $fileLog = fopen(GLPI_ROOT . "/plugins/gitlabintegration/logs/error.log", "a");
            fwrite($fileLog, $error . PHP_EOL);
            fclose($fileLog);
        }
    }

    /**
    * Display contents at the created issue log of event log.
    *
    * @param $issue
    *
    * @return void
    */
    static public function CreatedIssueLog($issue) {
        if ($issue) {
            $fileLog = fopen(GLPI_ROOT . "/plugins/gitlabintegration/logs/created-issue.log", "a");
            fwrite($fileLog, $issue . PHP_EOL);
            fclose($fileLog);
        }
    }
}