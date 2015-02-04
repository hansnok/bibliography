<html><head>
 
</head>
<body>
<?php

global $COURSE, $USER, $CFG;

		require_once('../../config.php');
		require_once($CFG->dirroot.'/course/lib.php');
		require_once($CFG->dirroot.'/lib/accesslib.php');
		require_once($CFG->dirroot.'/lib/moodlelib.php');
		require_once($CFG->dirroot.'/lib/weblib.php');
		
		// Creating session variable for caching purposes
		
		if(!isset($_SESSION['bibliography_cache']) || $_SESSION['bibliography_cache'] == NULL) {
			$_SESSION['bibliography_cache']['tmp'] = "Empty cache";
		}

		//Aqui se obtiene el shortname del curso
		
		$coursecode = optional_param('coursesn', null, PARAM_ALPHANUMEXT);
		$courseid = optional_param('courseid', 0, PARAM_INT);
		// Using regular expression from admin to extract course code from shortname
		
		if($CFG->local_bibliography_course_code_regex && preg_match_all('/'.$CFG->local_bibliography_course_code_regex.'/', $coursecode, $regs)) {
			$coursecode = $regs[1][0];
		}

		$bibliografia = get_string('bibliography','local_bibliography').' '. $coursecode.':';
		
		$html1 = $bibliografia;
		
		// Checking if we already have the content cached
		
		if(isset($_SESSION['bibliography_cache'][$coursecode]) && $_SESSION['bibliography_cache'][$coursecode] != NULL) {
			$html1 = $_SESSION['bibliography_cache'][$coursecode];
		} else {

			// URL from Primo server
			
			$url = $CFG->local_bibliography_primourl_pre . strtolower($coursecode) . $CFG->local_bibliography_primourl_post;
			
			$total=0;
			
			try {
				
				// In case we don't have the content cached and the server has problems, we set a timeout
				
				set_time_limit(2);
				
				// Getting the XML from the bibliography server
				
				if(!file_exists($url)) {
					//throw new Exception("Could not connecto to server");
				}
				
				$handle = @fopen($url,"r") or die("could not open file");
				
				
				if(!$handle)
					throw new Exception("Oops");

				$xml = stream_get_contents($handle);
				
				$xml = str_replace("sear:", "", $xml); //Solve the problem with the Prefix in the tag
					
				$element = new SimpleXMLElement($xml);

				foreach($element->JAGROOT->RESULT->DOCSET->DOC as $item) {
					$total++;
					
					//$cleanUrl = str_replace("display", "search", $item->link, 1);
					//resourceid: PrimoNMBib->record->control->recordid
					//name: $item->PrimoNMBib->record->display->title
					
					$html1 .= '<li>' . $total . ' : <a target="_blank" href="http://primo.gsl.com.mx:1701/primo_library/libweb/action/display.do?fn=display&doc='. $item->PrimoNMBib->record->control->recordid .'">'.$item->PrimoNMBib->record->display->title.'</a></li>';
				}

				if($total == 0) {
					$html1 .= get_string('nobooks','local_bibliography');
				}
			} catch(Exception $e) {
				$html1 .= get_string('errorparsing','local_bibliography');;
			}
		    $html2='<div style="color:#8a8d99; font-family: Lucida Grande,Lucida Sans Unicode,Arial,Helvetica,Sans,FreeSans,Jamrul,Garuda,Kalimati; font-size:84%;">'.$html1.'</div>';
		
	}

$OUTPUT = $html2;

echo $OUTPUT;
?>
</body>
</html>