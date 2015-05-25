<?php

define('PACKAGE_VERSION', '0.0.3');

require_once 'phar://console.phar/CommandHandler.php';
require_once 'phar://console.phar/Config.php';
require_once 'phar://console.phar/FileTokenizer.php';
require_once 'phar://console.phar/Command.php';

if (in_array('-v', $argv) || in_array('-version', $argv)) {
    exit("lib-console package version :- " . PACKAGE_VERSION . PHP_EOL);
}

if (in_array('-h', $argv) || in_array('-help', $argv)) {
    $str = <<<EO
lib-console help
           -v | -version    Displays current lib-console version
           -h | -help       Display help menu for lib-console       
EO;
    exit($str . PHP_EOL);
}

try {
    $commandHandler = CommandHandler::init();

    if (in_array('-ls', $argv) || in_array('-list-commands', $argv)) {
        $commands = implode(PHP_EOL, $commandHandler->getCommandList());
        $str = <<<EO
lib-console - command listing

$commands
           
EO;
        exit($str . PHP_EOL);
    }

    $commandHandler->setCommand($argv);
    $commandHandler->handle();
} catch (Exception $e) {
    print "ERROR: " . $e->getMessage() . PHP_EOL;
}