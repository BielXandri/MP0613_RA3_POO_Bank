<?php namespace ComBank\Transactions;
 
/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */ 
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
            // Funds available
            $newBalance = $currentBalance - $amountToWithdraw;
            $account->setBalance($newBalance);
            return $newBalance;
        } else {
            // Check for overdraft
            $overdraftStrategy = $account->getOverdraft();
            $neededFunds = $amountToWithdraw - $currentBalance;

            if ($overdraftStrategy->isGrantOverdraftFunds($neededFunds)) {
                // Grant overdraft
                $newBalance = $currentBalance - $amountToWithdraw; // This will be negative
                $account->setBalance($newBalance);
                return $newBalance;
            } else {
                throw new InvalidOverdraftFundsException(
                    "Insufficient funds and overdraft not allowed or not enough for this withdrawal. Needed: {$amountToWithdraw}, Available: {$currentBalance}"
                );
            }
        }
    }

    public function getTransactionInfo(): string
    {
        return "Withdrawal of " . $this->amount;
    }
}
