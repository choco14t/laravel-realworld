<?php

namespace App\ViewModels;

use Carbon\CarbonInterface;

trait FormattableTimestamps
{
    protected function formatFrom(CarbonInterface $dateTime, string $format = 'Y-m-d\TH:i:s.uP')
    {
        return $dateTime->format($format);
    }
}
