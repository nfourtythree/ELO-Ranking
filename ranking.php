<?
	/**
	* Ranking
	*/
	class Ranking
	{
		var $starting_points = 1200;
		var $provisional_matches = 5;
		
		function __construct()
		{
			
		}
		
		
		function match($player1, $score1, $player2, $score2)
		{
			if (!empty($player1) AND !empty($player2))
			{
				$player1_expected = $this->expected($player1['ranking'], $player2['ranking']);
				echo $player1['name'] . ' expected score: '.$player1_expected.'<br>';
				$player2_expected = $this->expected($player2['ranking'], $player1['ranking']);
				echo $player2['name'] . ' expected score: '.$player2_expected.'<br>';
				
				if ($score1 > $score2)
				{
					echo $player1['name'] . ' beat ' . $player2['name'].'<br>';
					$player1_new_ranking = $player1['ranking'] + $this->k_factor($player1) * (1 - $player1_expected);
					$player2_new_ranking = $player2['ranking'] + $this->k_factor($player2) * (0 - $player2_expected);
				}
				else if ($score2 > $score1)
				{
					echo $player2['name'] . ' beat ' . $player1['name'].'<br>';
					$player1_new_ranking = $player1['ranking'] + $this->k_factor($player1) * (0 - $player1_expected);
					$player2_new_ranking = $player2['ranking'] + $this->k_factor($player2) * (1 - $player2_expected);
				}
				$player1_new_ranking = round($player1_new_ranking);
				$player2_new_ranking = round($player2_new_ranking);
				
					echo $player1['name'] . ' new ranking: ' . $player1_new_ranking.' [diff: ' . ($player1_new_ranking - $player1['ranking']) . ']<br>';
					echo $player2['name'] . ' new ranking: ' . $player2_new_ranking.' [diff: ' . ($player2_new_ranking - $player2['ranking']) . ']<br>';
				
				return array(
					'p1'	=>	round($player1_new_ranking), 
					'p2'	=>	round($player2_new_ranking)
					);
			}
		}
		
		function expected($pa, $pb)
		{
			$expected = 1 / (1 + pow(10, (($pb - $pa) / 400)));
			
			return $expected;
		}
		
		function k_factor($player)
		{
			// do something dependant on the player
			
			return 20;
		}
	
	}
	



	$ranking = new Ranking;
	
	$player1 = array(
		'name'		=>	'Nathaniel',
		'ranking'	=>	1527
	);
	
	$player2 = array(
		'name'		=>	'Chris',
		'ranking'	=>	1272
	);
	
	
	echo 'Match: ' . $player1['name'] . '(' . $player1['ranking'] . ') <strong>1</strong> vs 0 ' . $player2['name'] . ' (' . $player2['ranking'] . ')<br>';
	$new = $ranking->match($player1, 1, $player2, 0);
	$player1['ranking'] = $new['p1'];
	$player2['ranking'] = $new['p2'];
	echo '<br><br>';

	echo 'Match: ' . $player1['name'] . '(' . $player1['ranking'] . ') 0 vs <strong>1</strong> ' . $player2['name'] . ' (' . $player2['ranking'] . ')<br>';
	$new = $ranking->match($player1, 0, $player2, 1);
	$player1['ranking'] = $new['p1'];
	$player2['ranking'] = $new['p2'];
	
