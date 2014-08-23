<?php
if (!defined('AT_INCLUDE_PATH')) { exit; }
if (!isset($this) || (isset($this) && (strtolower(get_class($this)) != 'module'))) { exit(__FILE__ . ' is not a Module'); }

define('AT_ADMIN_PRIV_SITEMAPXML', $this->getAdminPrivilege());
// if this module is to be made available to students on the Home or Main Navigation
//$_student_tool = 'mods/sitemapxml/sitemap.php';
if (admin_authenticate(AT_ADMIN_PRIV_SITEMAPXML, TRUE) || admin_authenticate(AT_ADMIN_PRIV_ADMIN, TRUE)) {
$this->_pages[AT_NAV_ADMIN] = array('mods/sitemapxml/sitemap.php');
$this->_pages['mods/sitemapxml/sitemap.php']['title_var'] = 'sitemapxml';
$this->_pages['mods/sitemapxml/sitemap.php']['parent']    = 'index.php';
$this->_pages['mods/sitemapxml/sitemap.php']['text']      = _AT('sitemap_text');
}
?>