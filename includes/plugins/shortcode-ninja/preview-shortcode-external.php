<?php 

$paths = array(
    "../../..",
    "../../../..",
    "../../../../..",
    "../../../../../..",
    "../../../../../../..",
    "../../../../../../../..",
    "../../../../../../../../..",
    "../../../../../../../../../..",
    "../../../../../../../../../../..",
    "../../../../../../../../../../../..",
    "../../../../../../../../../../../../.."
);


#include wordpress, make sure its available in one of the higher folders
foreach ($paths as $path) 
{
   if(@include_once($path.'/wp-load.php')) break;
}

$shortcode_css = ADELANTE_BASE_URI. '/css/styles/main.css';
?>

<html>

<head>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" ></script>


<link rel="stylesheet" href="<?php echo $shortcode_css; ?>">

</head>
<body class='shortcode_prev'>

<?php

$shortcode = isset($_REQUEST['shortcode']) ? $_REQUEST['shortcode'] : '';

// WordPress automatically adds slashes to quotes
// http://stackoverflow.com/questions/3812128/although-magic-quotes-are-turned-off-still-escaped-strings
$shortcode = stripslashes($shortcode);

echo do_shortcode($shortcode);

?>
<script type="text/javascript">

    jQuery('#scn-preview h3:first', window.parent.document).removeClass('scn-loading');

</script>
</body>
</html>
