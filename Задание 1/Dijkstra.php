<?php

class Dijkstra
{
	private $graph;
	
	public function __construct(array $graph) {
		$this->graph = $graph;
	}
	
	public function shortestPath(int $from, int $to) {
		$d = array();
		$pi = array();
		$q = new SplPriorityQueue();

		foreach ($this->graph as $v => $adj) {
			$d[$v] = INF;
			$pi[$v] = null;
			foreach ($adj as $u => $len) {
				$q->insert($u, $len);
			}
		}
		
		$d[$from] = 0;
		
		while(!$q->isEmpty()) {
			$v = $q->extract();
			if (!empty($this->graph[$v])) {
				foreach ($this->graph[$v] as $u => $len) {
					$new_len = $d[$v] + $len;
					if ($new_len < $d[$u]) {
						$d[$u] = $new_len;
						$pi[$u] = $v;
                        $q->insert($u, $new_len);
					}
				}
			}
		}
		if (!isset($d[$to]) || is_infinite($d[$to])) {
			return -1;
		} else {
			return $d[$to];
		}
	}
}