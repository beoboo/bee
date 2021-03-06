<?php

require_once dirname(__FILE__) . '/../../../bootstrap/unit.php';

$dataDir = dirname(__FILE__) . '/../../../data/system';

$t = new lime_test(32);

$t->comment('nbFileFinder - Test create');

$finder = nbFileFinder::create();
$t->is($finder->getType(), 'file', '->create() returns a "file" finder.');

$finder = nbFileFinder::create('dir');
$t->is($finder->getType(), 'directory', '->create("dir") returns a "directory" finder.');

$finder = nbFileFinder::create('any');
$t->is($finder->getType(), 'any', '->create("any") returns an "any" finder.');

$finder = nbFileFinder::create('file');
$t->is($finder->getType(), 'file', '->create("file") returns an "file" finder.');

$t->comment('nbFileFinder - Test setType');

$finder = nbFileFinder::create();
$t->is($finder->setType('dir')->getType(), 'directory', '->setType("dir") returns a "directory" finder.');
$t->is($finder->setType('any')->getType(), 'any', '->setType("any") returns an "any" finder.');
$t->is($finder->setType('file')->getType(), 'file', '->setType("file") returns a "file" finder.');

$t->comment('nbFileFinder - Test add');

$finder = nbFileFinder::create('file');
$names = array('Class1.php', 'Class2.php', 'Class3.php');
$files = $finder->add('*.php')->in($dataDir);
$t->is(count($files), 3, '->add() found 3 files');
for($i = 0; $i != count($files); ++$i)
  $files[$i] = nbFileSystem::getFileName($files[$i]);
for($i = 0; $i != count($files); ++$i) {
  $t->ok(in_array($files[$i], $names), '->add() found ' . $files[$i]);
  $names = array_diff($names, array($files[$i]));
  //$t->is(nbFileSystem::getFileName($files[$i]), $names[$i], '->add() found ' . $names[$i]);
}

$t->comment('nbFileFinder - Test remove');

$finder = nbFileFinder::create('file');
$names = array('Class.java');
$files = $finder->remove('*.php')->in($dataDir);
$t->is(count($files), 1, '->remove() found 1 files');
for($i = 0; $i != count($files); ++$i) {
  $t->is(nbFileSystem::getFileName($files[$i]), $names[$i], '->remove("*.php") found ' . $names[$i]);
}

$t->comment('nbFileFinder - Test add and remove');

$finder = nbFileFinder::create('file');
$files = $finder->add('*.java')->remove('*.php')->in($dataDir);
$t->is(count($files), 1, '->add()->remove() found 1 file');

$t->comment('nbFileFinder - Test prune');

$finder = nbFileFinder::create('file');
$names = array('Class.java', 'Class1.php', 'Class2.php');
$files = $finder->prune('pruned')->in($dataDir);
$t->is(count($files), 3, '->prune() found 3 files');
for($i = 0; $i != count($files); ++$i)
  $files[$i] = nbFileSystem::getFileName($files[$i]);
for($i = 0; $i != count($files); ++$i) {
  $t->ok(in_array($files[$i], $names), '->prune() found ' . $files[$i]);
  $names = array_diff($names, array($files[$i]));
  //$t->is(nbFileSystem::getFileName($files[$i]), $names[$i], '->prune() found ' . $names[$i]);
}

$t->comment('nbFileFinder - Test discard');

$finder = nbFileFinder::create('file');
$names = array('Class1.php', 'Class2.php', 'Class3.php');
$files = $finder->discard('Class.java')->in($dataDir);
$t->is(count($files), 3, '->discard() found 3 files');
for($i = 0; $i != count($files); ++$i)
  $files[$i] = nbFileSystem::getFileName($files[$i]);
for($i = 0; $i != count($files); ++$i) {
  $t->ok(in_array($files[$i], $names), '->discard() found ' . $files[$i]);
  $names = array_diff($names, array($files[$i]));
  //$t->is(nbFileSystem::getFileName($files[$i]), $names[$i], '->discard() found ' . $names[$i]);
}

$t->comment('nbFileFinder - Test add and sort');

$finder = nbFileFinder::create('file');
$names = array('Class1.php', 'Class2.php', 'Class3.php');
$finder->sortByName();
$files = $finder->add('*.php')->in($dataDir);
$t->is(count($files), 3, '->add() found 3 files');
for($i = 0; $i != count($files); ++$i) {
  $t->is(nbFileSystem::getFileName($files[$i]), $names[$i], '->add() found ' . $names[$i]);
}

$t->comment('nbFileFinder - Test discard and sort');

$finder = nbFileFinder::create('file');
$names = array('Class1.php', 'Class2.php', 'Class3.php');
$finder->sortByName();
$files = $finder->discard('Class.java')->in($dataDir);
$t->is(count($files), 3, '->discard() found 3 files');
for($i = 0; $i != count($files); ++$i) {
  $t->is(nbFileSystem::getFileName($files[$i]), $names[$i], '->discard() found ' . $names[$i]);
}

$t->comment('nbFileFinder - Test execute function or method');

$GLOBALS['callbackFunctionCount'] = 0;
function callbackFunction()
{
  ++$GLOBALS['callbackFunctionCount'];
}

class CallbackClass
{
  public $callbackMethodCount = 0;
  
  public function callbackMethod()
  {
    ++$this->callbackMethodCount;
  }
}

$finder = nbFileFinder::create('file');
$finder->execute('callbackFunction');
$finder->add('*.php')->in($dataDir);
$t->is($GLOBALS['callbackFunctionCount'], 3, '->execute() calls "callbackFunction" 3 times');

$object = new CallbackClass();
$finder = nbFileFinder::create('file');
$finder->execute(array($object, 'callbackMethod'));
$finder->add('*.php')->in($dataDir);
$t->is($object->callbackMethodCount, 3, '->execute() calls "callbackMethod" 3 times');
