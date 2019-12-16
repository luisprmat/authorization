<?php

namespace Tests;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait DetectRepeatedQueries
{
    public function enableQueryLog()
    {
        DB::enableQueryLog();
    }

    /**
     * Assert there are not repeated queries being executed
     */
    public function assertNotRepeatedQueries()
    {
        $queries = array_column(DB::getQueryLog(), 'query');

        $selects = array_filter($queries, function ($query) {
            return strpos($query, 'select') === 0;
        });

        $selects = array_count_values($selects);

        foreach ($selects as $select => $amount) {
            $this->assertEquals(
                1, $amount,
                sprintf("The following SELECT was executed %s %s:\n\n %s", $amount, Str::plural('time', $amount), $select)
            );
        }
    }

    public function flushQueryLog()
    {
        DB::flushQueryLog();
    }
}
