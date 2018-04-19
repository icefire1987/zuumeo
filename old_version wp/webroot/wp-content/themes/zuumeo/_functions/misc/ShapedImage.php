<?php
// Copyright (c) 2011, Yves Goergen, http://unclassified.de
// All rights reserved.
//
// Redistribution and use in source and binary forms, with or without modification, are permitted
// provided that the following conditions are met:
//
// * Redistributions of source code must retain the above copyright notice, this list of conditions
//   and the following disclaimer.
// * Redistributions in binary form must reproduce the above copyright notice, this list of
//   conditions and the following disclaimer in the documentation and/or other materials provided
//   with the distribution.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR
// IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
// FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR
// CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
// CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
// SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
// THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
// OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
// POSSIBILITY OF SUCH DAMAGE.

// Shaped image flow function

// Prints an image floating at the side, with text flowing around the image's shape.
//
// fileName = (string) Image file name, relative to the project's root/img directory - only PNG images supported!
// side = (string) 'left' or 'right' side to put the image
// top = (int) Top margin in px
// bottom = (int) Bottom margin in px
// hspace = (int) Horizontal margin (on the side facing the text only) in px
// marginTop = (int) Additional vertical offset by which the image shall be moved down in the text in px
//
function ShapedImage($args)
{
	$image = $args['image'];
	$float = $args['float'];
	
	(isset($args['top'])) 		? $top = $args['top'] 				: $top = 16;
	(isset($args['bottom'])) 	? $bottom = $args['bottom'] 		: $bottom = 6;
	(isset($args['hspace'])) 	? $hspace = $args['hspace'] 		: $hspace = 40;
	(isset($args['marginTop'])) ? $marginTop = $args['marginTop'] 	: $marginTop = 0;
	
	
	// TODO: Configure the path names in the following two lines.
	$cacheFileName = 'cache/' . md5($image . ':' . $float . ':' . $top . ':' . $bottom . ':' . $hspace . ':' . $marginTop) . '.html';

	list($width, $height) = getimagesize($image);
	
	(isset($args['w'])) ? $width = $args['w'] : "";
	(isset($args['h'])) ? $height = $args['h'] : "";
	
	// Print out the image
	$return = '<img src="' . $image . '" style="width: ' . $width . 'px; height: ' . $height . 'px; float: ' . $float . '; margin: ' . ($top + $marginTop) . 'px 0 -' . ($marginTop + $top + $height) . 'px 0;" alt="" />' . "\n";

	$skipCache = false;   // DEBUG

	if ($skipCache ||
		!file_exists($cacheFileName) ||
		filemtime($image) > filemtime($cacheFileName))
	{
		// Cache file is outdated, recreate the data
		$ystep = 5;
		$yextra = $hspace / 2;

		$leftSide = $float == 'left';
		#$t0 = microtime(true);
		$im = imagecreatefrompng($image);
		$divs = array();
		$prevDiv = null;
		// For each block ow rows (group of $ystep rows)
		for ($basey = 0; $basey < $height; $basey += $ystep)
		{
			// Find the farest X position of transparency in all rows of this group
			$rowx = $leftSide ? 0 : $width - 1;
			for ($y = max(0, $basey - $yextra); $y < $height && $y < $basey + $ystep - 1 + $yextra; $y++)
			{
				if ($leftSide)
				{
					// For each row in the group
					for ($x = $width - 1; $x >= $rowx; $x--)
					{
						$color = imagecolorat($im, $x, $y);
						#$alpha = ($color & 0x7F000000) >> 24;   // Only for 32-bit colour images
						$colors = imagecolorsforindex($im, $color);
						$alpha = $colors['alpha'];
						if ($alpha < 127) break;   // 127 is the maximum transparency (PHP doesn't use opacity!)
					}
					$rowx = max($x, $rowx);
				}
				else
				{
					// For each row in the group
					for ($x = 0; $x <= $rowx; $x++)
					{
						$color = imagecolorat($im, $x, $y);
						#$alpha = ($color & 0x7F000000) >> 24;   // Only for 32-bit colour images
						$colors = imagecolorsforindex($im, $color);
						$alpha = $colors['alpha'];
						if ($alpha < 127) break;   // 127 is the maximum transparency (PHP doesn't use opacity!)
					}
					$rowx = min($x, $rowx);
				}
			}

			// Set the image shape div's size
			$w = $leftSide ? $rowx : $width - 1 - $rowx;
			if ($w > 0)
				$w += $hspace;
			$h = $ystep;

			// Compare the current div's size with the previous'
			if (isset($prevDiv) && abs($prevDiv[1] - $w) < 5)
			{
				// (Almost) same width, combine both divs in height to save HTML code
				$lastIndex = count($divs) - 1;
				$divs[$lastIndex][0] += $h;
				$divs[$lastIndex][1] = max($divs[$lastIndex][1], $w);
			}
			else
			{
				// Different width, add new div
				$prevDiv = array($h, $w);
				$divs[] = $prevDiv;
			}
		}
		#echo ' [' . round((microtime(true) - $t0) * 1000) . ' ms] ';

		// Regard the top and bottom margin for the first and last block
		$divs[0][0] += $top;
		$divs[count($divs) - 1][0] += $bottom;

		// Print out all divs
		$cache = '';
		foreach ($divs as $div)
		{
			// Insert top margin before the first spacer element
			if (!strlen($cache) && $marginTop)
			{
				$cache .= '<div style="float: ' . $float . '; clear: ' . $float . '; width: 0px; height: ' . $marginTop . 'px;"></div>' . "\n";
			}

			list($h, $w) = $div;
			$cache .= '<div style="float: ' . $float . '; clear: ' . $float . '; width: ' . $w . 'px; height: ' . $h . 'px;" class="imageshape"></div>' . "\n";
		}

		// Create cache directory and file
		if (!is_dir(dirname($cacheFileName)))
			mkdir(dirname($cacheFileName), 0777, true);
		file_put_contents($cacheFileName, $cache);

		// Print output
		$return .= $cache;
	}
	else
	{
		// Print cached file
		readfile($cacheFileName);
	}
	
	return $return;
}

?>