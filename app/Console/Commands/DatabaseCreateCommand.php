<?php

namespace App\Console\Commands;

use PDO;
use PDOException;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as ConsoleCommand;

class DatabaseCreateCommand extends Command
{
    protected string $database;
    protected string $charset;
    protected string $collation;
    protected $signature = 'database:create';
    protected $description = 'Creates the main database';

    public function __construct()
    {
        $this->database = env('DB_DATABASE', false);
        $this->charset = env('DB_CHARSET', false);
        $this->collation = env('DB_COLLATION', false);
        parent::__construct();
    }

    public function handle(): int
    {
        if (!$this->database) {
            $this->info('Skipping creation of database as env(DB_DATABASE) is empty');
            return ConsoleCommand::FAILURE;
        }
        if (!$this->charset || !$this->collation) {
            $this->info('Skipping creation of database as env(DB_CHARSET) or env(DB_COLLATION) are empty');
            return ConsoleCommand::FAILURE;
        }

        try {
            $pdo = $this->getPDOConnection(env('DB_HOST'), env('DB_PORT'), env('DB_USERNAME'), env('DB_PASSWORD'));

            echo $pdo->exec(
                sprintf(
                    'CREATE DATABASE %s CHARACTER SET %s COLLATE %s;',
                    $this->database,
                    $this->charset,
                    $this->collation
                )
            );

            $this->info(sprintf('Successfully created %s database', $this->database));
            return ConsoleCommand::SUCCESS;
        } catch (PDOException $exception) {
            $this->error(sprintf('Failed to create %s database; %s', $this->database, $exception->getMessage()));
            return ConsoleCommand::FAILURE;
        }
    }


    private function getPDOConnection(string $host, int $port, string $username, string $password): PDO
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }

}
