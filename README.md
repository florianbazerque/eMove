# eMove


 What's next?


  * Run your application:
    1. Change to the project directory
    2. Create your code repository with the git init command
    3. Execute the docker-compose up -d command
    4. Browse to the http://localhost:8000/ URL.


  * Read the documentation at https://symfony.com/doc


 Database Configuration


  * Modify your DATABASE_URL config in .env

  * Configure the driver (mysql) and
    server_version (5.7) in config/packages/doctrine.yaml


 How to test?


  * Write test cases in the tests/ folder
  * Run php bin/phpunit
  
  Créer la base de données 
  
   * php bin/console doctrine:migrations:migrate
