<?php

namespace App\Tests\Unit\Domain\Model\Loan;

use App\Domain\Model\Loan\LoanTerm;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LoanTermTest extends TestCase
{
    public function testValidTerm()
    {
        $term = new LoanTerm(12);
        $this->assertEquals(12, $term->getTerm()->value);
    }

    public function testInvalidTerm()
    {
        $this->expectException(InvalidArgumentException::class);
        new LoanTerm(17);
    }
}
