<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Parkside CCarillo Challenge: Mortgage Loan</title>
</head>

<body>
    <form name='new_loan' action='./controllers/mortgages.php' method='post'>
        <p>Request New Loan<br />All Fields Required:</p>
        Loan Amount:<br />
        <input type='text' name='lamt'><br />
        Property Value:<br />
        <input type='text' name='pv'><br />
        Borrower SSN:<br />
        <input type='text' name='bssn'><br />
        <input type='submit' name='submit'>
    </form>
        <br /><br />
            OR
        <br /> <br />
    <form name='loan_status' action='./controllers/mortgages.php' method='post'>
        <p>Get Loan Status:</p>
        Loan ID:<br />
        <input type='text' name='lid'><br />
        <input type='submit' name='submit2'>
    </form>
    
</body>

</html>