<?php

namespace App\Domain\Model\Loan;

use InvalidArgumentException;

class LoanTerm
{
    private Term $term;

    public function __construct(int $term)
    {
        if (!in_array($term, Term::list())) {
            throw new InvalidArgumentException('Term must be either 12 or 24.');
        }

        $this->term = Term::tryFrom($term);
    }

    public function getTerm(): Term
    {
        return $this->term;
    }
}
