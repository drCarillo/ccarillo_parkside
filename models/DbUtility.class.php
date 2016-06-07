<?php
error_reporting(E_ALL);	
ini_set('display_errors', '1');

/**
* PDO database credentials for local dev environment: no config file for this exercise
*/
const DBHOST = '127.0.0.1';
const DBUSER = 'root';
const DBPASS = 'root';
const DB     = 'ccarillo_parkside';

/**
* This class creates a simple usable database handle
* for the purpose of this exercise.
*									 
* @author Chris Carillo <drcarillo@gmail.com> 2016-06-06
*/
class DbUtility
{
    /**
    * PDO database object handle.
    * @var PDO $pdo
    */
    private $pdo = null;

    /**
	* Create a db connect handle to process data requests.
	*/
	public function __construct()
	{
		$this->pdo = new PDO("mysql:host=127.0.0.1;dbname=ccarillo_parkside", DBUSER, DBPASS, array(PDO::ATTR_EMULATE_PREPARES => false));
		// try
		if (!$this->pdo) {
			error_log(json_encode(array('ERROR' => 'pdo_connect', 'errno: ' => $this->pdo->errorCode(), 'errmsg: ' => $this->pdo->errorInfo())));
		}
		
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	/**
	* Add a new mortgage type 1 (only current type) loan record with requisite data.
	*
	* @param double $loan_amount : probably need a math class object to use integers as cents
	* @param double $property_value
	* @param integer $borrower_ssn
	* @param integer $loan_status
	*
	* @return integer $loan_id on success
	*/
	public function createMortgageLoan($loan_amount, $property_value, $borrower_ssn, $loan_status, $loan_type = 1, $active = 1)
	{
		// prepare
		$id 	= null;
		$sql 	= "INSERT INTO loans (loan_type, borrower_ssn, property_value, loan_amount, loan_status, loan_application_date, active) VALUES (:lt, :bs, :pv, :la, :ls, NOW(), :a)";
		$query  = $this->pdo->prepare($sql);
		//execute prepared statement : no sql injection
		$query->execute(array(':lt' => $loan_type, ':bs' => $borrower_ssn, ':pv' => $property_value, ':la' => $loan_amount, ':ls' => $loan_status, ':a'=> $active));
		
		// check
		if ($query) {
		    return $loan_id = $this->pdo->lastInsertId();
		} else {
			// something went wrong : db error
			error_log(json_encode(array('ERROR' => 'createMortgageLoan()', 'errno: ' . $this->pdo->errorCode() . ' , errmsg: ' . $this->pdo->errorInfo())));
			return false;
		}
	}
	
	/**
	* Get the loan status of a loan by its id.
	*
	* @param integer $loan_id
	*
	* @return integer $loan_status on success
	*/
	public function getLoanStatus($loan_id)
	{
		// declare
        $row  	= null;
		$sql 	= "SELECT loan_status FROM loans WHERE loan_id = :lid";
		$query  = $this->pdo->prepare($sql);
		
		//execute
		$query->execute(array(':lid' => $loan_id));
		
		// something went wrong : db error?
		if (!$query) {
			error_log(json_encode(array('ERROR' => 'getLoanStatus()', 'errno: ' . $this->pdo->errorCode() . ' , errmsg: ' . $this->pdo->errorInfo())));
			return false;
		}
		
		// check
		if ($query->rowCount() <= 0) return false;  // empty array dictates no matching row : ?
		
		// return loan status
		$row = $query->fetch();
		return $loan_status = $row['loan_status'];
	}
}