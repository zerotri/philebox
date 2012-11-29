<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/default.css">
	<style type="text/css"> body { background-color: #FFFEFA; } </style>
</head>
<body style="cursor: auto;">

<div class="title" id="title">
	<h1>File browser</h1>
</div>

<div class="block">
	<div id="browse">
		<?php
			function getIcon($ext)
			{
				// The old way of doing this was rather archaic.
				// A bunch of if statements. This should be easier to maintain.
				
				$types = array
				(
					"image_32x32.png"		=> array("jpg", "png", "jpeg", "gif", "tiff"),
					"article_32x32.png"		=> array("txt", "mdown", "md", "markdown"),
					"article_32x32.png"		=> array("html", "php", "css", "js"),
					"movie_32x32.png"		=> array("mkv", "mp4", "m4v", "mov"),
					"headphones_32x28.png"	=> array("mp3", "m4a", "aac", "wav", "flac", "alac")
				);
				
				// Icon directory url
				$iconUrl = "img/icons/";
				
				foreach($types as $key => $value)
				{
					if(in_array(strtolower($ext), $value))
					{
						return $iconUrl.$key;
					}
				}
				
				// If the type has no associated icon, use a default one.
				return $iconUrl."/document_alt_stroke_24x32.png";
			}
			
			// This function was pulled somewhere off the internet to save time
			// Works great. Had to change the code to allow both width and
			// height to not exceed a certain size.
			function make_thumb($src, $dest, $desired_width, $max_height)
			{
				/* read the source image */
				$source_image = imagecreatefromjpeg($src);
				$width = imagesx($source_image);
				$height = imagesy($source_image);
  
	  		  	if($width != 0)
				{
					/* find the "desired height" of this thumbnail, relative to the desired width  */
					$desired_height = floor($height * ($desired_width / $width));
					if($desired_height > $max_height)
					{
						$desired_height = $max_height;
						$desired_width = floor($width * ($desired_height / $height));
					}
  
					/* create a new, "virtual" image */
					$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
  
					/* copy source image at a resized size */
					imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
  
					/* create the physical thumbnail image to its destination */
					imagejpeg($virtual_image, $dest);
				}
			}
			
			function getOrGenerateCachedThumbnail($file)
			{
				/*if(!is_file($file))
				{
					return "";
				}*/
				
				$info = pathinfo($file);
				$cachedir = $info["dirname"]."/cache/";
				$cachedfile = $cachedir . "thumb-".$info["basename"];
				
				if(is_dir($cachedir))
				{
					if(is_file($cachedfile))
					{
						return $cachedfile;
					}
					else
					{
						// Generate Thumbnail and cache
						make_thumb($file, $cachedfile,200, 200);
						if(is_file($cachedfile))
						{
							return $cachedfile;
						}
						else
						{
							return getIcon($info["extension"]);
						}
					}
				}
				else
				{
					return $file;
				}
			}
			
			function prettySize($size){
				$units = array(' B', ' KB', ' MB', ' GB', ' TB');
			    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
			    return round($size, 2).$units[$i];
			}
			
			// TODO: This function needs to be cleaned up big time.
			// There are also better ways of handling certain things that need to be fixed.
			function showContent($path){
				if ($handle = opendir($path))
				{
					$up = substr($path, 0, (strrpos(dirname($path."/."),"/")));
					$count = 0;
					$files = "";
					$images= "";
					while (false !== ($file = readdir($handle)))
					{
						if ($file != "." && $file != "..")
						{
							$fName  = $file;
							$file   = $path.'/'.$file;
							$fSize  = prettySize(filesize($file));
							$ext = substr($fName, strrpos($fName, '.') + 1);
							$fImage = getIcon($ext);
							$imagexts = array("jpg", "png", "jpeg", "gif");
								
							if (!is_dir($file)) {
								if (in_array(strtolower($ext), $imagexts)) {
									// Image handler!
									$thumb = getOrGenerateCachedThumbnail($file);
									$images .= "<div id='img'><a href='".$file."' class='img'><img src='".$thumb."'></a></div>";
									$count++;
									//if ( $count == 4 ) { $images .= "<br style=\"clear:both;\">"; $count = 0; }
								} else {
									if(is_file($file) && $fName != ".DS_Store" && $ext != "php" && "." . $ext != $fName) {
										$files .= "<div class='file' style=\"background:url('".$fImage."') bottom left no-repeat; line-height: 32px; padding-left: 36px; clear: both;\"><a href='".$file."'>".$fName."</a>: ".$fSize."</div>\n";
									}
								}
							}
						}
					}
					closedir($handle);
					echo $files;
					echo $images;
				}    
			}
			showContent("backgrounds");
		?>
		<br style="clear:both;">
	</div>
</div>

</body></html>
