<?php
/**
* Need an abstract loan class.
* We're only creating a MortgageLoan type.
* But there are possible other loan types in reality.
*
* @author Chris Carillo <drcarillo@gmail.com> 2016-06-06
*/  
abstract class Loan
{
    public function __construct() {}
    
	/**
	* Get the id of a loan.
	* 
	* @return integer
	*/
	public abstract function getLoanId();
	
	/**
	* Get the loan_status of a loan by its id (loan_id).
	* 
	* @return integer
	*/
	public abstract function getLoanStatus();
}