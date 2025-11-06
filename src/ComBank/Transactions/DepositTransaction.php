<?php namespace ComBank\Transactions;
 
/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */
 
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Transactions\BaseTransaction;
use ComBank\Exceptions\FailedTransactionException;

 
class DepositTransaction extends BaseTransaction
{
    public function applyTransaction(BankAccountInterface $account): float
    {
        $currentBalance = $account->getBalance();
        $newBalance = $currentBalance + $this->amount;
        if ($newBalance < $currentBalance) { 
            throw new FailedTransactionException("Deposit transaction failed.");
        }

        $account->setBalance($newBalance);
        return $newBalance;
    }

    public function getTransactionInfo(): string
    {
        return "Deposit of " . $this->amount;
    }
}

