# ERP_SYSTEM-Assignment for software interns (Full stack developer)
Design ERP system using PHP and MySQL to insert, update, delete and search  system data.


  Assumptions
  
This project assumes that you have a local development environment set up with PHP, MySQL, and a web server (e.g., Apache or Nginx) already installed and configured.

The project utilizes Bootstrap for front-end styling and JavaScript for form validation.

The database schema and sample data are provided in the assignment.sql file, which should be imported into your MySQL database before running the project.

How to Setup the Project

Clone the Repository: Clone this repository to your local machine using Git.
bash
Copy code
git clone <repository_url>
Import Database: Open phpMyAdmin or any MySQL management tool and import the assignment.sql file to create the necessary database tables and sample data.

Move Files to Web Server Directory: Move the entire project folder to your web server's directory. For example, if you are using XAMPP, place it inside the htdocs folder.

Start the Web Server: Start your web server (e.g., Apache) and MySQL server.

Access the Project: Open your web browser and access the project by entering the URL corresponding to your web server and the project directory. For example, if you placed the project folder in htdocs and your local server address is http://localhost, you can access the project at http://localhost/your_project_folder.

Project Structure
The project consists of three main PHP files: customer.php, item.php, and report.php, representing each of the three tasks.
The CSS styles are included within the HTML files using Bootstrap classes, and custom CSS styles are added within the <style> tags.
The JavaScript for form validation is included directly within the HTML files using <script> tags.
Project Functionality

Customer Management (customer.php):

Store/Register Customer data with form validation.
The form includes fields for Title, First Name, Last Name, Contact Number, and District.
You can Add new customers and Update existing customer records.
You can also Delete customer records from the database.
The customer list is displayed in a table format.

Item Management (item.php):

Store/Register Item details with form validation.
The form includes fields for Item Code, Item Name, Item Category, Item Subcategory, Quantity, and Unit Price.
You can Add new items and Update existing item records.
You can also Delete item records from the database.
The item list is displayed in a table format.

Reports (report.php):

Invoice Report: Allows selecting a date range to search for invoices. The report includes Invoice Number, Date, Customer, Customer District, Item Count, and Invoice Amount.
Invoice Item Report: Allows selecting a date range to search for invoice items. The report includes Invoice Number, Invoiced Date, Customer Name, Item Name with Item Code, Item Category, and Item Unit Price.
Item Report: Displays the unique Item Names along with their Item Category, Item Subcategory, and Item Quantity.


Conclusion

The above instructions provide an overview of the project and how to set it up in a local environment. If you encounter any issues during setup or while running the project, please refer to the assumptions made and ensure that your local environment meets the requirements. Additionally, feel free to explore and modify the project to suit your specific needs. Happy coding!
