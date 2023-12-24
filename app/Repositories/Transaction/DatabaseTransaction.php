<?php

namespace App\Repositories\Transaction;

use Illuminate\Support\Facades\DB;
use Core\UseCase\Interfaces\TransactionInterface;

class DatabaseTransaction implements TransactionInterface
{
    /**
     * Constructor class.
     */
    public function __construct()
    {
        DB::beginTransaction();
    }

    /**
     * Commit transaction in database.
     * @return void
     */
    public function commit(): void
    {
        DB::commit();
    }

    /**
     * Rollback transaction in database.
     * @return void
     */
    public function rollback(): void
    {
        DB::rollBack();
    }
}
