<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Eshop</title>
</head>

<body>
	<div class="navbar">
		<a href="http://chatzisid.webpages.auth.gr" class="title">My Eshop</a>
	</div>
		
	<div class="eshop-container">
		
	<div class="eshop-container">
		<div class="filters">
			<div class="company">
				<h1>Company</h1>
				<input type="checkbox" name="samsung" value="samsung" onchange="docheckbox(this)">Samsung<br>
				<input type="checkbox" name="apple" value="apple" onchange="docheckbox(this)">Apple<br>
				<input type="checkbox" name="huawei" value="huawei" onchange="docheckbox(this)">Huawei<br>
				<input type="checkbox" name="xiaomi" value="xiaomi" onchange="docheckbox(this)">Xiaomi<br>
			</div>
			<div class="price">
				<h1>Price(€)</h1>
				<input type="checkbox" name="100299" value="100" onchange="docheckbox(this)">100-299<br>
				<input type="checkbox" name="300499" value="300" onchange="docheckbox(this)">300-499<br>
				<input type="checkbox" name="500799" value="500" onchange="docheckbox(this)">500-799<br>
				<input type="checkbox" name="8002000" value="800" onchange="docheckbox(this)">800+<br>
			</div>
			<div class="ram">
				<h1>Ram</h1>
				<input type="checkbox" name="2GB" value="2" onchange="docheckbox(this)">2GB<br>
				<input type="checkbox" name="4GB" value="4" onchange="docheckbox(this)">4GB<br>
				<input type="checkbox" name="6GB" value="6" onchange="docheckbox(this)">6GB<br>
				<input type="checkbox" name="8GB" value="8" onchange="docheckbox(this)">8GB<br>
			</div>
			<div class="screen">
				<h1>Screen Size</h1>
				<input type="checkbox" name="4.04.9" value="4.0" onchange="docheckbox(this)">4"-4.9"<br>
				<input type="checkbox" name="5.05.9" value="5.0" onchange="docheckbox(this)">5"-5.9"<br>
				<input type="checkbox" name="6.06.9" value="6.0" onchange="docheckbox(this)">6"-6.9"<br>
			</div>
		</div>
		
		<?php
		
				
		
			$link = @mysqli_connect("webpagesdb.it.auth.gr","BloodyFeeder","12345", "smartphones");

			if (!$link) {
				echo '<p>Database error <br>';  
				echo 'Error code: ' . mysqli_connect_errno() . '<br>'; 
				echo 'The error was: ' . mysqli_connect_error() . '<br>'; 
				echo 'Please try again.</p>';
				exit(); 
			}
			
			$name = "";
			if (isset($_POST["phone"]))
				$name = $_POST["phone"];
			if (strcmp($name,'')!=0)
			{
				$comment = $_POST["rating"].$_POST["comment"];
				$findquery = 'SELECT * FROM smartphones WHERE name="'.$name.'"';
				$findresult = mysqli_query($link, $findquery);
				$row = mysqli_fetch_assoc($findresult);
				$comments = $row['comments'];
				$comments = $comments . '±' . $comment;
				$updatequery = 'UPDATE smartphones SET comments = "'.$comments.'" WHERE name="'.$name.'"';
				mysqli_query($link, $updatequery);
			}
			
			$query = 'SELECT * FROM smartphones';
			
			$company = "";
			if (isset($_GET["company"]))
				$company = $_GET["company"];
			$price = "";
			if (isset($_GET["price"]))
				$price = $_GET["price"];
			$ram = "";
			if (isset($_GET["ram"]))
				$ram = $_GET["ram"];
			$screen = "";
			if (isset($_GET["screen"]))
				$screen = $_GET["screen"];
			if (strcmp($company,'')!=0 || strcmp($price,'')!=0 || strcmp($ram,'')!=0 || strcmp($screen,'')!=0)
			{
				$query = $query . ' WHERE ';
			}
			
			if (strcmp($company,'')!=0)
			{
				$query = $query . $company . ' ';	
				if (strcmp($price,'')!=0 || strcmp($ram,'')!=0 || strcmp($screen,'')!=0)
					$query = $query . ' AND ';
			}
			
			if (strcmp($price,'')!=0)
			{
				$query = $query . $price . ' ';	
				if (strcmp($ram,'')!=0 || strcmp($screen,'')!=0)
					$query = $query . ' AND ';
			}
			
			if (strcmp($ram,'')!=0)
			{
				$query = $query . $ram . ' ';	
				if (strcmp($screen,'')!=0)
					$query = $query . ' AND ';
			}
			
			if (strcmp($screen,'')!=0)
			{
				$query = $query . $screen . ' ';	
			}
			
			$page = 1;
			if (isset($_GET['page']))
				$page = $_GET['page'];
		
			$offset = ($page - 1)*5;
			$query2 = $query . ' LIMIT '.$offset.', 5';
			
			$result = mysqli_query($link, $query2);
			
			echo '<div id="product-list">';
			
			for ($i=0; $i<mysqli_num_rows($result); $i++) {
				
				$row = mysqli_fetch_assoc($result);
				
				$comments = strtok($row['comments'], "±");
				
				echo 	'<div class="product-info product-card">
							<div class="card-start">
								<img class="product-image" src="'. "images/" . $row["name"].'.jpg">
								<p><button class="add-button" onclick="addtocart(\''.$row["name"].'\',\''.$row["price"].'\')">ADD TO CART</button></p>
							</div>
							<div class="card-center">
								<label class="product-name">'.$row["name"].'</label>
								<div class="product-price">'.$row["price"].'€</div>
								<div>
									<ul>
										<li>Company: '.$row["company"].'</li>
										<li>Colour: '.$row["colour"].'</li>
										<li>Screen:  '.$row["screen"].'"</li>
										<li>Ram:  '.$row["ram"].'GB</li>
									</ul>
								</div>
							</div>
							<div class="card-end">';
				if ( $comments !== false)
					echo 	'<div class="ratings">';
				else 
					echo	'<div>';			
								while ($comments !== false)
								{
									echo '<p><b>'.substr($comments,0,1).' </b>';
									echo substr($comments,1).'</p>';
									$comments = strtok("±");
								}
									
				echo			'</div>
								<form method="post" id="submit-rating">
									<input type="hidden" name="phone" value="'.$row["name"].'">
									<label >Review: </label>
									<input type="text" name="comment" class="comment-input">
									<label >Rating: 1</label>
									<input type="range" name="rating" min="1" max="5" step="1" value="3">
									<label >5 </label>
									<input type="submit" value="Post your review..">
								</form>
							</div>
						</div>';
			}
				
			echo '</div>';
			
			echo '<div id="cart">
					<div id="cart-head"><h2>Shopping Cart</h2></div>';
								
			$total = 0;
			foreach ($_COOKIE as $key=>$val)
			{
				$key = trim($key);
				$val = trim($val);
				
				$keyTokens = strtok($key, "|");
				$nameToken = $keyTokens;
				$priceToken = strtok("|");
				if (strcmp(substr($nameToken,0,1),"#")==0)
				{	
					$total = $total + ($priceToken * $val);
					$nameToken = substr($nameToken,1);
					echo '<div class="cart-item"><h3>'.$nameToken.' x'.$val.'</h3>
							<button class="x-button" onclick="removefromcart(\''.$nameToken.'\',\''.$priceToken.'\',\''.$val.'\')">-</button>
							<h4>'.$priceToken.'€</h4></div>';
				}
			}
			
			echo '<div><h3>Total: '.$total.'€</h3>
						<div id="purchase-div"><button id="purchase-button">PURCHASE</button></div>
				  </div>';
			
			echo '</div>';	
			
		echo '</div>';
		
		$tempResult = mysqli_query($link, $query);
		$pages = ceil(mysqli_num_rows($tempResult)/5);
		if ($pages>1)
		{
			echo '<div class="next-pages">';
			for ($i=1; $i<=$pages;$i++)
			{	
				if ($i == $page)
					echo '<b class="link">'.$i.'</b>';
				else
					echo '<a class="link" href="">'.$i.'</a>';
				
			}
			echo '</div>';
		}
		mysqli_close($link);
		?>
	<script src="index.js"></script>
	
</body>




</html>
