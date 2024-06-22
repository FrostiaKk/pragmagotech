<?php

namespace App\Domain\Model\Loan;

class Loan
{
    public function __construct(private readonly LoanAmount $amount, private readonly LoanTerm $term)
    {
    }

    public function getAmount(): LoanAmount
    {
        return $this->amount;
    }

    public function getTerm(): LoanTerm
    {
        return $this->term;
    }
}