<?php
include('php/elo.php');

$players = array(
	"Joris" => 1500,
	"Matthijs" => 1500,
	"Max" => 1500,
	"Nicolaas" => 1500,
	"Wouter" => 1500
);

function match($order) {
	global $players;
	$match = new ELOMatch();

	$ranks = [];
	for($i = 0; $i < count($order); $i++) {
		if (is_array($order[$i])) {
			foreach($order[$i] as $name) {
				$ranks[$name] = $i;
			}
		} else {
			$ranks[$order[$i]] = $i;
		}
	}

	foreach($players as $name => $elo) {
		if (in_array($name, array_keys($ranks)))
		$match->addPlayer($name, $ranks[$name], $players[$name]);
	}

	$match->calculateELOs();
	foreach($players as $name => $elo) {
		$players[$name] = $match->getELO($name);
	}
}

# ? - Seven Wonders
match(array("Matthijs", "Nicolaas", array("Wouter", "Max"), "Joris"));

# 13-02-17 - Seven Wonders
match(array("Joris", "Max", "Nicolaas", "Wouter", "Matthijs"));
match(array("Wouter", "Nicolaas", "Joris", "Max"));

arsort($players);
foreach($players as $name => $elo) {
	echo("$name => $elo\n");
}
