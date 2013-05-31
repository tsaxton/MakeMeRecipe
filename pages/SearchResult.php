<div class="page-header"><h2>Search Results</h2></div>
<div id="content"> Wait here while we load your recipes. This could take a while.</div>

<script>
function like(recipe,user){
    var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	    if(xmlhttp.responseText == "success"){
		document.getElementById(recipe).innerHTML='You like this recipe.';
	    }
	}
    }
    xmlhttp.open("GET","modules/like.php?user="+user+"&recipe="+recipe,true);
    xmlhttp.send();
}

function dislike(recipe,user){
    var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	    if(xmlhttp.responseText == "success"){
		document.getElementById(recipe).innerHTML='You\'ve disliked this recipe.';
	    }
	}
    }
    xmlhttp.open("GET","modules/dislike.php?user="+user+"&recipe="+recipe,true);
    xmlhttp.send();
}

window.onload = function loadXMLDoc()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("content").innerHTML=xmlhttp.responseText;
    }
}
xmlhttp.open("GET","modules/loadResult.php?<?php echo http_build_query($_GET,'','&');?>",true);
xmlhttp.send();
};
</script>

<?php
#include 'modules/loadResult.php';

