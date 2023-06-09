<?php
namespace deflou\components\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use deflou\components\applications\ApplicationPackageService;
use deflou\components\applications\packages\EStates;

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

        $appService = new ApplicationPackageService([
            ApplicationPackageService::FIELD__INSTALL_PATH => $path,
            ApplicationPackageService::FIELD__INSTALL_CHECK => false
        ]);

        $packages = $appService->getPackagesByState(EStates::Accepted);

        $output->writeln(['Begin installation...']);
        $start = time();

        foreach ($packages as $p) {
            $appService->installPackage($p->getId());
        }

        list($installed, $notInstalled) = $appService->checkPackages($packages);

        if (!empty($installed)) {
            $output->writeln(['Installed packages: ']);
            $output->writeln(array_column($installed, 'title'));

            $output->writeln(['Not installed packages: ']);
            $output->writeln(array_column($notInstalled, 'title'));

            $end = time() - $start;
            $output->writeln(['Ready for ' . $end . ' s.']);
        }

        return 0;
    }
}
