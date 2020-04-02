<?php

namespace Junges\TwoFactorAuth\tests\Traits;

use Junges\TwoFactorAuth\Tests\TestCase;

class HasTwoFactorAuthenticationTest extends TestCase
{
    public function test_it_can_generate_a_random_code()
    {
        $this->user->generateTwoFactorCode();

        $code = $this->user->two_factor_code;

        $this->assertNotNull($code);

        $this->user->generateTwoFactorCode();

        $this->assertNotEquals($code, $this->user->two_factor_code);
    }

    public function test_it_can_reset_the_two_factor_code()
    {
        $this->user->generateTwoFactorCode();

        $this->assertNotNull($this->user->two_factor_code);

        $this->user->resetTwoFactorCode();

        $this->assertNull($this->user->two_factor_code);
    }
}
