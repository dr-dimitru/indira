var c_name = 'redirect_to';
var c_value = document.cookie;
var c_start = c_value.indexOf(" " + c_name + "=");
if (c_start == -1)
{
	c_start = c_value.indexOf(c_name + "=");
}
if (c_start == -1)
{
	c_value = null;
}
else
{
	c_start = c_value.indexOf("=", c_start) + 1;
	var c_end = c_value.indexOf(";", c_start);
	if (c_end == -1)
	{
		c_end = c_value.length;
	}
	c_value = unescape(c_value.substring(c_start,c_end));
}
console.log(c_value);
shower(c_value, 'super_logo', 'work_area', false, true, '', false, false);