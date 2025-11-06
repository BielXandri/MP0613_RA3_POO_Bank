<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:24 PM
 */
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Bank\Contracts\BankAccountInterface; 

abstract class BaseTransaction implements BankTransactionInterface
{
    use AmountValidationTrait;

    protected float $amount;

    public function __construct(float $amount)
    {
        $this->validateAmount($amount); 
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    abstract public function applyTransaction(BankAccountInterface $account): float;
    abstract public function getTransactionInfo(): string;
}