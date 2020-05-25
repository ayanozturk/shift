<?php

namespace App\Billing;

/**
 * Class BillingConfig
 */
class BillingConfig
{
    private string $planName;
    private string $siteName;

    public function __construct(string $siteName, string $planName)
    {
        $this->planName = $planName;
        $this->siteName = $siteName;
    }

    public function getPlanName(): string
    {
        return $this->planName;
    }

    public function getSiteName(): string
    {
        return $this->siteName;
    }
}
