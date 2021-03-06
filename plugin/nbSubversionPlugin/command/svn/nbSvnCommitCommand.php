<?php

/**
 * Commit changes to the svn repository.
 *
 * @package    bee
 * @subpackage command
 */
class nbSvnCommitCommand extends nbCommand
{
  protected function configure()
  {
    $this->setName('svn:commit')
      ->setArguments(new nbArgumentSet(array(
        new nbArgument('message', nbArgument::REQUIRED, 'Commit message'),
        new nbArgument('local', nbArgument::OPTIONAL, 'Working copy path', '.')
      )))
      ->setOptions(new nbOptionSet(array(
        new nbOption('username', 'u', nbOption::PARAMETER_REQUIRED, 'Specify an username'),
        new nbOption('password', 'p', nbOption::PARAMETER_REQUIRED, 'Specify a password')
      )))
      ->setBriefDescription('Send changes from your working copy to the repository.')
      ->setDescription(<<<TXT
The <info>{$this->getFullName()}</info> command send changes from your working copy to the repository:

    <info>./bee {$this->getFullName()} message local</info>
TXT
      );
  }

  protected function execute(array $arguments = array(), array $options = array())
  {
    $this->log('Committing changes of ', nbLogger::COMMENT);
    $this->log($arguments['local']);
    $this->log("\n");
    $shell = new nbShell();
    $client = new nbSvnClient();
    
    $command = $client->getCommitCmdLine(
      $arguments['local'],
      $arguments['message'],
      isset($options['username']) ? $options['username'] : '',
      isset($options['password']) ? $options['password'] : ''
    );

    if(!$shell->execute($command)) {
      throw new LogicException(sprintf("
[nbSvnCommitCommand::execute] Error executing command:
  %s
  local    -> %s
  message  -> %s
  username -> %s
  password -> %s
",
        $command, $arguments['local'], $arguments['message'], $options['username'], $options['password']
      ));
    }
  }
}
