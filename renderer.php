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
 * Bibliography renderer.
 *
 * @package    block
 * @subpackage bibliography
 * @copyright  2011 Jorge Villalon, Ignacio Opazo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class local_bibliography_renderer extends plugin_renderer_base {
	
    /**
     * Display send suggestion success message and a button to be redirected to te referer page
     * @param moodle_url $url the page to be redirected to
     * @return string html
     */
    public function save_link_success(moodle_url $url) {
        $html = $this->output->notification(get_string('suggestionsent', 'local_bibliography'),
                    'notifysuccess');
        $continuebutton = new single_button($url,
                        get_string('continue', 'local_bibliography'));
        $html .= html_writer::tag('div', $this->output->render($continuebutton),
                array('class' => 'continuebutton'));
        return $html;
    }

}