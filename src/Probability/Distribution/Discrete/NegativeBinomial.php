<?php
namespace MathPHP\Probability\Distribution\Discrete;

use MathPHP\Exception\MathException;
use MathPHP\Probability\Combinatorics;
use MathPHP\Functions\Support;

/**
 * Negative binomial distribution (Pascal distribution)
 * https://en.wikipedia.org/wiki/Negative_binomial_distribution
 */
class NegativeBinomial extends Discrete
{
    /**
     * Distribution parameter bounds limits
     * r ∈ [0,∞)
     * p ∈ [0,1]
     * @var array
     */
    const PARAMETER_LIMITS = [
        'r' => '[0,∞)',
        'p' => '[0,1]',
    ];

    /**
     * Distribution support bounds limits
     * x ∈ [0,∞)
     * @var array
     */
    const SUPPORT_LIMITS = [
        'x' => '[0,∞)',
    ];

    /** @var int number of successful events */
    protected $r;

    /** @var float probability of success on an individual trial */
    protected $p;

    /**
     * Constructor
     *
     * @param  int   $r number of failures until the experiment is stopped
     * @param  float $p probability of success on an individual trial
     */
    public function __construct(int $r, float $p)
    {
        parent::__construct($r, $p);
    }

    /**
     * Probability mass function
     *
     *               / x + r - 1 \
     * b(k; r, p) = |             | (1 - p)ˣ pʳ
     *               \     x     /
     *
     *
     *            = ₓ₊ᵣ₋₁Cₓ (1 - p)ˣ pʳ
     *
     * @param  int $x number of successes
     *
     * @return float
     *
     * @throws MathException
     */
    public function pmf(int $x): float
    {
        Support::checkLimits(self::SUPPORT_LIMITS, ['x' => $x]);

        $r = $this->r;
        $p = $this->p;

        $ₓ₊ᵣ₋₁Cₓ = Combinatorics::combinations($x + $r - 1, $x);
        $⟮1 − p⟯ˣ = pow(1 - $p, $x);
        $pʳ      = pow($p, $r);
    
        return $ₓ₊ᵣ₋₁Cₓ * $⟮1 − p⟯ˣ * $pʳ;
    }
}
