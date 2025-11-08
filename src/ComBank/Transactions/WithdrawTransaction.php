<?php 

namespace ComBank\Transactions;
 
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Transactions\BaseTransaction;
use ComBank\Exceptions\FailedTransactionException;
 
class WithdrawTransaction extends BaseTransaction
{
    public function applyTransaction(BankAccountInterface $account): float
    {
        $currentBalance = $account->getBalance();
        $amountToWithdraw = $this->amount;

        if ($currentBalance >= $amountToWithdraw) {
            $newBalance = $currentBalance - $amountToWithdraw;
            $account->setBalance($newBalance);
            return $newBalance;
        } 
        
        $overdraftStrategy = $account->getOverdraft();
        $neededFunds = $amountToWithdraw - $currentBalance;
        
        if ($overdraftStrategy !== null && $overdraftStrategy->isGrantOverdraftFunds($neededFunds)) {
            $newBalance = $currentBalance - $amountToWithdraw; 
            $account->setBalance($newBalance);
            return $newBalance;
        } 
        
        throw new FailedTransactionException(
            "Withdrawal amount exceeds available balance and overdraft limit. Needed: {$amountToWithdraw}, Available: {$currentBalance}"
        );
    }

    public function getTransactionInfo(): string
    {
        return "Withdrawal of " . $this->amount;
    }
}
