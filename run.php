<?php

require_once  'vendor/autoload.php';

//Initialzing CommandHandler  class with config and cli arguments
$runner = new CommandHandler(new Config(), $argv);

//launch command handler
$runner->handle();