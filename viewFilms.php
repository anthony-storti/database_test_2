<!DOCTYPE html>
<!--	Author: Anthony Storti
		Date:	OCtober 31, 2019
		Purpose:Generate SQL script to populate database with values
-->
<html>
<head>
	<title>Film Data</title>
	<link rel ="stylesheet" type="text/css" href="sample.css">
</head>

<body>
	<form>
		<button type="submit" formaction="tasks.html">return</button>

  <?php

       $mysqli = new mysqli("localhost", "root", "Dovetail1", "sakila");
        if($mysqli->connect_error) {
          exit('Error connecting to database');
        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli->set_charset("utf8mb4");

        $stmt = $mysqli->prepare("SELECT title, description,rental_duration, rental_rate, length, c.name AS category,
        (SELECT count(i.inventory_id) FROM inventory i WHERE i.film_id = f.film_id) AS filmCount
        FROM film f, category c, film_category fc WHERE f.film_id = fc.film_id AND fc.category_id = c.category_id ORDER BY title; ");


        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) exit('No rows');

        print("<h1 align = 'center'>Table of Films</h1>");
        print("<table border='1'>");
        print("<tr><th>TITLE</th><th>DESCRIPTION</th><th>RENTAL DURATION</th>
        <th>RENTAL RATE</th><th>LENGTH</th><th>CATEGORY</th><th>INVENTORY</th></tr>");

        $i = 0;
        while($row = $result->fetch_assoc()) {
      		print ("<tr><td align = 'center'>".$row['title']."</td><td align = 'center'>".$row['description']."</td>
          <td align = 'center'>".$row['rental_duration']."</td><td align = 'center'>".$row['rental_rate'].
          "</td><td align = 'center'>".$row['length']."</td><td align = 'center'>".$row['category']."</td>
          <td align = 'center'>".$row['filmCount']."</td></tr>");
          $i++;
        }

        $stmt->close();

        $mysqli->close();
        ?>
			</form>
      </body>
      </html>
