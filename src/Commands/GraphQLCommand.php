<?php

namespace Expressionengine\Coilpack\Commands;

use Illuminate\Console\Command;

class GraphQLCommand extends Command
{
    public $signature = 'coilpack:graphql {--generate-token}';

    public $description = "Setup Coilpack's GraphQL implementation";

    public function handle(): int
    {
        if ($this->option('generate-token')) {
            $this->generateToken();
        }

        return self::SUCCESS;
    }

    protected function generateToken()
    {
        $token = bin2hex(random_bytes(32));
        $variable = 'COILPACK_GRAPHQL_TOKEN';
        $contents = file_get_contents($this->laravel->environmentFilePath());

        if (strpos($contents, $variable) !== false) {
            $this->warn('Oops! A token is already defined.');

            return;
        }

        file_put_contents($this->laravel->environmentFilePath(),
            $contents."\n"."$variable=$token"
        );

        $this->info('A new token has been generated!');
    }
}
