<!DOCTYPE html>
<!--	Author: Anthony Storti
		Date:	OCtober 31, 2019
		Purpose:Generate SQL script to populate database with values
-->
<html>
<head>
	<title>Rental Data</title>
	<link rel ="stylesheet" type="text/css" href="sample.css">
</head>

<body>
	<form>
		<button type="" formaction="tasks.html">return</button>

	<?php

       $mysqli = new mysqli("localhost", "root", "Dovetail1", "sakila");
        if($mysqli->connect_error) {
          exit('Error connecting to database');
        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli->set_charset("utf8mb4");
        //The ? below is a placeholder
        $stmt = $mysqli->prepare("SELECT first_name, last_name, title, r.inventory_id
        AS iId, rental_date, return_date FROM customer c, rental r, inventory i, film f
        WHERE c.customer_id = r.customer_id AND r.inventory_id = i.inventory_id AND i.film_id = f.film_id
        ORDER BY last_name;");


        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) exit('No rows');

        print("<h1 align = 'center'>Table of Rentals</h1>");
        print("<table align = 'center' border='1'>");
        print("<tr><th>First Name</th><th>Last Name</th><th>Title</th>
        <th>Inventory ID</th><th>Checkout Date</th><th>Return Date</th></tr>");

        $i = 0;
        while($row = $result->fetch_assoc()) {
					print ("<tr><td align = 'center'>".$row['first_name']."</td><td align = 'center'>".$row['last_name']."</td>
          <td align = 'center'>".$row['title']."</td><td align = 'center'>".$row['iId'].
          "</td><td align = 'center'>".$row['rental_date']."</td><td align = 'center'>".$row['return_date']."</td></tr>");
          $i++;
        }

        $stmt->close();

        $mysqli->close();
        ?>
			</form>
      </body>
      </html>
