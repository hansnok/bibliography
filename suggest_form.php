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
 * Bibliography suggestion form page.
 *
 * @package    block
 * @subpackage bibliography
 * @copyright  2011 Jorge Villalon, Ignacio Opazo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');

class local_bibliography_suggest_form extends moodleform {
	
	protected $suggestion;
	
	function definition() {
        global $USER, $CFG, $DB;

        // Gets data from previous submit or from database
        $suggestion = $this->_customdata['suggestion'];
        $returnto = $this->_customdata['returnto'];

        // Initializes the form, sets its data to a suggestion object
        $mform    = $this->_form;
        $this->suggestion  = $suggestion;

        // Header
        $mform->addElement('header','general', get_string('suggestbook', 'local_bibliography'));

        // Hidden element for the 'continue' button in the success page
        $mform->addElement('hidden', 'returnto', null);
        $mform->setType('returnto', PARAM_ALPHANUM);
        $mform->setConstant('returnto', $returnto);

        // Text for the book title
        $mform->addElement('text','booktitle', get_string('booktitle', 'local_bibliography'),'maxlength="254" size="50"');
        $mform->addHelpButton('booktitle', 'booktitle', 'local_bibliography');
        $mform->addRule('booktitle', get_string('missingbooktitle', 'local_bibliography'), 'required', null, 'client');
        $mform->setType('booktitle', PARAM_MULTILANG);

        // Text for the book author
        $mform->addElement('text', 'bookauthor', get_string('bookauthor', 'local_bibliography'), 'maxlength="100" size="20"');
        $mform->addHelpButton('bookauthor', 'bookauthor', 'local_bibliography');
        $mform->addRule('bookauthor', get_string('missingbookauthor', 'local_bibliography'), 'required', null, 'client');
        $mform->setType('bookauthor', PARAM_MULTILANG);

        // Text for book extras
        $mform->addElement('text', 'bookextra', get_string('bookextra', 'local_bibliography'), 'maxlength="100" size="20"');
        $mform->addHelpButton('bookextra', 'bookextra', 'local_bibliography');
        $mform->setType('bookextra', PARAM_MULTILANG);

        // Checkbox for file availability
        $mform->addElement('checkbox','fileavailable', get_string('fileavailable', 'local_bibliography'),'id="fileavailable"');
        $mform->addHelpButton('fileavailable', 'fileavailable', 'local_bibliography');
        
        // Hidden course id
        $mform->addElement('hidden', 'courseid', $this->_customdata['courseid']);
        $mform->setType('courseid', PARAM_INT);

        // Action button 'send suggestion'
        $this->add_action_buttons(true, get_string('sendsuggestion', 'local_bibliography'));

        // Sets the form data, i.e. obtains the current values from the suggestion object
        $this->set_data($suggestion);		
	}
}