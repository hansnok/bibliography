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
 *
 *
 * @package    local
 * @subpackage bibliography
 * @copyright  2015 Jorge Villalon
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_bibliography\task;

use \stdClass;

class download_primo_urls extends \core\task\scheduled_task
{

    public function get_name()
    {
        // Shown in admin screens
        return get_string('donwloadprimourls', 'local_bibliography');
    }

    public function execute()
    {
        global $CFG, $DB;
        
        require_once($CFG->dirroot . '/local/bibliography/locallib.php');
        
        mtrace("Starting download of primo URLs");
        
        list($totalurls, $numcourseocodes) = local_bibliography_download_urls();

        mtrace("A total of $totalurls were downloaded for $numcourseocodes course codes.");
    }
}