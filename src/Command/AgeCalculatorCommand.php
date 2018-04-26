<?php

namespace App\Command;

use App\Birthday\AgeCalculation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AgeCalculatorCommand extends Command
{
    protected static $defaultName = 'app:age:calculator';

    /** @var AgeCalculation */
    private $ageCalculator;

    /**
     * AppMyCommandRunCommand constructor.
     * @param AgeCalculation $ageCalculator
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(AgeCalculation $ageCalculator)
    {
        $this->ageCalculator = $ageCalculator;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('My command will calculate how old am I')
            ->addArgument('birthDate', InputArgument::REQUIRED, 'Your birth date')
            ->addOption('adult', null, InputOption::VALUE_NONE, 'Am I an adult?');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $myBirthday = $input->getArgument('birthDate');

        $age = $this->ageCalculator->howOldIAm($myBirthday);

        $io->note(sprintf('I am %s years old', $age));

        if ($input->getOption('adult')) {
            $amIAnAdult = $this->ageCalculator->amIAnAdult($age);

            if ($amIAnAdult === true) {
                $io->success(sprintf('Am I an adult ?   ----  YES !!'));
            } else {
                $io->warning(sprintf('Am I an adult ?   ----  NO !!!'));
            }
        }
    }
}
