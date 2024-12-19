<?php

namespace App\Services\TextGeneration;

interface TextGenerator
{
    public function getHeader(int $userId): string;

    public function getFooter(int $userId): string;
}
