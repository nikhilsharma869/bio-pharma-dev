function isBlank(inputString)
{
	if(inputString == "")
	{
		return true;
	}
	else
	{
		return false;
	}
}
function isBlank1(inputString)
{
	var expression = "^[%s]+$";
	return matchExpression(expression,inputString);
}
function matchExpression(expression,inputString)
{
	if(inputString.search(expression)<1)
	{
		return false;
	}
	else
	{
		return true;
	}
}
function isAlpha(inputString)
{
	var expression = /^[a-zA-Z]+$/;
	return matchExpression(expression,inputString);
}
function isValidEmail(inputString)
{
	var expression = /^([a-z]{1}[-a-zA-Z0-9_\.]*)@([-a-zA-Z0-9]+)([\.][a-zA-Z]+)+$/;
	return matchExpression(expression,inputString);
}
function isNumeric(inputString)
{
	var expression = /^[0-9]*$/;
	return matchExpression(expression,inputString);
}
function isAlphaWithSpace(inputString)
{
	var expression=/^[a-zA-Z ]*$/
	return matchExpression(expression,inputString);
}
function isProperPrice(inputString)
{
	var expression=/^[0-9]+(\.[0-9]{1,2})?$/;
	return matchExpression(expression,inputString);
}
function isCurrency(inputString)
{
	var expression=/^[0-9]+(|[0-9]{1,}\.[0-9]{1,2})$/;
	return matchExpression(expression,inputString);
}
function isValidURL(inputString)
{
	var expression=/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i;
	//alert(expression.test(inputString));
	if(expression.test(inputString)==false)
	{
		return false;
	}
	else
	{
		return true;
	}
	//return matchExpression(expression,inputString);
}
function isWithLegalCharachters(inputString)
{
	var expression=/^[^\<\>]+$/;
	if(expression.test(inputString)==false)
	{
		return false;
	}
	else
	{
		return true;
	}
	//return matchExpression(expression,inputString);
}
function isValidCurrency(numval) 
{
	if (isBlank(numval))
	{
		return false;
	}
	//var myRegExp = new RegExp("^[/$+|/-]?[0-9\,]*[/.]?[0-9]*$");
	var myRegExp = new RegExp("^[/$/]?[0-9\,]*[/.]?[0-9]*$");

	return myRegExp.test(numval); 
}
function isValidCommaNumeric(numval) 
{
	if (isBlank(numval))
	{
		return false;
	}
	var myRegExp = new RegExp("^[0-9\,]*$");

	return myRegExp.test(numval); 
}


