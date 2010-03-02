<?php

/**
 * Launches unit tests.
 *
 * @package    bee
 * @subpackage command
 */
class nbTestUnitCommand extends nbCommand
{
  protected function configure()
  {
    $this->setName('test:unit')
      ->setBriefDescription('run unit tests')
      ->setDescription('')
      ->setArguments(new nbArgumentSet(array(
        new nbArgument('name', nbArgument::OPTIONAL | nbArgument::IS_ARRAY, 'The test name'),
      )));
  }
  
  protected function execute(array $arguments = array(), array $options = array())
  {
    if(count($arguments['name'])) {
      $files = array();

      foreach($arguments['name'] as $name) {
        $finder = nbFileFinder::create('file')->followLink()->add(basename($name) . 'Test.php');
        //$files = array_merge($files, $finder->in(sfConfig::get('sf_test_dir').'/unit/'.dirname($name)));
        $files = array_merge($files, $finder->in(dirname(__FILE__) . '/../../../test/unit/' . dirname($name)));
      }

      if(count($files) > 0) {
        foreach ($files as $file)
          include($file);
      }
      else
        $this->log('no tests found', 'error');
    }
    else
    {
      require_once dirname(__FILE__) . '/../../../vendor/lime/lime.php';

      $h = new lime_harness();

      // filter and register unit tests
      $finder = nbFileFinder::create('file')->add('*Test.php');
      $h->register($finder->in(dirname(__FILE__) . '/../../../test/unit/'));

      $ret = $h->run() ? 0 : 1;

//      // filter and register unit tests
//      $finder = sfFinder::type('file')->follow_link()->name('*Test.php');
//      $h->register($this->filterTestFiles($finder->in($h->base_dir), $arguments, $options));
//
//      $ret = $h->run() ? 0 : 1;
//
//      if ($options['xml'])
//      {
//        file_put_contents($options['xml'], $h->to_xml());
//      }

      return $ret;
    }
  }
}