<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);	
ini_set('display_errors', '1');

/**
* This is a class for a controller to sort through the POST data.
* We're not making a base class for simplicity in this exercise.
*
* @author Chris Carillo <drcarillo@gmail.com> 2016-06-06
*/

class Controller
{
    /**
    * A generic error message if POST values not recieved.
    *
    * @var string $err_msg
    */
    public $err_msg = 'A loan id (lid) or loan amount (lamt) -> property value (pv) -> borrower ssn (bssn) data required.';
    
    /**
    * Class elements' array.
    *
    * @var array $controllerInfo
    */
    public $controllerInfo = array();

    /**
    * Test the POST data array to move forward or not.
    * Presume we've validated the data for this exercise.
    * If any required data is missing: throw an exception.
    *
    * If there's a loan_id (lid) then we're returning th loan_status.
    * Otherwise, we're creating a new loan record and the three data
    * points required must be received: loan_amount (lamt): property_value(pv):
    * borrower social security number (bssn).
    *
    * @return array on success
    *
    * @throws Exception
    */
    public function processPostData()
    {
        // check which values are set
        if (empty($_POST['lid'])) {
            if (empty($_POST['lamt']))
                throw new Exception("$err_msg");
            if (empty($_POST['pv']))
                throw new Exception("$err_msg");
            if (empty($_POST['bssn']))
                throw new Exception("$err_msg");
            // If all good then set the values to return
            $this->controllerInfo['lamt'] = doubleval($_POST['lamt']);
            $this->controllerInfo['pv']   = doubleval($_POST['pv']);
            $this->controllerInfo['bssn'] = intval($_POST['bssn']);
        } else {
            $this->controllerInfo['lid'] = intval($_POST['lid']);
        }
    }
    
    /**
	* Return the POST data: should be good to get this far.
	* 
	* @return array $controllerInfo
	*/
	public function getPostData()
	{
	    return $this->controllerInfo;
	}
}