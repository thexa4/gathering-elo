<?php
include('php/elo.php');

$players = array(
	"Joris" => 1500,
	"Matthijs" => 1500,
	"Max" => 1500,
	"Nicolaas" => 1500,
	"Wouter" => 1500
);

function match($game, $order) {
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
# match with array from highest to lowest
# ? - Seven Wonders
match("Seven Wonders", array("Matthijs", "Nicolaas", array("Wouter", "Max"), "Joris"));

# 13-02-17 - Seven Wonders
match("Seven Wonders", array("Joris", "Max", "Nicolaas", "Wouter", "Matthijs"));
match("Seven Wonders", array("Wouter", "Nicolaas", "Joris", "Max"));

# 30-05-17 - Sonar
match("Sonar", array(array("Nicolaas", "Joris"), array("Max", "Wouter")));

# 05-05-17 - Sonar
match("Sonar", array(array("Max", "Matthijs", "Joris"), array("Nicolaas", "Wouter")));
match("Sonar", array(array("Nicolaas", "Wouter"), array("Max", "Matthijs", "Joris")));

# 12/06/17 - Love letter
match("Love Letter", array("Max", array("Joris", "Matthijs"), "Nicolaas", "Wouter"));

# 19-06-17 - Sonar
match("Sonar", array(array("Max", "Matthijs"), array("Nicolaas", "Wouter", "Joris")));
match("Sonar", array(array("Nicolaas", "Wouter", "Joris"), array("Max", "Matthijs")));

#?
match("Caverna", array("Matthijs", "Nicolaas", "Wouter", "Max", "Joris"));

# 30 oct
match("Calimala", array("Max", "Matthijs", "Joris", "Wouter", "Nicolaas"));

# 07-11-17 Evolution: Climate
match("Evolution", array("Wouter", array("Joris", "Nicolaas")));

# 28-11-17 Evolution: Climate
match("Evolution", array("Max", "Matthijs", "Wouter", "Nicolaas", "Joris"));

arsort($players);
foreach($players as $name => $elo) {
	echo("$name => $elo\n");
}
