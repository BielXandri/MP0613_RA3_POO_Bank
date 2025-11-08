<?php 
namespace ComBank\OverdraftStrategy;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:39 PM
 */

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

class SilverOverdraft implements OverdraftInterface
{
    private float $overdraftLimit;

    public function __construct(float $limit)
    {
        $this->overdraftLimit = $limit;
    }

    public function isGrantOverdraftFunds(float $amount): bool
    {
        return abs($amount) <= $this->overdraftLimit;
    }

    public function getOverdraftFundsAmount(): float
    {
        return $this->overdraftLimit;
    }
}