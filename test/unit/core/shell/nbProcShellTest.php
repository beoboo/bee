<?php

require_once dirname(__FILE__) . '/../../../bootstrap/unit.php';

$t = new lime_test(20);

$t->comment('nbShellTest - Test execute (success) without output redirecting');
$shell = new nbProcShell();
ob_start();
$ret = $shell->execute('dir');
$contents = ob_get_contents();
ob_end_clean();
$t->ok($ret, '->execute() has succeeded');
$t->ok(strlen($contents) > 0, '->execute() writes to console');
$t->ok(strlen($shell->getOutput()) > 0, '->getOutput() returns a message');
$t->is(strlen($shell->getError()), 0, '->getError() returns an empty message');
$t->is($shell->getReturnCode(), 0, '->execute() return code is "0"');

$t->comment('nbShellTest - Test execute (success) with output redirecting');
$shell = new nbProcShell(true);
ob_start();
$ret = $shell->execute('dir');
$contents = ob_get_contents();
ob_end_clean();
$t->ok($ret, '->execute() has succeeded');
$t->is(strlen($contents), 0, '->execute() don\'t writes to console');
$t->ok(strlen($shell->getOutput()) > 0, '->getOutput() returns a message');
$t->is(strlen($shell->getError()), 0, '->getError() returns an empty message');
$t->is($shell->getReturnCode(), 0, '->execute() return code is "0"');

$t->comment('nbShellTest - Test execute (error) without output redirecting');
$shell = new nbProcShell();
ob_start();
$ret = $shell->execute('dir /e');
$contents = ob_get_contents();
ob_end_clean();
$t->ok(!$ret, '->execute() has failed');
$t->ok(strlen($contents) > 0, '->execute() writes to console');
$t->is(strlen($shell->getOutput()), 0, '->getOutput() returns an empty message');
$t->ok(strlen($shell->getError()) > 0, '->getError() returns a message');
$t->isnt($shell->getReturnCode(), 0, '->execute() return code isn\'t "0"');

$t->comment('nbShellTest - Test execute (error) with output redirecting');
$shell = new nbProcShell(true);
ob_start();
$ret = $shell->execute('dir /e');
$contents = ob_get_contents();
ob_end_clean();
$t->ok(!$ret, '->execute() has failed');
$t->is(strlen($contents), 0, '->execute() don\'t writes to console');
$t->is(strlen($shell->getOutput()), 0, '->getOutput() returns an empty message');
$t->ok(strlen($shell->getError()) > 0, '->getError() returns a message');
$t->isnt($shell->getReturnCode(), 0, '->execute() return code isn\'t "0"');