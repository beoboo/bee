<?php

require_once dirname(__FILE__) . '/../../../bootstrap/unit.php';

$t = new lime_test(18);

$dataDir = dirname(__FILE__) . '/../../../data/system';
$sandboxDir = dirname(__FILE__).'/../../../sandbox';

$t->is(nbFileSystem::getFileName($dataDir . '/Class1.php'), 'Class1.php', '->getFileName() returns "Class1.php"');

$t->comment('nbFileSystemTest - Test mkdir');

nbFileSystem::mkdir($sandboxDir . '/dir', true);
$t->ok(is_dir($sandboxDir . '/dir'), 'mkdir() creates dir if it not exists');

try {
  nbFileSystem::mkdir($sandboxDir.'/dir');
  $t->fail(('nbFileSystem::mkdir() trows if directory already exists'));
}
catch( Exception $e) {
  $t->pass('nbFileSystem::mkdir() throws if directory already exists');
}

try {
  nbFileSystem::mkdir($sandboxDir.'/dir/sub1/sub2');
  $t->fail('nbFileSystem::mkdir() throws if parent directory doesn\'t exist');
}
catch( Exception $e) {
  $t->pass('nbFileSystem::mkdir() throws if parent directory doesn\'t exist');
}

nbFileSystem::mkdir($sandboxDir.'/dir/sub1/sub2', true);
$t->ok(file_exists($sandboxDir.'/dir/sub1/sub2'), 'nbFileSystem::mkdir() can create parent folders');

$t->comment('nbFileSystemTest - Test rmdir');

nbFileSystem::mkdir($sandboxDir.'/dir2');
nbFileSystem::rmdir($sandboxDir.'/dir2');
$t->ok(! file_exists($sandboxDir.'/dir2'),'nbFileSystem::rmdir() removes directory');

nbFileSystem::mkdir($sandboxDir.'/dir2/sub',true);
nbFileSystem::touch($sandboxDir.'/dir2/sub/file1');
nbFileSystem::touch($sandboxDir.'/dir2/sub/file2');
nbFileSystem::touch($sandboxDir.'/dir2/file1');
try {
  nbFileSystem::rmdir($sandboxDir.'/dir2');
  $t->fail('nbFileSystem::rmdir() removes only empty folders');
}
catch(Exception $e) {
  $t->pass('nbFileSystem::rmdir() removes only empty folders');
}


nbFileSystem::rmdir($sandboxDir.'/dir2',true);
$t->ok(! file_exists($sandboxDir.'/dir2'),'nbFileSystem::rmdir() can remove folder recursively');

// ?????????????????????????????????????
//try {
//  nbFileSystem::rmdir($sandboxDir.'/dir3');
//  $t->fail('nbFileSystem::rmdir() throws if folder doesn\'t exist');
//}
//catch(Exception $e) {
//  $t->pass('nbFileSystem::rmdir() throws if folder doesn\'t exist');
//}

//nbFileSystem::touch($sandboxDir.'/file');
//try {
//  nbFileSystem::rmdir($sandboxDir.'/file');
//  $t->fail('nbFileSystem::rmdir() doesn\'t remove files');
//}
//catch(Exception $e) {
//  $t->pass('nbFileSystem::rmdir() doesn\'t remove files');
//}

$t->comment('nbFileSystemTest - Test touch');

nbFileSystem::touch($sandboxDir.'/file1');
$t->ok(file_exists($sandboxDir.'/file1'),'nbFileSystem::touch() create empty file');

try {
  nbFileSystem::touch($sandboxDir.'/fake-folder/file1');
  $t->fail('nbFileSystem::touch() throws if parent folder doesn\'t exist');
}
catch(Exception $e) {
  $t->pass('nbFileSystem::touch() throws if parent folder doesn\'t exist');
}

$t->comment('nbFileSystemTest - Test Delete');

nbFileSystem::delete($sandboxDir.'/file1');
$t->ok(!file_exists($sandboxDir.'/file1'),'nbFileSystem::delete() remove file');

try {
  nbFileSystem::delete($sandboxDir. '/dir');
  $t->fail('nbFileSystem::delete() can\'t delete folder');
}
catch(Exception $e) {
  $t->pass('nbFileSystem::delete() can\'t delete folder');
}

$t->comment('nbFileSystemTest - Test Copy');

try {
  nbFileSystem::copy($sandboxDir.'/fake-file', $sandboxDir.'/file1');
  $t->fail('nbFileSystem::copy() throws if source file doesn\'t exist');
}
catch(Exception $e) {
  $t->pass('nbFileSystem::copy() throws if source file doesn\'t exist');
}

nbFileSystem::touch($sandboxDir. '/file1');
nbFileSystem::touch($sandboxDir. '/file2');

try {
  nbFileSystem::copy($sandboxDir.'/file1', $sandboxDir.'/file2');
  $t->fail('nbFileSystem::copy() throws if destination file already exists');
}
catch(Exception $e) {
  $t->pass('nbFileSystem::copy() throws if destination file already exists');
}

try {
  nbFileSystem::copy($sandboxDir.'/file1', $sandboxDir.'/file2',true);
  $t->pass('nbFileSystem::copy() can overwrite destination file');
}
catch(Exception $e) {
  $t->fail('nbFileSystem::copy() can overwrite destination file');
}

nbFileSystem::delete($sandboxDir.'/file2');
nbFileSystem::copy($sandboxDir.'/file1', $sandboxDir.'/file2');
$t->ok(file_exists($sandboxDir.'/file1'), 'nbFileSystem::copy() doesn\'t remove source file');
$t->ok(file_exists($sandboxDir.'/file2'), 'nbFileSystem::copy() copies source file to destination file');

nbFileSystem::delete($sandboxDir.'/file2');
nbFileSystem::mkdir($sandboxDir.'/dir4');

nbFileSystem::copy($sandboxDir.'/file1', $sandboxDir.'/dir4');
$t->ok(file_exists($sandboxDir.'/dir4/file1'), 'nbFileSystem::copy() copies source file in another folder maintaining the filename');


//$t->comment('nbFileSystemTest - Test MoveDir');
//
//cleanDir($sandboxDir);
//
//nbFileSystem::mkdir($sandboxDir.'/dir'. '/dir1');
//nbFileSystem::mkdir($sandboxDir.'/dir5');
//nbFileSystem::moveDir($sandboxDir.'/dir'. '/dir1', $sandboxDir.'/dir5');
//$t->ok(file_exists($sandboxDir.'/dir5'. '/dir1'), 'nbFileSystem::moveDir move folder to destination folder');
//$t->ok(!file_exists($sandboxDir.'/dir'. '/dir1'), 'nbFileSystem::moveDir remove from old source the dir moved');
//$t->ok(file_exists($sandboxDir.'/dir'), 'nbFileSystem::moveDir doesn\'t remove parent folders');


function cleanDir($dir)
{
  $finder = nbFileFinder::create('any');
  $files = $finder->add('*')->remove('.')->remove('..')->in($dir);
  foreach($files as $file)
    if(is_dir($file))
      nbFileSystem::rmdir($file,$recursive);
    else
      nbFileSystem::delete($file);
}

