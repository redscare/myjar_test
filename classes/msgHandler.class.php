<?php 

class msgHandler{

    /*
	* Searching for Daily interest according to rules		
	*/
	public function getDailyInterest($dayNr)
	{
 		if ($dayNr % 15 === 0) return 3;
 		if ($dayNr % 5  === 0) return 2;
        if ($dayNr % 3  === 0) return 1;  
        return 4;
	}

	/*
	* Building reult query		
	*/
	public function buildQuery($sum, $days, $token)
	{

		$query= [];
		$finalInterest=0;		

		/*
		* Service performance with a large day number is too slow.
		* As interest for every 15 days is a constant, we can count number of rounds + rest
		*/

		if ($days>15)
			{
				$numberOfRounds = floor($days/15);
				$interestPerRound = $this->buildQuery($sum, 15, $token)['interest'];
				$finalInterest = $interestPerRound * $numberOfRounds;
				$rest = $days % 15;
			}
		else
			{
				$rest = $days;
			}


		for ($i=1; $i<$rest+1; $i++)
			{
				$dailyInterest =  round($sum * $this->getDailyInterest($i) / 100, 2);
				$finalInterest += $dailyInterest;
			}

		$totalSum = $sum + $finalInterest;

		$query = [ 'sum' => $sum, 'days' => $days, 'interest' => round($finalInterest, 2), 'totalSum' => round($totalSum, 2), 'token' => $token ];

		return $query;
	}

	/*
	* Terminating service		
	*/
	public function shutdown()
	{
        $this->channel->close();
        $this->link->close();
	}


}
