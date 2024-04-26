<?php

namespace Expressionengine\Coilpack\Commands;

use Expressionengine\Coilpack\Traits\CanAccessRestrictedClass;
use Illuminate\Console\Command;

class EECliCommand extends Command
{
    use CanAccessRestrictedClass;

    public $signature = 'eecli {args?*}';

    public $description = 'Run ExpressionEngine commands through Coilpack';

    private $cli;

    public function __construct()
    {
        parent::__construct();

        if (($_SERVER['argv'][1] ?? '') != 'eecli') {
            return;
        }

        $core = (new \Expressionengine\Coilpack\Bootstrap\LoadExpressionEngine)->cli()->bootstrap(app());
        $this->cli = $core->runGlobal();

        $this->setupCommand($_SERVER['argv'][2] ?? 'list');

        foreach ($_SERVER['argv'] as $arg) {
            // If we have a help flag we need to get out early so that it can be
            // handled by the ExpressionEngine Command and not by Symfony/Laravel
            if ($arg == '--help') {
                return $this->handle();
            }
        }
    }

    protected function setupCommand($command)
    {
        $availableCommands = $this->callRestrictedMethod($this->cli, 'availableCommands');

        if (! array_key_exists($command, $availableCommands)) {
            exit("Command '$command' not found.");
        }

        $arguments = array_filter($_SERVER['argv'], function ($argument) {
            return strpos($argument, '--') !== 0;
        });
        $command = $arguments[2] ?? 'list';

        $this->setRestrictedProperty($this->cli, 'commandCalled', $command);
        $this->setRestrictedProperty($this->cli, 'arguments', array_slice($this->cli->command->argv->get(), 3));

        $commandClass = new $availableCommands[$command];

        $this->description = $this->getRestrictedProperty($commandClass, 'description');

        $this->callRestrictedMethod($commandClass, 'loadOptions');
        // Convert ExpressionEngine Command's option syntax into Laravel's and update the signature
        $options = $this->getRestrictedProperty($commandClass, 'commandOptions');
        $this->signature = $this->signature.' '.implode(' ', array_map(function ($option) {
            if (strpos($option, 'verbose') !== false) {
                return '';
            }

            $pieces = explode(',', $option);
            if (count($pieces) == 2) {
                $option = substr($pieces[1], 0, 1).'|'.$pieces[0];
            }

            return '{--'.$option.'=}';
        }, array_keys($options)));

        $this->configureUsingFluentDefinition();
    }

    public function handle(): int
    {
        return $this->cli->process();
    }
}
