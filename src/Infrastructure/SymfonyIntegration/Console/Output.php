<?php

declare(strict_types=1);

namespace App\Infrastructure\SymfonyIntegration\Console;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final readonly class Output
{
    private SymfonyStyle $io;

    public function __construct(
        InputInterface $input,
        OutputInterface $output,
    ) {
        $this->io = new SymfonyStyle($input, $output);
    }

    /**
     * @param string|array<string> $messages
     */
    public function writeln(string|array $messages): void
    {
        $this->io->writeln($messages);
    }

    /**
     * @param string|array<string> $message
     */
    public function success(string|array $message): void
    {
        $this->io->success($message);
    }

    /**
     * @param string|array<string> $message
     */
    public function error(string|array $message): void
    {
        $this->io->error($message);
    }

    /**
     * @param string|array<string> $message
     */
    public function warning(string|array $message): void
    {
        $this->io->warning($message);
    }

    /**
     * @param string|array<string> $message
     */
    public function info(string|array $message): void
    {
        $this->io->info($message);
    }

    public function newLine(int $count = 1): void
    {
        $this->io->newLine($count);
    }

    public function title(string $message): void
    {
        $this->io->title($message);
    }

    public function progressBar(string $operations, int $max = 0): ProgressBar
    {
        $progressBar = $this->io->createProgressBar($max);
        $progressBar->setFormat(match (true) {
            $max > 0 => " %current%/%max% {$operations} [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%",
            default => " %current% {$operations} [%bar%] %elapsed:6s% %memory:6s%",
        });

        return $progressBar;
    }
}
