<?php
session_start();
include_once("config-home.php");

//empty cart by distroying current session
if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
{
	$return_url = base64_decode($_GET["return_url"]); //return url
	session_destroy();
	header('Location:'.$return_url);
}

//add item in shopping cart
if(isset($_POST["buy_submit"]))
{
	$id 	= filter_var($_POST["product_code"], FILTER_SANITIZE_STRING); //product code
	$quantity 	= filter_var($_POST["product_qty"], FILTER_SANITIZE_NUMBER_INT); //product code
	$return_url 	= base64_decode($_POST["return_url"]); //return url
	$sale = $_POST["sale"]; //return %sale
	
	
	//MySqli query - get details of item from db using product code
	$results = $mysqli->query("SELECT name,price,sale FROM cd_show WHERE id='$id' LIMIT 1");
	
	if ($results) { //we have the product info 
		$obj = $results->fetch_object();
		//prepare array for the session variable
		$new_product = array(array('name'=>$obj->name, 'id'=>$id, 'quantity'=>$quantity, 'price'=>(($obj->price * (100 - $obj->sale))/100), 'sale'=>$sale));
		
		if(isset($_SESSION["products"])) //if we have the session
		{
			$found = false; //set found item to false
			
			foreach ($_SESSION["products"] as $cart_item) //loop through session array
			{
				if($cart_item["id"] == $id){ //the item exist in array

					$product[] = array('name'=>$cart_item["name"], 'id'=>$cart_item["id"], 'quantity'=>$quantity, 'price'=>$cart_item["price"], 'sale'=>$cart_item["sale"]);
					$found = true;
				}else{
					//item doesn't exist in the list, just retrive old info and prepare array for session var
					$product[] = array('name'=>$cart_item["name"], 'id'=>$cart_item["id"], 'quantity'=>$cart_item["quantity"], 'price'=>$cart_item["price"], 'sale'=>$cart_item["sale"]);
				}
			}
			
			if($found == false) //we didn't find item in array
			{
				//add new user item in array
				$_SESSION["products"] = array_merge($product, $new_product);
			}else{
				//found user item in array list, and increased the quantity
				$_SESSION["products"] = $product;
			}
			
		}else{
			//create a new session var if does not exist
			$_SESSION["products"] = $new_product;
		}
		
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}

//remove item from shopping cart
if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["products"]))
{
	$id 	= $_GET["removep"]; //get the product code to remove
	$return_url 	= base64_decode($_GET["return_url"]); //get return url

	
	foreach ($_SESSION["products"] as $cart_item) //loop through session array var
	{
		if($cart_item["id"]!=$id){ //item does,t exist in the list
			$product[] = array('name'=>$cart_item["name"], 'id'=>$cart_item["id"], 'quantity'=>$cart_item["quantity"], 'price'=>$cart_item["price"], 'sale'=>$cart_item["sale"]);
		}
		
		//create a new product list for cart
		$_SESSION["products"] = $product;
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}
?>