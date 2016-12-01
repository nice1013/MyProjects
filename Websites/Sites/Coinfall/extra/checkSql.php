<?php 
//Including OpenSource Dns Zone Editor
include_once("classdns.php");

$domainname = "coinfall.pw";

$un = trim($_POST["name"]); //Username
$pw = trim($_POST["pw"]); //Password
$address = trim($_POST["address"]); //Address
$message = "";

/*
Created By Ed Evanosich. 

This script will check Sql database for standard username and password. 
Then proceed to enter new Data into dns
or Do nothing
*/








//-------------------------------------------------------------- 
//We use the ClassDNS.php
// -- To use Class DNS 
//Setup a new zone 			---
//$zones = new zone_records("cpaneluser", "pass", "website_to_login", "domain_of_records")

// -- Pull all records             --- 
//$DNSrecord = $zones->getrecords();

// -- To Add a record 		---
//addtxt(varName,  VarValue)
//$results = $zones->addtxt("test6",  "HelloWorld6");

// -- To Pull one record. -- Array of Address, Name, Line.
//$record = $zones->gettxt("test6", $domainname, $DNSrecord);

// -- To Delete one record. 
//$DeletionResults = $zones->deleterecord($record["line"]);
//----------------------------------------------------------------------------
				
				
//$zones = new zone_records("cpaneluser", "pass", "website_to_login", "domain_of_records")
$zones = new zone_records("coinfzgk", "p-sBaGKQ?GXfR", "coinfall.pw", "coinfall.pw");


//Database
$cfdb = new mysqli("127.0.0.1", "coinfzgk_user", "cfis4life4now55668988", "coinfzgk_txtrecords");
//$cfdb = new mysqli("localhost", "coinfzgk_user", "qht6!344g#ges", "coinfzgk_txtrecords");

//Convert Username to uppercase 
$un = strtolower($un);


//Check for password and user
$checkforpw = "SELECT * FROM info where lower(UN) = '$un'";


//Commit Query
$createaquery = $cfdb->query($checkforpw);



//Check to see if query ran successfully
if (!($createaquery == false))
{
	//Query was succerful!!!!
	
	//Change results into an array.
	$returnResults = mysqli_fetch_array($createaquery, MYSQLI_ASSOC);
	
	
	
	//Check to see if the value is not null -- If null, The user does not exist, yet.  
	if (!($returnResults == NULL))
		{
			
			// If here, User exist, Does incoming pw match  $returnResults["UP"]
			if($returnResults["UP"] !== $pw) {
				
				//If here, the password was incorrect. Put this in the message. 
				$message = "Username or Password is incorrect.";
				//Exit to index with message. 
				leave($message);
			
			
			}
			else
			{			
				//Password was a match. Check to see, if the user has entered a different address.
				
				if($returnResults["UA"] !== $address)
				{
					//Addresses did NOT match. We must change it within DNS zone records.
					
					//Get current records.
					$DNSrecord = $zones->getrecords();
					
					//Get this record.
					$record = $zones->gettxt($un, $domainname, $DNSrecord);
					
					
					//Delete old record. 
					$DeletionResults = $zones->deleterecord($record["line"]);
					
					//Add new record to Dns zone editor. 
					$results = $zones->addtxt($un,  $address);
					
					//Add new record to SQL database. 
					$queryStatementForNewAddress = 'UPDATE info SET UA = "' . $address . '" WHERE UN = "' . $un . '"';
					//Commit Query
					$NewAddressQueryResults = $cfdb->query($queryStatementForNewAddress);
					
					
					//Check if query was unsuccessful. 
					if ($NewAddressQueryResults == false)
					{
						//If here, query was unsuccesful. Leave with message. 
						$message = "Uh-oh. Something is not right. Check Flux Capacitor. ";
						leave($message);
						
					}
					else 
					{
					//Send back a success message.
					$message = 'Updated!!! Use "' . $un . '.' . $domainname . '" for the address :' . $address;
					leave($message);
					}
					
				}
				else
				{
				//Address is the same. Just reshow the results to the user.	
				$message = 'Already set up!!! Use"' . $un . '.' . $domainname . '" for the address :' . $address;
				leave($message);
					
				}
				
				
			}
			
			
			
			
		} // End if for : ($returnResults == NULL) -- Does user exist? 
		else 
		{
			//User does not exist, yet.
			//Creating query for  Username, Address, and Password. 
			$adduserquery = "INSERT INTO info (UN , UP , UA) values ('$un', '$pw', '$address')  ";
			//Commit Query -- Create a new entry for user. Username, Address, and Password. 
			$committingquery = $cfdb->query($adduserquery);
			
			//Check if query (inserting username, address, and password) was successful
			if($committingquery == NULL)
			{
				//Query was not successful.
				$message = "Sorry... Something went wrong. error: A1";
				
				
			}
			else
			{
				//Query was successful. 
				//edit DNS zone to reflect DATABASE
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				//---Pull a record.
				$DNSrecord = $zones->getrecords();
				
				//Adding a TXT record to the DNS zone.
				$AddDnsZoneResults = $zones->addtxt($un,  $address);
				
				
				$message = 'Success! You can now use "' . $un . '.' . $domainname . '" for the address :' . $address;
				
			}
			
			
			
			
		}// End Else if for : ($returnResults == NULL) -- Does user exist? 
	
	
}//End if for : if (!$createaquery == false)












//Close Mysql server - We are done here. 
mysqli_close($cfdb);



leave($message);


function leave($message) {
	
	$url = "../index.php?message=";
	$newURL = $url . $message;
	header( 'Location: ' . $newURL );

	
}


?>