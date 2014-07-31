function fun_mouseover(a,b)
{
	//var picid = a+b;
	//alert('hehe = '+picid);
	if(b==1)
	{
		document.getElementById(a+b).src = 'images/star_fill.png';
	}
	if(b==2)
	{
		document.getElementById(a+1).src = 'images/star_fill.png';
		document.getElementById(a+b).src = 'images/star_fill.png';
	}
	if(b==3)
	{
		document.getElementById(a+1).src = 'images/star_fill.png';
		document.getElementById(a+2).src = 'images/star_fill.png';
		document.getElementById(a+b).src = 'images/star_fill.png';
	}
	if(b==4)
	{
		document.getElementById(a+1).src = 'images/star_fill.png';
		document.getElementById(a+2).src = 'images/star_fill.png';
		document.getElementById(a+3).src = 'images/star_fill.png';
		document.getElementById(a+b).src = 'images/star_fill.png';
	}
	if(b==5)
	{
		document.getElementById(a+1).src = 'images/star_fill.png';
		document.getElementById(a+2).src = 'images/star_fill.png';
		document.getElementById(a+3).src = 'images/star_fill.png';
		document.getElementById(a+4).src = 'images/star_fill.png';
		document.getElementById(a+b).src = 'images/star_fill.png';
	}
	
}
function fun_mouseout(x,y)
{
	if(y==1)
	{
		document.getElementById(x+y).src = 'images/star_unfill.png';
	}
	if(y==2)
	{
		document.getElementById(x+y).src = 'images/star_unfill.png';
		document.getElementById(x+1).src = 'images/star_unfill.png';
	}
	if(y==3)
	{
		document.getElementById(x+y).src = 'images/star_unfill.png';
		document.getElementById(x+2).src = 'images/star_unfill.png';
		document.getElementById(x+1).src = 'images/star_unfill.png';
	}
	if(y==4)
	{
		document.getElementById(x+y).src = 'images/star_unfill.png';
		document.getElementById(x+3).src = 'images/star_unfill.png';
		document.getElementById(x+2).src = 'images/star_unfill.png';
		document.getElementById(x+1).src = 'images/star_unfill.png';
	}
	if(y==5)
	{
		document.getElementById(x+y).src = 'images/star_unfill.png';
		document.getElementById(x+4).src = 'images/star_unfill.png';
		document.getElementById(x+3).src = 'images/star_unfill.png';
		document.getElementById(x+2).src = 'images/star_unfill.png';
		document.getElementById(x+1).src = 'images/star_unfill.png';
	}
}

function fun_onclick(m,n,o)
{ //alert('clicked = ');
	var xmlHttp;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			//alert('op = '+xmlHttp.responseText);
			document.getElementById('star_rate'+o).innerHTML=xmlHttp.responseText;
			document.getElementById('ve'+o).value = n+'.00';
			myajax_onclick(document.getElementById('ve1').value,document.getElementById('ve2').value,document.getElementById('ve3').value,document.getElementById('ve4').value,document.getElementById('ve5').value);
		}
	}
	xmlHttp.open("POST","mystarajax.php?mid="+n,true);
	xmlHttp.send(null);
}
function resfun1()
{
	location.href='contractor_rating.php';
}
function resfun()
{
	location.href='employer_rating.php';
}
function myajax_onclick(v1, v2, v3, v4, v5)
{ //alert('clicked = ');
	var avgrt = Math.round((parseInt(v1)+parseInt(v2)+parseInt(v3)+parseInt(v4)+parseInt(v5))/5);
	var xmlHttp;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			//alert('op = '+xmlHttp.responseText);
			document.getElementById('staravg_rate1').innerHTML=xmlHttp.responseText;
			document.getElementById('ver').value = avgrt+'.00';
		}
	}
	xmlHttp.open("POST","mystarajax.php?mid="+avgrt,true);
	xmlHttp.send(null);
}