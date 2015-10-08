<?php

class msgHandlerTest extends PHPUnit_Framework_TestCase {
	
	/**
    * @dataProvider providerInterest
    */

	public function testgetDailyInterest($in, $out)
	{
		$handler = new msgHandler;
		$this->assertEquals($out, $handler->getDailyInterest($in));
	}

    public function providerInterest ()
    {
        return array (
            array (1, 4),
            array (2, 4),
            array (3, 1),
            array (4, 4),
            array (5, 2),
            array (6, 1),
            array (7, 4),
            array (8, 4),
            array (9, 1),
            array (10, 2),
            array (11, 4),
            array (12, 1),
            array (13, 4),
            array (14, 4),
            array (15, 3),
            array (16, 4)

        );
    }



    /**
    * @dataProvider providerQuery
    */

    public function testbuildQuery($sum, $days, $interest, $totalSum, $token)
    {
        $handler = new msgHandler;

        $in = ['sum' => $sum, 'days' => $days, 'interest' => $interest, 'totalSum' => $totalSum, 'token' => $token];
        $this->assertEquals($in, $handler->buildQuery($sum, $days, $token));
    }

    public function providerQuery ()
    {
        return array (
            ['sum' => 100, 'days' => 1, 'interest' => 4, 'totalSum' => 104, 'token' => 'vp'],
            ['sum' => 100, 'days' => 2, 'interest' => 8, 'totalSum' => 108, 'token' => 'vp'],
            ['sum' => 328, 'days' => 104770282, 'interest' => 985120038, 'totalSum' => 985120366, 'token' => 'vp'],
            ['sum' => 11, 'days' => 1047, 'interest' => 329.89, 'totalSum' => 340.89, 'token' => 'vp']
        );
    }

}
