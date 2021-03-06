<?php

class nbSymfonyClearCacheCommand  extends nbCommand
{
  protected function configure()
  {
    $this->setName('symfony:project-clear-cache')
      ->setBriefDescription('Clear Cache command for a symfony project')
      ->setDescription(<<<TXT
The <info>{$this->getFullName()}</info> command:

  <info>./bee {$this->getFullName()}</info>
TXT
        );

    $this->setArguments(new nbArgumentSet(array(
      new nbArgument('symfony_path', nbArgument::REQUIRED, 'Symfony executable path')
    )));

    $this->setOptions(new nbOptionSet(array(
    )));
  }

  protected function execute(array $arguments = array(), array $options = array())
  {
      $this->logLine('Clear cache');
      $shell = new nbShell();
      $shell->execute('php '.$arguments['symfony_path'].'/symfony cc');
      $this->logLine('Done Clear Cache');
      return true;
  }

}