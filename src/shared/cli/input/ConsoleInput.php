<?php declare(strict_types = 1);
namespace PharIo\Phive\Cli;

class ConsoleInput implements Input {

    /** @var Output */
    private $output;

    /** @var resource */
    private $inputStream;

    public function __construct(Output $output, $inputStreamHandle = \STDIN) {
        $this->output      = $output;
        $this->inputStream = $inputStreamHandle;
    }

    public function confirm(string $message, bool $default = true): bool {
        $yesOption = $default === true ? 'Y' : 'y';
        $noOption  = $default === false ? 'N' : 'n';

        do {
            $this->output->writeText(\rtrim($message) . \sprintf(' [%s|%s] ', $yesOption, $noOption));
            $response = \strtolower(\rtrim(\fgets($this->inputStream)));
        } while (!\in_array($response, ['y', 'n', '']));

        if ($response === '') {
            return $default;
        }

        return ($response === 'y');
    }
}
