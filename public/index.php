<?php
session_start();

define("_ROOT", dirname(__DIR__));
define("_SRC", _ROOT."/src");
define("_VIEW", _SRC."/View");
define("_PUB", _ROOT."/public");
define("_UPLOAD", _PUB."/uploads");

require _SRC."/autoload.php";
require _SRC."/helper.php";
require _SRC."/web.php";