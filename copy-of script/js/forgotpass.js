function forgotpass_valid()
{
	if(document.getElementById('email').value=='')
	{
		document.getElementById('errbox2').innerHTML='Please provide valid email id';
		document.getElementById('email').focus();
		return false;	
	}
	if(document.getElementById('email').value!="")
	{
		if (echeck(document.getElementById('email').value)==false)
		{
			document.getElementById('email').value="";
			return false;
		}
		else
		{
			myemailajax(document.getElementById('email').value);
		}
	}
	return true;
}
function echeck(str)
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at);//search position of @
	var lstr=str.length;//length of the emil id
	var ldot=str.indexOf(dot)

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr+1)//search as array if @ not exist||search if @ at first position||search if @ at the previous last position
	{
		document.getElementById('errbox2').innerHTML='Invalid email id';
		document.getElementById('email').focus();
		return false;
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr+1)//search as array if ( . ) not exist||search if ( . ) at first position||search if ( . ) at the previous last position
	{
		document.getElementById('errbox2').innerHTML='Invalid email id';
		document.getElementById('email').focus();
		return false;
	}

	 if (str.indexOf(at,(lat+1))!=-1)//"at" the search string item & "lat+1" is the starting point for searching i.e "@" occurs more than once
	 {
		document.getElementById('errbox2').innerHTML='Invalid email id';
		document.getElementById('email').focus();
		return false;
	 }

	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot)/* if ( . ) beforre @||if  ( . ) at 2 nd position after @ i.e ".@"||"@."
The substring() method extracts the characters from a string, between two specified indices, and returns the new sub string.

This method extracts the characters in a string between "from" and "to", not including "to" itself.
Syntax
string.substring(from, to)
*/
	 {
		document.getElementById('errbox2').innerHTML='Invalid email id';
		document.getElementById('email').focus();
		return false;
		
	 }

	 if (str.indexOf(dot,(lat+3))==-1)//id "." not present after 3 chr from "@"
	 {
		document.getElementById('errbox2').innerHTML='Invalid email id';
		document.getElementById('email').focus();
		return false;
	 }
	
	 if (str.indexOf(" ")!=-1)//if space is present in mailid
	 {;
		document.getElementById('errbox2').innerHTML='Invalid email id';
		document.getElementById('email').focus();
		return false;
	 }

	 return true;					
}