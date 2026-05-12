<?php

namespace Tests\Unit;

use App\Services\RedsysService;
use Tests\TestCase;

class RedsysServiceTest extends TestCase
{
    public function test_it_creates_the_official_redsys_operation_key_example()
    {
        config(['redsys.secret_key' => 'sq7HjrUOBfKmC576ILgskD5srU870gJ7']);

        $service = new RedsysService();

        $this->assertSame('RWt3/IPTzYRMXsQtkiGRKg==', $service->createMerchantOperationKey('1234567890'));
    }

    public function test_it_converts_euro_amounts_to_cents_without_decimals()
    {
        $service = new RedsysService();

        $this->assertSame('1249', $service->amountToCents('12.49'));
    }
}
