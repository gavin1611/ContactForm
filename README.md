

This project uses slim micro framework for quick routing libraries. And building a scalable application in a short time period of a day.



### Steps to run this project 



- Please download Apache, PHP and MySQL(optional) if database is needed.

- Set up MySQL Workbench or use CLI.

- Place this project in the web server depending if ubuntu var/www/html and run index.html. Index.html is a login form which allows to submit request to PHP server script. The data will be post to airtable, insert into MySQL. Mailgun is used to send mail.



### Create table contact_info MySQL

```sh

select * from conta CREATE TABLE contact_info ( questionId int(11) NOT NULL AUTO_INCREMENT, question varchar(100) DEFAULT NULL, description varchar(100) DEFAULT NULL, create_ts datetime DEFAULT NULL, PRIMARY KEY (questionId) ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=big5;

```

*Add the connection strings in 'dbConnection' for your respectve db and table.



### Achievements of this project

- The form uses index.html to render to the specified function to post the required data to the server.

- Appropriate validate header,cleanInputs to prevent SQL injection have been craeted.

- Accounts have been created with Mailgun and Airtable.

- Once the form is submitted, the question will be emailed to address gavinandre2007@gmail.com(Customer Support Team).

- Each of the attributes is encoded in a JSON Object to send to backend. The JSON format data is decoded on the server in function contact_info. The details are interpreted into the respective functions and SQL statement.



The code has been formatted and comments at appropriate places to ensure smooth understanding of the code.



All the tasks in ContactForm have been completed.



I will be happy to provide design and doubt clarifiation with regard to this assignment.





































   