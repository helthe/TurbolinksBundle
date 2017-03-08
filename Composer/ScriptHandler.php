<?php

/*
 * This file is part of the Helthe Turbolinks package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Bundle\TurbolinksBundle\Composer;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;
use Composer\Script\Event;

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
     * @param Event $event
     */
    public static function installAssets(Event $event)
    {
        $options = self::getOptions($event);
        $consoleDir = self::getConsoleDir($event, 'turbolinks install');

        static::executeCommand($event, $consoleDir, 'helthe:turbolinks:install', $options['process-timeout']);
    }

    /**
     * Execute command.
     *
     * @param Event $event
     * @param string       $consoleDir
     * @param string       $cmd
     * @param integer      $timeout
     *
     * @throws \RuntimeException
     */
    protected static function executeCommand(Event $event, $consoleDir, $cmd, $timeout = 300)
    {
        $php = escapeshellarg(self::getPhp());
        $console = escapeshellarg($consoleDir.'/console');
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
     * @param Event $event
     *
     * @return array
     */
    protected static function getOptions(Event $event)
    {
        $options = array_merge(array(
            'symfony-app-dir' => 'app',
            'symfony-bin-dir' => 'bin',
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
    
    /**
     * Returns a relative path to the directory that contains the `console` command.
     *
     * @param Event $event      The command event.
     * @param string       $actionName The name of the action
     *
     * @return string|null The path to the console directory, null if not found.
     */
    protected static function getConsoleDir(Event $event, $actionName)
    {
        $options = self::getOptions($event);

        if (self::useNewDirectoryStructure($options)) {
            if (!self::hasDirectory($event, 'symfony-bin-dir', $options['symfony-bin-dir'], $actionName)) {
                return null;
            }

            return $options['symfony-bin-dir'];
        }

        if (!self::hasDirectory($event, 'symfony-app-dir', $options['symfony-app-dir'], 'execute command')) {
            return null;
        }

        return $options['symfony-app-dir'];
    }

    /**
     * Returns true if the new directory structure is used.
     *
     * @param array $options Composer options
     *
     * @return bool
     */
    protected static function useNewDirectoryStructure(array $options)
    {
        return isset($options['symfony-var-dir']) && is_dir($options['symfony-var-dir']);
    }

    protected static function hasDirectory(Event $event, $configName, $path, $actionName)
    {
        if (!is_dir($path)) {
            $event->getIO()->write(sprintf('The %s (%s) specified in composer.json was not found in %s, can not %s.', $configName, $path, getcwd(), $actionName));

            return false;
        }

        return true;
    }
}
