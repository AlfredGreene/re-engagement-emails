<?php

namespace Joelvardy;

/**
 * Target library
 *
 * @author	Joel Vardy <info@joelvardy.com>
 */
class Targets {


	private static $mysqli;


	/**
	 * Return MySQLi instance
	 *
	 * This feels dirty, I would much rather use: https://github.com/joelvardy/database
	 *
	 * @return	mysqli instance
	 */
	public static function mysqli() {

		if (self::$mysqli == null) {
			self::$mysqli = require('./database.php');
		}

		return self::$mysqli;

	}


	/**
	 * Create a new target
	 *
	 * @param	string [$email] The email of the new target
	 * @return	boolean Whether the adding the target was successful
	 */
	public function create($email) {

		$stmt = self::mysqli()->prepare('insert into `targets` (id, added, ip, email) values (0, ?, ?, ?)');
		$stmt->bind_param('iss', $_SERVER['REQUEST_TIME'], $_SERVER['REMOTE_ADDR'], $email);
		$status = (boolean) $stmt->execute();
		$stmt->close();
		return $status;

	}


	/**
	 * Read targets
	 *
	 * @param	integer [$grace] The number of seconds grace a target should have from being added until they are returned by this method. Default, 1 hour
	 * @return	array An array of targets (each being an object)
	 */
	public function read($grace = 3600) {

		$targets = array();
		$before = ($_SERVER['REQUEST_TIME'] - (60 * 60));
		$stmt = self::mysqli()->prepare('select id, added, ip, email from `targets` where added < ?');
		$stmt->bind_param('i', $before);
		$stmt->execute();
		$stmt->bind_result($id, $added, $ip, $email);
		while($stmt->fetch()) {
			$targets[$id] = (object) array(
				'added' => $added,
				'ip' => $ip,
				'email' => $email
			);
		}
		$stmt->close();
		return $targets;

	}


	/**
	 * Delete a target
	 *
	 * @param	string [$email] The email of the target to delete
	 * @return	boolean Whether deleting the target was successful
	 */
	public function delete($email) {

		$stmt = self::mysqli()->prepare('delete from `targets` where email = ?');
		$stmt->bind_param('s', $email);
		$status = (boolean) $stmt->execute();
		$stmt->close();
		return $status;

	}

}
