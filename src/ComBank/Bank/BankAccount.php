<?php

namespace ComBank\Bank;

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Exceptions\BankAccountException;

class BankAccount implements BankAccountInterface
{
    private float $balance;
    private bool $status; 
    private ?OverdraftInterface $overdraft; // CORRECCIÓN 1: Permite NULL

    public function __construct(float $initialBalance = 0.0, ?OverdraftInterface $overdraft = null)
    {
        if ($initialBalance < 0) {
            throw new BankAccountException("Initial balance cannot be negative.");
        }

        $this->balance = $initialBalance;
        $this->status = true; 
        $this->overdraft = $overdraft;
    }


    public function transaction(BankTransactionInterface $transaction): void
    {
        if (!$this->isOpen()) {
            throw new BankAccountException("Account is closed. Cannot perform transactions.");
        }
        $transaction->applyTransaction($this);
    }

    public function isOpen(): bool
    {
        return $this->status;
    }

    public function reopenAccount(): void
    {
        if ($this->isOpen()) {
            throw new BankAccountException("Account is already open.");
        }
        $this->status = true;
    }

    public function closeAccount(): void
    {
        if (!$this->isOpen()) {
            throw new BankAccountException("Account is already closed.");
        }
        $this->status = false;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getOverdraft(): ?OverdraftInterface 
    {
        return $this->overdraft;
    }

    public function applyOverdraft(OverdraftInterface $overdraft): void
    {
        $this->overdraft = $overdraft;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }
}