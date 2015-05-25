<html>
<head>
</head>
<body>
<?php
global $COURSE, $USER, $CFG;

require_once (dirname(dirname(__FILE__)).'/config.php');
require_once ($CFG->dirroot . '/course/lib.php');
require_once ($CFG->dirroot . '/lib/accesslib.php');
require_once ($CFG->dirroot . '/lib/moodlelib.php');
require_once ($CFG->dirroot . '/lib/weblib.php');

// Aqui se obtiene el shortname del curso
$coursecode = optional_param('coursesn', null, PARAM_ALPHANUMEXT);
$courseid = optional_param('courseid', 0, PARAM_INT);



?>
</body>
</html>