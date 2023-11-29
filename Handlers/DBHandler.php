<?php

namespace MaplePHP\Log\Handlers;

use MaplePHP\Query\Connect;
use MaplePHP\Query\DB;
use MaplePHP\Query\Create;

class DBHandler extends AbstractHandler
{
    public const TABLE = "logger";

    private $args;

    public function __construct(array $args = array())
    {
        $this->args = $args;
    }

    /**
     * Stream handler
     * @param  string $level
     * @param  string $message
     * @param  string $date
     * @return void
     */
    public function handler(string $level, string $message, array $context, string $date): void
    {
        $set = array_merge([
            "level" => $level,
            "user_id" => ($context['user_id'] ?? 0),
            "message" => $message,
            "data" => json_encode($context),
            "date" => $date
        ], $this->args);

        $insert = DB::insert(static::TABLE)->set($set);
        $insert->execute();
    }

    /**
     * Execute method bellow once an it will automatically create your table!
     * @return void
     */
    public function create(): void
    {

        $mig = new Create(static::TABLE, Connect::prefix());
        $mig->auto();

        // Add/alter columns
        $mig->column("id", [
            "type" => "int",
            "length" => 11,
            "attr" => "unsigned",
            "index" => "primary",
            "ai" => true

        ])->column("user_id", [
            "type" => "int",
            "length" => 11,
            "index" => "index",
            "default" => "0"

        ])->column("level", [
            "type" => "varchar",
            "collate" => true,
            "length" => 30,

        ])->column("message", [
            "type" => "text",
            "collate" => true

        ])->column("data", [
            "type" => "text",
            "collate" => true,
            "null" => true

        ])->column("date", [
            "type" => "datetime",
            "index" => "index"
        ]);

        $mig->execute();
    }
}
