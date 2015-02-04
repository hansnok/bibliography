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
 * Bibliography capabilities
 *
 * @package    block
 * @subpackage bibliography
 * @copyright  2011 Jorge Villalon, Ignacio Opazo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// We define a new capability, the ability to modify the bibliography
$capabilities = array(

    'local/bibliography:modify' => array(
    	// Capability type (write, read, etc.)
        'captype' => 'write',
        // Context in which the capability can be set (course, category, etc.)
        'contextlevel' => CONTEXT_COURSE,
        // Default values for different roles (only teachers and managers can modify)
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
)
)
);