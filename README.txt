Setup Requirements:

1. To set up this challenge example just drop ccarillo_parkside directory/folder
into your web root or htdocs/www or relevant directory.

2. The ccarillo_parkside/models/DbUtility.class.php file db credentials
may have to be updated for your environment: db name: user: psw: etc.

3. I've included the create_loans_table.sql file if you want to dump that in
your db instead of creating the table by hand.


Overview:

Basically, I simulated an MVC environment as would a normal web service
be built within. However, I did put the view doc of this project in the
as index.php because I built this outside of a framework: works locally.

Considering the scope of this challenge I omitted:

1. JS/jquery validations and AJAX calls. So the POS returns raw JSON
because these 2 forms use a simple HTTP POST to the conroller.

2. NO CSS was added to the forms/view for the user experience.


Cheers,

Chris C.