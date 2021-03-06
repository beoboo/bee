<?php
require_once dirname(__FILE__) . '/../../../../test/bootstrap/unit.php';
$configParser->parseFile(dirname(__FILE__) . '/../config/config.yml');
$serviceContainer->pluginLoader->loadPlugins(array('nbSymfonyPlugin'));

$t = new lime_test(1);
$cmd = new nbSymfonyClearCacheCommand();
echo $command_line =  nbConfig::get('nb_symfony_plugin_test_symfony_dir');
$t->ok($cmd->run(new nbCommandLineParser(),$command_line),'Command SymfonyClearCache called succefully');
