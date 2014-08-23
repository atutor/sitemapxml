<?php
/****************************************************************/
/* ATutor	XML SiteMap													                               */
/****************************************************************/
/* Copyright (c) 2002-2014                                                                           */
/* ATutprSpaces                                                                                           */
/* https://www.atutorspaces.con                   												   */
/*                                                                                                                */
/* This program is free software. You can redistribute it and/or                         */
/* modify it under the terms of the GNU General Public License                         */
/* as published by the Free Software Foundation.				                                */
/****************************************************************/
// $Id$
$_user_location = 'public';

define('AT_INCLUDE_PATH', '../../include/');
require(AT_INCLUDE_PATH.'vitals.inc.php');
require(AT_INCLUDE_PATH.'lib/menu_pages.php');
require(AT_INCLUDE_PATH.'../mods/_standard/forums/lib/forums.inc.php');
require(AT_INCLUDE_PATH.'../mods/_standard/student_tools/classes/StudentToolsUtil.class.php');

// Enter the course ID for each course that should be included in the sitemap
$courses_sitemap = array(5, 13);

foreach($courses_sitemap as $course_sitemap){
    $sitemap_count++;
    if($sitemap_count > 1){
        $sitemap_sql .= " OR course_id =". $course_sitemap;
    }else{
        $sitemap_sql = " course_id =". $course_sitemap;
    }
}

header ("content-type: text/xml");
$sitemap_head = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

echo $sitemap_head;
echo '<url><loc>'.$_base_href	.'index.php</loc></url>'."\n";

$sm_course_id = preg_split("#\/#",$_SERVER['PHP_SELF']);
$sql = "SELECT content_id, content_type, last_modified from %scontent WHERE ".$sitemap_sql ;
//$sql = "SELECT content_id, content_type, last_modified from %scontent WHERE course_id =1 OR course_id =3";

$rows_pages = queryDB($sql, array(TABLE_PREFIX));
foreach($rows_pages as $row){

	if($row['content_type'] == "0"){
		echo '<url>
			<loc>'.$_base_href.url_rewrite('content.php?cid='.$row['content_id']).'</loc>
			<lastmod>'.substr($row['last_modified'], 0, 10).'</lastmod>
			<changefreq>weekly</changefreq>
		</url>'."\n";
	}
}

$sql="SELECT main_links from %scourses WHERE course_id = 3 OR course_id = 1";
$main_links = queryDB($sql, array(TABLE_PREFIX));

$main_links_array = preg_split("#\|#", $main_links['main_links']);

foreach($main_links_array as $mainlink){
	if(!stristr($mainlink, "sitemapxml")){
	echo '<url><loc>'.$_base_href	.''.url_rewrite($mainlink).'</loc></url>'."\n";
	}
}
echo '<url>
		<loc>'
		.$_base_href	.''.url_rewrite('search.php').'
		</loc>
	</url>'."\n";
echo '<url>
		<loc>'
			.$_base_href	.'help/
		</loc>
	</url>'."\n";
echo '</urlset>'."\n";

?>