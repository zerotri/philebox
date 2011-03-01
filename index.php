
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript">
        function setCookie(cookie_name, value, expiration)
        {
        	var exdate = new Date();
        	exdate.setDate(exdate.getDate() + expiration)
        	var cookie_val = escape(value) + ((epiration==null) ? "":"; expires="+exdate.toUTCString());
      		document.cookie=cookie_name + "=" + cookie_val;
      	}
      	
	function getCookie(cookie_name)
	{
		var i,x,y,ARRcookies=document.cookie,split(";");
		for (i=0; i < ARRcookies.length; i++)
		{
			x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
			y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
			x = x.replace(/^\s+|\s+$/g,"");
			
			if (x == cookie_name)
			{
				return unescape(y);
			}
		}
	}
	</script>
	<link rel="stylesheet" type="text/css" href="css/default.css">
	<style type="text/css"> body { background-image: url(../<script type="test/javascript">getCookie(bg)</script>); } </style>
</head>
<body style="cursor: auto;">
<script type="text/javascript">
	var display = true;
	$(document).ready(function(){
		$("body").css("background-image", "url(uploads/hobo.gif)");
		$(".1").click(function(){
			$("body").css("background-image", "url(uploads/hobo.gif)");
			$("ul.wall").children().removeClass("selected");
			$(".1").addClass("selected");
			setCookie("bg", "hobo.gif");
		});
		$(".2").click(function(){
			$("body").css("background-image", "url(uploads/2.jpg)");
			$("ul.wall").children().removeClass("selected");
			$(".2").addClass("selected");
			setCookie("bg", "2.jpg");
		});
		$(".3").click(function(){
			$("body").css("background-image", "url(uploads/3.jpg)");
			$("ul.wall").children().removeClass("selected");
			$(".3").addClass("selected");
			setCookie("bg", "3.jpg");
		});
		$(".4").click(function(){
			$("body").css("background-image", "url(uploads/4.jpg)");
			$("ul.wall").children().removeClass("selected");
			$(".4").addClass("selected");
			setCookie("bg", "4.jpg");
		});
	});
</script>
<div class="title" id="title">
	<h1>Files... upload/browse</h1>
</div>
<div class="block">
	<div class="cell" id="cell" style="display: block; ">
		<div id="file-uploader">
			<noscript>          
				<p>Please enable JavaScript to use file uploader.</p>
			</noscript>
		</div>
		<div class="content" id="content"></div>
	</div>
</div>
<br><br>

<div class="block">
	<div id="browse">
		<?php
			function showContent($path){

				if ($handle = opendir($path))
				{
					$up = substr($path, 0, (strrpos(dirname($path."/."),"/")));
					while (false !== ($file = readdir($handle)))
					{
						if ($file != "." && $file != "..")
						{
							$fName  = $file;
							$file   = $path.'/'.$file;
							$ext = substr($fName, strrpos($fName, '.') + 1);
							$images = array("jpg", "png", "jpeg", "gif");
							if (!is_dir($file)) {
								if (in_array(strtolower($ext), $images)) {
									// Image handler!
									echo "<div id='img'><a href='".$file."' class='img'><img src='".$file."'><p class='caption'>".$fName."</p></a></div>";
								} else {
									if(is_file($file) && $fName != ".DS_Store") {
										echo "<div class='file'><a href='".$file."'>".$fName."</a></div>";
									}
								}
							}
						}
					}
					closedir($handle);
				}    
			}
			showContent("uploads");
		?>
		<br style="clear:both;">
	</div>
</div>

<ul class="wall">
	<li>wall:</li>
	<li class="1 selected">1</li>
	<li class="2">2</li>
	<li class="3">3</li>
	<li class="4">4</li>
</ul>

<script src="js/fileuploader.js" type="text/javascript"></script>
<script>        
    function createUploader(){            
        var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader'),
            action: 'fileuploader.php',
            debug: true
        });           
    }
    
    // in your app create uploader as soon as the DOM is ready
    // don't wait for the window to load  
    window.onload = createUploader;     
</script>

</body></html>
