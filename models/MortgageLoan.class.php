<?php
error_reporting(E_ALL);	
ini_set('display_errors', '1');

/**
* No autoload or namespace for simplicity in this exercise.
*/
require_once('Loan.class.php');
require_once('DbUtility.class.php');

/**
* Create a MortgageLoan type.
* Either creating the loan and returning the loan_id
* or providing the loan_id and returning the loan_status.
*
* @author Chris Carillo <drcarillo@gmail.com> 2016-06-06
*/  
class MortgageLoan extends Loan
{
    /**
    * Class info array used instead of a bunch of elements.
    *
    * @var array $mortgageLoanInfo
    */
    public  $mortgageLoanInfo = array();
    
    /**
    * DB or storage hande for the class to use.
    *
    * @var DbUtility $storage
    */
    private $storage = null;
    
    /**
    * If the $Loan_id is including in the instantiation of the object
    * then fill the object with its data (loan_status for this exercise) from the db.
    *
    * @var integer $mortgageLoanInfo
    */
    public function __construct(DbUtility $storage, $loan_id = null)
    {
        parent::__construct();
        
        // Get a storage handle
        $this->storage = $storage;
        
        // If db (any storage) connect failed: set a flag for the controller instead of exception.
        if (!$this->storage)
            $this->mortgageLoanInfo['storage_fail'] = true;
        
        // Get the loan dat required if id supplied.
        if (!empty($loan_id) && $this->storage) {
            $this->mortgageLoanInfo['loan_id'] = $loan_id;
            $this->getLoan($this->mortgageLoanInfo['loan_id']);
        }
    }
    
    /**
    * Just get the loan_status for this exercide instead of all the loan elements' data.
    *
    * @var integer $loan_id
    */
    protected function getLoan($loan_id)
    {
        $loan_status = $this->storage->getLoanStatus($loan_id);
        if ($loan_status !== false)
            $this->mortgageLoanInfo['loan_status'] = $loan_status;
    }
    
    /**
    * Get the loan data from the controller and create the intial loan row in the storage.
    * Then set the loan_id upon successful completion of creationg new mortgage loan row.
    *
    * @var array $arr_loan_data
    */
    public function createLoan($arr_data)
    {
        // Check the loan_status only by the LTV : so there's no pending status as the db type suggests: 1 for accepted or 2 for declined.
        $loan_status = $this->setLoanStatus($arr_data['lamt'], $arr_data['pv']);
        
        $new_loan_id = $this->storage->createMortgageLoan($arr_data['lamt'], $arr_data['pv'], $arr_data['bssn'], $loan_status);
        
        // Set if everything went well: new loan row created.
        if ($new_loan_id !== false)
            $this->mortgageLoanInfo['loan_id'] = $new_loan_id;
    }
    
    /**
    * Use the LTV ratio to determine the loan status only.
    * No pending statuses etc. for this exercise.
    *
    * 1 == accepted and 2 == declined : LTV > .4
    *
    * @var double $loan_amount
    * @var double $property_value
    *
    * @return integer
    */
    protected function setLoanStatus($loan_amount, $property_value)
    {
        return (($loan_amount / $property_value) > .4 ? 2 : 1);
    }
    
    /**
	* If the db connection failed.
	* 
	* @return bool
	*/
	public function getStorageFail()
	{
	    if (!empty($this->mortgageLoanInfo['storage_fail']))
	        return true;
	    return false;
	}
    
	/**
	* Get the loan_id of a loan.
	* 
	* @return integer $mortgageLoanInfo['loan_id'] on success
	*/
	public function getLoanId()
	{
	    if (!empty($this->mortgageLoanInfo['loan_id']))
	        return $this->mortgageLoanInfo['loan_id'];
	    return false;
	}
	
	/**
	* Get the loan_status of a loan by its id (loan_id).
	* 
	* @return integer $mortgageLoanInfo['loan_status'] on success
	*/
	public function getLoanStatus()
	{
	    if (!empty($this->mortgageLoanInfo['loan_status']))
	        return $this->mortgageLoanInfo['loan_status'];
	    return false;
	}
}