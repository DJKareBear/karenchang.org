<?php 
	$width = $_GET['w'];
	$height = $_GET['h'];
	$src = $_GET['src'];
	$ext = parse_url($src, PHP_URL_PATH);
	$ext = pathinfo($ext, PATHINFO_EXTENSION);
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>HTML5 Video Player</title>

  <!-- Include the VideoJS Library -->
    <link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
    <style>
        html, body{
            height: 100%;
            margin: 0;
            width: 100%;
        }
        video#example_video_1,
        div#example_video_1{
            height: 100% !important;
            width: 100% !important;
        }
    </style>
    <script type="text/javascript" src="http://vjs.zencdn.net/c/video.js"></script>
</head>
<body>
<?php
//	echo $width;
//	echo $height;
//	echo $src;
//	echo $ext;
//	print_r($_GET);
//	echo "Ssos";
?>
    <video id="example_video_1" class="video-js vjs-default-skin"
           controls preload="metadata" width="<?php echo $width; ?>" height="<?php echo $height; ?>"
           data-setup='{"example_option":true}'>
    <?php if($ext == 'mp4'): ?>
        <source src="<?php echo $src; ?>" type='video/mp4' />
    <?php elseif($ext == 'webm'): ?>
        <source src="<?php echo $src; ?>" type='video/webm' />
    <?php elseif($ext == 'ogv'): ?>
        <source src="<?php echo $src; ?>" type='video/ogg' />
    <?php endif; ?>
    </video>
</body>
</html>