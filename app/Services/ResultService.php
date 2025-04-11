<?php

namespace App\Services;

use App\Models\Result;

class ResultService
{
    public function __construct() {}

    public function viewCount($data)
    {
        Result::query()
                ->create($data);
    }
}
