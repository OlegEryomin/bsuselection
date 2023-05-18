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
 * The main mod_bsuselection configuration form.
 *
 * @package     mod_bsuselection
 * @copyright   Eryomin Oleg eremin_o@bsu.edu.ru Belgorod State University
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form.
 *
 * @package    mod_bsuselection
 * @copyright  Eryomin Oleg eremin_o@bsu.edu.ru Belgorod State University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_bsuselection_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        // Adding the "general" fieldset, where all the common settings are shown.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('bsuselectionname', 'mod_bsuselection'), array('size' => '64'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'bsuselectionname', 'mod_bsuselection');

        // Adding the standard "intro" and "introformat" fields.
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements();
        } else {
            $this->add_intro_editor();
        }

        //-------------------------------------------------------------------------------
        $mform->addElement('header', 'bsuselectionfieldset', get_string('bsuselectionfieldset', 'bsuselection'));

        $repeatarray = array();
        $repeatarray[] = $mform->createElement('text', 'namevalue', get_string('namevalue', 'bsuselection'));
        $repeatarray[] = $mform->createElement('select', 'quiz', get_string('quiz', 'bsuselection'), $this->get_quiz());
        $repeatarray[] = $mform->createElement('text', 'maxball', get_string('maxball', 'bsuselection'));

        $this->repeat_elements($repeatarray, count($this->get_quiz()),
            null, 'bsuselection_repeats', 'bsuselection_add_fields', 3, null, true);

        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();
    }

    function get_quiz(){
        $course = $this->get_course();
        $mods = get_course_mods($course->id);

        foreach ($mods as $mod){
            if ($mod->modname == 'quiz'){
                $quiz = get_coursemodule_from_id('quiz', $mod->id);
                $quiznames[$quiz->id] =  $quiz->name;
            }
        }

        return $quiznames;
    }
}