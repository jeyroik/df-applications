<?php
namespace deflou\components\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use deflou\components\applications\AppReader;
use deflou\components\applications\AppWriter;
use deflou\components\applications\EStates;
use Symfony\Component\Filesystem\Filesystem;

class InstallAppsCommand extends Command
{
    public const OPTION__PATH = 'path';

    /**
     * Configure the current command.
     */
    protected function configure()
    {
        $this
            ->setName('install-apps')
            ->setAliases(['ia'])
            ->setDescription('Install Applications')
            ->setHelp('This command allows you to Install all aplications - download and install packages.')
            ->addOption(
                static::OPTION__PATH,
                'p',
                InputOption::VALUE_OPTIONAL,
                'Path to install packages',
                getcwd() . '/runtime'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|mixed
     * @throws
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getOption(static::OPTION__PATH);

        $reader = new AppReader([
            AppReader::FIELD__INSTALL_PATH => $path
        ]);
        $writer = new AppWriter([
            AppWriter::FIELD__INSTALL_PATH => $path,
            AppWriter::FIELD__INSTALL_CHECK => false
        ]);

        $apps = $reader->getAppsByState(EStates::Accepted);

        $output->writeln(['Begin installation...']);
        $start = time();

        foreach ($apps as $app) {
            $writer->installApp($app->getId());
        }

        list($installed, $notInstalled) = $reader->checkApps($apps);

        if (!empty($installed)) {
            $output->writeln(['Installed applications: ']);
            $output->writeln(array_column($installed, 'title'));

            $output->writeln(['Not installed applications: ']);
            $output->writeln(array_column($notInstalled, 'title'));

            $end = time() - $start;
            $output->writeln(['Ready for ' . $end . ' s.']);
        }

        $fs = new Filesystem();
        $fs->chmod([$path . '/composer.json', $path . '/composer.lock'], 0777);
        $fs->chmod($path . '/vendor', 0777, recursive: true);

        return 0;
    }
}
