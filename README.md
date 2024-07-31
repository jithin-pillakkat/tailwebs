# Project set up instruction

- Extract the zipped project folder/clone the project folder to your local machine.
- Open the project folder in your code editor (IDE).
- Open the terminal and serve the port using the cmd "php spark serve"


# Database management

- Create a new database called 'tailwebs' in your database.
- Open the .env file from the root and update the DB credentials.
- Open the terminal and enter the cmd "php spark migrate" to create required tables.
- Open the terminal and enter the cmd "php spark db:seed TeacherSeeder" to store teacher details into the table.
- Open the terminal and enter the cmd "php spark db:seed StudentSeeder" to store student details into the table.

# Teacher login details

-username = teacher_1
-password = 12345678


