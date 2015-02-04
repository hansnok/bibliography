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
 * Bibliography suggestion processing page.
 *
 * @package    block
 * @subpackage bibliography
 * @copyright  2011 Jorge Villalon, Ignacio Opazo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

// Global variables database and user
global $DB,$USER;

// Gets the form definition
require_once($CFG->dirroot . '/local/bibliography/suggest_form.php');

// If user is not logged in take him out
require_login();

// Get basic data from GET or POST
$courseid = required_param('courseid', PARAM_INT); //if no courseid is given, fail

// Get context from courseid
$context = get_context_instance(CONTEXT_COURSE, $courseid);

// Get course object from database
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

// Basic required Moodle settings for page
$PAGE->set_context($context);
$PAGE->set_course($course);
$PAGE->set_url('/local/bibliography/suggest.php');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('course');
$PAGE->set_title(get_string('suggestbibliography', 'local_bibliography'));
$PAGE->navbar->add(get_string('suggestbibliography', 'local_bibliography'));

// Initialize form, which validates form data from GET or POST
$suggestform = new local_bibliography_suggest_form(
	NULL, 
	array('suggestion'=>null,
	'courseid'=>$courseid, 
	'returnto'=>null));

// If the form was cancelled, return to course
if($suggestform->is_cancelled()) {
	$url = new moodle_url($CFG->wwwroot.'/course/view.php', array('id'=>$course->id));
	redirect($url);
} else 
	// If the form was submitted
	if($suggestform->is_submitted()) {

	// Get the data from the form
	$data = $suggestform->get_data();

	// Create the email to be sent
	$emailcontent = '<html>';
	$emailcontent .= '<h3>' . get_string('suggestbook', 'local_bibliography') . '</h3>';
	$emailcontent .= get_string('fullnamecourse') . ': ' . $course->fullname . '<br/>';
	$emailcontent .= get_string('shortnamecourse') . ': ' . $course->shortname . '<br/>';
	$emailcontent .= get_string('booktitle', 'local_bibliography') . ': ' . $data->booktitle . '<br/>';
	$emailcontent .= get_string('bookauthor', 'local_bibliography') . ': ' . $data->bookauthor . '<br/>';
	$emailcontent .= get_string('bookextra', 'local_bibliography') . ': ' . $data->bookextra . '<br/>';
	$emailcontent .= get_string('fileavailable', 'local_bibliography') . ': ';
	$emailcontent .= (isset($data->fileavailable)) ? (get_string('yes')) : (get_string('no')) . '<br/>';
	$emailcontent .= '</html>';

	// Email from, we use the current user
	$userfrom         = $USER->firstname . ' ' . $USER->lastname . ' <' . $USER->email . '>';

	// Subject of the suggestion email
	$subject          = get_string('emailsubject', 'local_bibliography');
	
	// Email headers for rich email clients
	$headers = 'From: ' . $userfrom . "\r\n" .
    'Reply-To: ' . $userfrom . "\r\n" .
    'Content-Type: text/html; charset="utf-8"' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	// We send the email
	mail($CFG->local_bibliography_email, $subject, $emailcontent, $headers);

	// Create a new renderer for the 'success' page
	$renderer = $PAGE->get_renderer('local_bibliography');
	
	echo $OUTPUT->header();
    echo $renderer->save_link_success(
            new moodle_url('/course/view.php', array('id' => $courseid)));
    echo $OUTPUT->footer();
    die();
}

// If no cancel or submit has been sent, show the empty form
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('suggestbibliography', 'local_bibliography'), 3, 'main');

$suggestform->display();

echo $OUTPUT->footer();