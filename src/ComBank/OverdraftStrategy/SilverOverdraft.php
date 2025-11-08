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
    /** @var float El límite de sobregiro específico para esta instancia. */
    private float $overdraftLimit;

    /**
     * Constructor que acepta el límite de sobregiro como argumento.
     * Esto resuelve el error "does not have any constructor and shall be called without arguments".
     * @param float $limit El monto del límite de sobregiro (ej: 100.0).
     */
    public function __construct(float $limit)
    {
        $this->overdraftLimit = $limit;
    }

    public function isGrantOverdraftFunds(float $amount): bool
    {
        // Se utiliza la propiedad dinámica $this->overdraftLimit.
        return abs($amount) <= $this->overdraftLimit;
    }

    public function getOverdraftFundsAmount(): float
    {
        // Devuelve el límite de sobregiro que se pasó al constructor.
        return $this->overdraftLimit;
    }
}