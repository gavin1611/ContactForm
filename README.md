This project uses slim micro framework for quick routing libraries. And building a scalable application in the short time period of a day.

To run this project please download Apache, PHP and MySQL(optional) if database is needed.

After successful download and install. Place this project in the web server depending if ubuntu
var/www/html and run the index.html which is a login form which submits request to PHP server script which posts to airtable, sends mail using mailgun and inserts into MySQL.

Set up MySQL Workbench or use CLI.

//Create table contact_info MySQL

select * from contaCREATE TABLE `contact_info` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `create_ts` datetime DEFAULT NULL,
  PRIMARY KEY (`questionId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=big5;


Create the following table and add the connection strings in 'dbConnection' for your respectve db and table.

The form uses index.html to render to the specified function to post the required data to the server.

Appropriate validate header,cleanInputs to prevent SQL injection have been craeted.

Accounts have been created with Mailgun and Airtable. 

Email address gavinandre2007@gmail.com(Customer Support Team)
On form submit each of the attributes is send the backend encode in a JSON Object
which is then decoded on the server in function contact_info
The details are interpreted into the respective functions and SQL statement.



The code has been formatted and comments at appropriate places to ensure smooth understanding of the code.

All the tasks in ContactForm have been completed.

I will be happy to provide design and doubt clarifiation with regard to this assignment.

