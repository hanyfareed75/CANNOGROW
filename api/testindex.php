<?php
require_once 'router.php';
require_once 'dispatcher.php';

$route = resolveRoute();         // من router.php
dispatch($route);                // من dispatcher.php
