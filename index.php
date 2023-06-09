<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Display information about all the mod_bsuselection modules in the requested course.
 *
 * @package     mod_bsuselection
 * @copyright   Eryomin Oleg eremin_o@bsu.edu.ru Belgorod State University
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once("lib.php");

$id = required_param('id', PARAM_INT);   // course
$option = required_param('option', PARAM_INT);
$selectionid = required_param('selectionid', PARAM_INT);

global $PAGE, $CFG, $DB, $USER;

$PAGE->set_url('/mod/bsuselection/index.php', array('id' => $id));

$DB->insert_record('bsuselection_attempts',
    (object)[
        'bsuselectionid' => $selectionid,
        'bsuselectionoptionsid' => $option,
        'userid' => $USER->id,
        'timemodified' => time()
    ]);

redirect("$CFG->wwwroot/course/view.php?id=$id");
