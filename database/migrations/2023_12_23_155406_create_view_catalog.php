<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW view_catalog AS
                SELECT
                    tB.id,
                    tB.title,
                    tB.publisher,
                    tB.edition,
                    tB.year,
                    tB.value,
                    tA.name,
                    tS.description
                FROM book tB
                INNER JOIN book_author tBA ON tB.id = tBA.book_id
                INNER JOIN author tA ON tBA.author_id = tA.id
                INNER JOIN book_subject tBS ON tB.id = tBS.book_id
                INNER JOIN subject tS ON tBS.subject_id = tS.id
                ORDER BY tA.name;
            "
        );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        DB::statement("DROP VIEW view_catalog");
    }
};
