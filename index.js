function addtocart(name,price)
{
	var cookieName = "#"+name+"|"+price+"=";
	var value = 0;
	var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        c = c.trim();
        if (c.indexOf(cookieName) == 0)  
			value = c.substring(cookieName.length,c.length);
    }
	value = value*1 + 1;
	
	var date = new Date();
	date.setTime(date.getTime()+24*60*60*1000);
	var expires = "; expires="+date.toGMTString();
	document.cookie = cookieName+value+expires;
	location.reload();
}

function removefromcart(name,price,val)
{
	var date = new Date();
	val = val - 1;
	if (val==0)		
		date.setTime(date.getTime()-24*60*60*1000);
	else
		date.setTime(date.getTime()+24*60*60*1000);
	var expires = "; expires="+date.toGMTString();
	document.cookie = "#"+name+"|"+price+"="+val+expires;
	location.reload();
}

function docheckbox(checkboxElem)
{
	redirect = "/?";

	checkboxes = Array.from(document.querySelectorAll('.company>input[type="checkbox"]'));
	redirect = redirect + "company=";
	flag=false;
	i=0;
	for (;i<checkboxes.length;i++)
		if (checkboxes[i].checked)
		{
			redirect = redirect + '%28company%3D%22' + checkboxes[i].name + '%22';
			flag=true;
			break;
		}	
	for (i++;i<checkboxes.length;i++)
		if (checkboxes[i].checked)
			redirect = redirect + ' OR company%3D%22' + checkboxes[i].name + '%22';
	if (flag)
		redirect = redirect + '%29';

	checkboxes = Array.from(document.querySelectorAll('.price>input[type="checkbox"]'));
	redirect = redirect + "&price=";
	flag=false;
	i=0;
	for (;i<checkboxes.length;i++)
		if (checkboxes[i].checked)
		{
			redirect = redirect + '%28price%3E%3D' + checkboxes[i].name.substr(0,3) + ' AND price%3C%3D' + checkboxes[i].name.substr(3);
			flag=true;
			break;
		}	
	for (i++;i<checkboxes.length;i++)
		if (checkboxes[i].checked)
			redirect = redirect + ' OR price%3E%3D' + checkboxes[i].name.substr(0,3) + ' AND price%3C%3D' + checkboxes[i].name.substr(3);
	if (flag)
		redirect = redirect + '%29';

	checkboxes = Array.from(document.querySelectorAll('.ram>input[type="checkbox"]'));
	redirect = redirect + "&ram=";
	flag=false;
	i=0;
	for (;i<checkboxes.length;i++)
		if (checkboxes[i].checked)
		{
			redirect = redirect + '%28ram%3D' + checkboxes[i].name.charAt(0);
			flag=true;
			break;
		}	
	for (i++;i<checkboxes.length;i++)
		if (checkboxes[i].checked)
			redirect = redirect + ' OR ram%3D' + checkboxes[i].name.charAt(0);
	if (flag)
		redirect = redirect + '%29';

	checkboxes = Array.from(document.querySelectorAll('.screen>input[type="checkbox"]'));
	redirect = redirect + "&screen=";
	flag=false;
	i=0;
	for (;i<checkboxes.length;i++)
		if (checkboxes[i].checked)
		{
			redirect = redirect + '%28screen%3E%3D' + checkboxes[i].name.substr(0,3) + ' AND screen%3C%3D' + checkboxes[i].name.substr(3);
			flag=true;
			break;
		}	
	for (i++;i<checkboxes.length;i++)
		if (checkboxes[i].checked)
			redirect = redirect + ' OR screen%3E%3D' + checkboxes[i].name.substr(0,3) + ' AND screen%3C%3D' + checkboxes[i].name.substr(3);
	if (flag)
		redirect = redirect + '%29';
		
	window.location = redirect;
}

url = window.location.href;
pos1 = url.indexOf("page=");
pos2 = url.indexOf("comment=");
pos = pos1;
if (pos1==-1)
	pos = pos2;

pages = Array.from(document.querySelectorAll('.link'));

op = "?";
if (url.includes("?"))
	op = "&";

if (pos!=-1)
{
	temp = url.substr(pos);
	url = url.replace(temp,"page=");
	for (i=1;i<=pages.length;i++)
	{
		pages[i-1].setAttribute("href",url + pages[i-1].innerHTML);
	}
}
else
{
	url = url + op + "page=";
	for (i=1;i<=pages.length;i++)
	{
		pages[i-1].setAttribute("href",url + i);
	}
}
	

if (pos!=-1)
{
	temp = url.substr(pos);
	url = url.replace(temp,"");
}
var regex = new RegExp('=|&|%28|%29|%3C|%3D|%3E|%20|%22');
var arr = url.split(regex);
checkboxes = Array.from(document.querySelectorAll('input[type="checkbox"]'));
for (i=0;i<checkboxes.length;i++)
{
	if (arr.includes(checkboxes[i].value))
		checkboxes[i].checked = true;
}
	
