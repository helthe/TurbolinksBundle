<?php

namespace Helthe\Bundle\TurbolinksBundle\Composer;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;
use Composer\Script\CommandEvent;

/**
 * ScriptHandler for the HeltheTurbolinksBundle.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class ScriptHandler
{
    /**
     * Install the component assets under the symfony bundle for better integration
     * with Symfony.
     *
     * @param CommandEvent $event
     */
    public static function installAssets(CommandEvent $event)
    {
        $options = self::getOptions($event);
        $appDir = $options['symfony-app-dir'];

        static::executeCommand($event, $appDir, 'helthe:turbolinks:install', $options['process-timeout']);
    }

    /**
     * Execute command.
     *
     * @param CommandEvent $event
     * @param string       $appDir
     * @param string       $cmd
     * @param integer      $timeout
     *
     * @throws \RuntimeException
     */
    protected static function executeCommand(CommandEvent $event, $appDir, $cmd, $timeout = 300)
    {
        $php = escapeshellarg(self::getPhp());
        $console = escapeshellarg($appDir.'/console');
        if ($event->getIO()->isDecorated()) {
            $console .= ' --ansi';
        }

        $process = new Process($php.' '.$console.' '.$cmd, null, null, null, $timeout);
        $process->run(function ($type, $buffer) { echo $buffer; });
        if (!$process->isSuccessful()) {
            throw new \RuntimeException(sprintf('An error occurred when executing the "%s" command.', escapeshellarg($cmd)));
        }
    }

    /**
     * Get the default options.
     *
     * @param CommandEvent $event
     *
     * @return array
     */
    protected static function getOptions(CommandEvent $event)
    {
        $options = array_merge(array(
            'symfony-app-dir' => 'app',
        ), $event->getComposer()->getPackage()->getExtra());

        $options['process-timeout'] = $event->getComposer()->getConfig()->get('process-timeout');

        return $options;
    }

    /**
     * Get path to the PHP executable.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getPhp()
    {
        $phpFinder = new PhpExecutableFinder;
        if (!$phpPath = $phpFinder->find()) {
            throw new \RuntimeException('The php executable could not be found, add it to your PATH environment variable and try again');
        }

        return $phpPath;
    }
}
