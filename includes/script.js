var callerID='';
var typing = false;

$(document).ready(function()
{
	configurePage();
	$(".proposal_link").click(function(sender){document.getElementById("proposalID").value = sender.target.value;  document.getElementById("propsalIDForm").submit();});
	$("#new_proposal").click(function(sender){document.getElementById("proposalID").value = sender.target.value;  document.getElementById("propsalIDForm").submit();});
	$("#browse_file").click(function()
	{
		$("#file").click();
	});
	$("#file").change(function()
	{
		$("#change_pic").click();
	});
});

function fixImage(id)
{
  document.getElementById(id).src='../includes/images/default.jpg';
}

function configurePage()
{
	
}

function findPos(id) {
    var node = document.getElementById(id); 	
    var curtop = 0;
    var curtopscroll = 0;
    if (node.offsetParent)
    {
        do{
            curtop += node.offsetTop;
            curtopscroll += node.offsetParent ? node.offsetParent.scrollTop : 0;
        } while (node = node.offsetParent);
        return (curtop - curtopscroll);
    }
}

function setSelector(id, value)
{
	for (i=0;  i<document.getElementById(id).length;  i++)
	{
		if (document.getElementById(id)[i].value==value)
		{
			document.getElementById(id).selectedIndex = i;
			return;
		}
	}
}