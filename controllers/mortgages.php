<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);	
ini_set('display_errors', '1');

/**
* No autoload or namespace for simplicity in this exercise.
*/
require_once('Controller.class.php');
require_once('../models/DbUtility.class.php');
require_once('../models/MortgageLoan.class.php');

/**
* This is the controller for mortgage loans to either
* retrieve loan_status by loan_id (lid) or create a new loan record
* by providing the loan_amount (lamt): property_value(pv):
* borrower social security number (bssn).
*
* Controller object:
* Check which POST values sent.
* Return error if data is missing to complete transaction.
*
* MortgageLoan object:
* If loan_id (lid) then retirieve the loan_status from the loan record.
* Otherwise, create a new loan record and return the loan_id.
*
* @author Chris Carillo <drcarillo@gmail.com> 2016-06-06
*/

// command line test data
//$_POST['lamt'] = 10000.00;
//$_POST['pv']   = 100000.00;
//$_POST['bssn'] = 555115555;
//$_POST['lid'] = 2;

try {
    // check POST data first: what to process
    $loan          = new Controller();
    $loan->processPostData();
    $loan_data     = $loan->getPostData();
    $storage       = new DbUtility();
    
    // use POST data: data should be good if you get this far
    if (empty($loan_data['lid'])) {
        // new loan record
        $mortgage_loan = new MortgageLoan($storage);
        
        // something went wrong
        if ($mortgage_loan->getStorageFail())
            throw new Exception("Data not available at this time: please check back.");
        
        // create new loan record
        $mortgage_loan->createLoan($loan_data);
        $loan_id = $mortgage_loan->getLoanId();
        $loan_data['loan_id'] = $loan_id;
    } else {
        // retrieve loan record
        $mortgage_loan = new MortgageLoan($storage, $loan_data['lid']);
        
        if ($mortgage_loan->getStorageFail())
            throw new Exception("Data not available at this time: please check back.");
        
        // get loan_status from record
        $loan_status              = $mortgage_loan->getLoanStatus();
        $loan_data['loan_status'] = $loan_status;
    }
    
    // success: return relevant data
    echo json_encode(array('loan_data' => $loan_data, 'success' => true));
} catch(Exception $e) {
    echo json_encode(array('error' => $e->getMessage(), 'failed' => true));
}