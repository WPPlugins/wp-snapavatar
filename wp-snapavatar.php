<?php 

/*
Plugin Name: WP-SnapAvatar
Version: 1.7
Plugin URI: http://www.darkx-studios.com/2008/05/wp-snapavatar.html
Description: This plugin puts the commentor's website screenshot where there is no gravatar.
Author: Neacsu Alexandru
Author URI: http://darkx-studios.com

Copyright (c) 2010
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt
*/


function site_avatar_hook($baseCode){

$OriginalAutorUrl = get_comment_author_url();
$OriginalEmail = get_comment_author_email();
$autArray = explode("/",$OriginalAutorUrl);
$AutorUrl = $autArray[2];

$PictureLink = "http://pagepeeker.com/t/t/$AutorUrl";
$PictureLinkEnc = urlencode($PictureLink);

preg_match('@http://[^"\']+["\']@',$baseCode,$newSrc);
$newSrc = $newSrc[0];
   
$tip = get_comment_type();
   
if(trim($OriginalAutorUrl)){
  $httpSrc = substr($newSrc,0,strlen($newSrc) - 1) . "&d=" . $PictureLinkEnc . "&nocatch=" . rand(10,100);
   if (get_comment_type() == "pingback" || trim($OriginalEmail) == ""){
         $newAvatar=preg_replace('@src=(["\'])http://[^"\']+["\']@',"src='" . $PictureLink . "'",$baseCode);
	} else {
         $newAvatar=preg_replace('@src=(["\'])http://[^"\']+["\']@',"src='" . $httpSrc . "'",$baseCode);
   }
 } else {
   $newAvatar = $baseCode; 
}

return $newAvatar;

}

if(function_exists('add_filter')){
 add_filter('get_avatar','site_avatar_hook',5,4);
}

?>