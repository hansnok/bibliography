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
 * Bibliography admin settings.
 *
 * @package    block
 * @subpackage bibliography
 * @copyright  2011 Jorge Villalon, Ignacio Opazo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
global $PAGE;
if ($hassiteconfig) {
	
 	$settings = new admin_settingpage('local_bibliography', 'Bibliography');
    $ADMIN->add('localplugins', $settings);
    
	// Primo URL prefix
	$settings->add(new admin_setting_configtext('local_bibliography_primourl_pre', 
	get_string('primourl_pre', 'local_bibliography'), 
	get_string('configprimourl_pre', 'local_bibliography'), '', PARAM_URL));

	// Primo URL suffix
	$settings->add(new admin_setting_configtext('local_bibliography_primourl_post', 
	get_string('primourl_post', 'local_bibliography'),
	get_string('configprimourl_post', 'local_bibliography'), '', PARAM_TEXT));

	// Email for students to send suggestions
	$settings->add(new admin_setting_configtext('local_bibliography_email', 
	get_string('email', 'local_bibliography'),
	get_string('configemail', 'local_bibliography'), '', PARAM_EMAIL));

	// Regular expression to obtain course code from shortname
	$settings->add(new admin_setting_configtext('local_bibliography_course_code_regex', 
	get_string('course_code_regex', 'local_bibliography'),
	get_string('configcourse_code_regex', 'local_bibliography'), '', PARAM_TEXT));

	// HTML for teacher's help
	$settings->add(new admin_setting_confightmleditor('local_bibliography_teacher_help', 
	get_string('teacher_help', 'local_bibliography'),
	get_string('configteacher_help', 'local_bibliography'), '', PARAM_CLEANHTML));

	// HTML for student's help
	$settings->add(new admin_setting_confightmleditor('local_bibliography_student_help', 
	get_string('student_help', 'local_bibliography'),
	get_string('configstudent_help', 'local_bibliography'), '', PARAM_CLEANHTML));
	
}


