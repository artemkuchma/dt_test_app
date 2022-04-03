<h2>Test Post API</h2>
<h3>Short description</h3>
<p>API has GRUD functionality for working with posts and for working with comments on these posts. It is also possible to set upvotes, which are reset once a day</p>

<h3>Usage</h3>

<h4>   <a href="https://go.postman.co/workspace/My-Workspace~465bcfc7-49c9-4234-8e0e-357bb884dd99/collection/20282495-094595b7-0cf7-436d-8d5e-6700e5c75ef6?action=share&creator=20282495
">Link to Postman Documentation</a></h4>

<h4> <a href="https://ancient-ravine-75199.herokuapp.com/" >Demo version</a> </h4>


<h3>Installation</h3>
<p> 1) Download repository.</p>

   <p>2) run the install via composer</p>
   <code>composer instal</code>

   <p>3) Create a database</p>

   <p>4) Open the .env.example file and write the name of the database and user</p>

   <code>DB_CONNECTION=mysql
         DB_HOST=127.0.0.1
         DB_PORT=3306
         DB_DATABASE=laravel
         DB_USERNAME=root
         DB_PASSWORD=
    </code>

   <p> 5) Rename file .env.example to .env</p>
   <p> 6) Run in the console (located in the project folder) the migration of database tables with the following command:</p>
   <code>php artisan migrate</code>

   <h3>Docker</h3>

   <p> The ability to deploy as a docker container </p>

   <p> 1) rename .env.docker to .env</p>

      <p>2) run commands</p>
      <code>docker-compose build app</code>
       <code>docker-compose up -d</code>
        <code>docker-compose exec app composer install</code>
        <code>docker-compose exec app php artisan key:generate</code>
       <p>The application will be available at: http://localhost:8000/api/posts</p>