<?php

require_once  'vendor/autoload.php';

//Initialzing CommandHandler  class with config and cli arguments
$commandHandler = CommandHandler::init();
$commandHandler->setCommand($argv);

//launch command handler
$commandHandler->handle();