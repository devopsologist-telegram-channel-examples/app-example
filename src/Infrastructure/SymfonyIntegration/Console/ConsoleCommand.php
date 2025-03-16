<?php

declare(strict_types=1);

namespace App\Infrastructure\SymfonyIntegration\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ConsoleCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return non-empty-string
     */
    final public static function getDefaultName(): string
    {
        return static::name();
    }

    /**
     * @return non-empty-string
     */
    abstract protected static function name(): string;

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->doExecute($input, new Output($input, $output));
    }

    abstract protected function doExecute(InputInterface $input, Output $output): int;
}
