<?php

/*
 * This file is part of the HeltheTurbolinksBundle package.
 *
 * (c) Carl Alexander <carlalexander@helthe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Helthe\Bundle\TurbolinksBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

/**
 * Command that installs the turbolinks component assets in the bundle resources directory.
 *
 * @author Carl Alexander <carlalexander@helthe.co>
 */
class InstallCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('helthe:turbolinks:install')
            ->setDescription('Install turbolinks public assets into the bundle resources directory')
            ->setHelp(<<<EOT
The <info>helthe:turbolinks:install</info> command installs turbolinks
public assets into the bundle resources directory.

  <info>php app/console helthe:turbolinks:install</info>
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bundleDir = $this->getBundleDir();
        $componentDir = $this->getComponentDir();
        $filesystem = $this->getContainer()->get('filesystem');

        $filesystem->mkdir($bundleDir, 0777);

        $output->writeln('Installing turbolinks assets from <comment>"Helthe\Component\Turbolinks"</comment> into <comment>"%s"</comment>');

        $filesystem->mirror($componentDir, $bundleDir, Finder::create()->ignoreDotFiles(false)->in($componentDir));
    }

    /**
     * Get the bundle resources directory.
     *
     * @return string
     */
    private function getBundleDir()
    {
        $rc = new \ReflectionClass('Helthe\Bundle\TurbolinksBundle\HeltheTurbolinksBundle');

        return dirname($rc->getFileName()) . '/Resources/public';
    }

    /**
     * Get the component resources directory.
     *
     * @return string
     */
    private function getComponentDir()
    {
        $rc = new \ReflectionClass('Helthe\Component\Turbolinks\EventListener\CrossDomainListener');

        return dirname($rc->getFileName()) . '/../Resources/public';
    }
}
