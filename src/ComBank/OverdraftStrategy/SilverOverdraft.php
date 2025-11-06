<?php namespace ComBank\OverdraftStrategy;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:39 PM
 */
/**
 * @description: Grant 100.00 overdraft funds.
 * */
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
class SilverOverdraft implements OverdraftInterface
{
            private const OVERDRAFT_LIMIT = 500.00; // Example limit
    public function isGrantOverdraftFunds(float $amount): bool
    {
        // For a withdrawal, $amount would be positive. We check if the absolute amount
        // is within the overdraft limit.
        return abs($amount) <= self::OVERDRAFT_LIMIT;
    }
    public function getOverdraftFundsAmount(): float
    {
        return self::OVERDRAFT_LIMIT;
    }
}

