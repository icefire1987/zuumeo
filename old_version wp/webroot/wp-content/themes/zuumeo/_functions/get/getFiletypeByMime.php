<?php

function getFiletypeByMime($mime) {
	switch ($mime) {
		case "application/msword": 					$ending = "doc"; 		break;
		case "application/pdf": 						$ending = "pdf"; 		break;
		case "application/vnd.ms-powerpoint": 		$ending = "ppt"; 		break;
		case "audio/mpeg":								$ending = "mp3"; 		break;
		case "image/gif":									$ending = "gif"; 		break;
		case "image/png": 								$ending = "png"; 		break;
		case "image/pjpeg": 								$ending = "jpg"; 		break;
		case "image/jpeg": 								$ending = "jpg"; 		break;
		case "image/jpg": 								$ending = "jpg"; 		break;
		case "image/tif": 								$ending = "tif"; 		break;
		case "image/tiff": 								$ending = "tif"; 		break;
		case "application/x-gzip":						$ending = "tgz"; 		break;
		case "video/x-flv":								$ending = "flv"; 		break;
		case "video/mp4":									$ending = "mp4"; 		break;
		case "application/zip":							$ending = "zip"; 		break;
		case "application/x-zip":						$ending = "zip"; 		break;
		case "application/x-zip-compressed":		$ending = "zip"; 		break;
		case "application/x-shockwave-flash":		$ending = "swf"; 		break;
		case "application/postscript": 				$ending = "eps"; 		break;
		case "application/octet-stream": 			$ending = detect_mime($filename, "filetype"); 		break;
		case "text/html":									$ending = "html"; 	break;
		case "text/plain":								$ending = "txt"; 	break;
		
		
		case ".txt": 										$ending = "txt"; 		break;
		case ".mpeg": 										$ending = "mpg"; 		break;
		case ".mpg": 										$ending = "mpg"; 		break;
		case ".qt":  										$ending = "qt"; 		break;
		case ".mov": 										$ending = "mov"; 		break;
		case ".avi": 										$ending = "avi"; 		break;
		case ".wmv": 										$ending = "wmv"; 		break;
		default: 											$ending = "";		break;
	}
	
	return $ending;
}

?>