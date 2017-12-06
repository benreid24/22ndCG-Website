function UpdateRelTime(id)
{
	var data = document.getElementById(id).innerHTML;
		
	//parse + edit data
	var parts = data.split(", ");
	var days = parts[0].slice(0,2);
	var hours = parts[1].slice(0,2);
	var mins = parts[2].slice(0,2);
	var secs = parts[3].slice(0,2);
	
	days = parseInt(days);
	hours = parseInt(hours);
	mins = parseInt(mins);
	secs = parseInt(secs);
		
	secs--;
	if (secs<0)
	{
		secs = 59;
		mins--;
		if (mins<0)
		{
			mins = 59;
			hours--;
			if (hours<0)
			{
				hours = 23;
				days--;
			}
		}
	}
		
	days = days.toString();
	hours = hours.toString();
	mins = mins.toString();
	secs = secs.toString();
	
	data = days + " Day";
	if (days>1)
	data = data + "s, ";
	else
	data = data + ", ";
	data = data + hours + " Hour";
	if (hours>1)
	data = data + "s, ";
	else
	data = data + ", ";
	data = data + mins + " Minute";
	if (mins>1)
	data = data + "s, ";
	else
	data = data + ", ";
	data = data + secs + " Second";
	if (secs>1)
	data = data + "s";
		
  document.getElementById(id).innerHTML = data;
	var tmp = "UpdateRelTime('"+id+"')";
	setTimeout(tmp, 1000);
}