<?php

function gpid2gpname($gpid)
{
    if ($gpid)
    {
	$db_query = "SELECT gp_name FROM "._DB_PREF_."_toolsSimplephonebook_group WHERE gpid='$gpid'";
	$db_result = dba_query($db_query);
	$db_row = dba_fetch_array($db_result);
	$gp_name = $db_row['gp_name'];
    }
    return $gp_name;
}

function gpcode2gpname($uid,$gp_code)
{
    if ($uid && $gp_code)
    {
	$db_query = "SELECT gp_name FROM "._DB_PREF_."_toolsSimplephonebook_group WHERE uid='$uid' AND gp_code='$gp_code'";
	$db_result = dba_query($db_query);
	$db_row = dba_fetch_array($db_result);
	$gp_name = $db_row['gp_name'];
    }
    return $gp_name;
}

function pid2pnum($pid)
{
    global $username;
    if ($pid)
    {
	$uid = username2uid($username);
	$db_query = "SELECT p_num FROM "._DB_PREF_."_toolsSimplephonebook WHERE pid='$pid' AND uid='$uid'";
	$db_result = dba_query($db_query);
	$db_row = dba_fetch_array($db_result);
	$p_num = $db_row['p_num'];
    }
    return $p_num;
}

function pnum2pemail($p_num)
{
    global $username;
    if ($p_num)
    {
	$uid = username2uid($username);
	$db_query = "SELECT p_email FROM "._DB_PREF_."_toolsSimplephonebook WHERE p_num='$p_num' AND uid='$uid'";
	$db_result = dba_query($db_query);
	$db_row = dba_fetch_array($db_result);
	$p_email = $db_row['p_email'];
    }
    return $p_email;
}

// --------------------------------------------------------------------------------------------

function simplephonebook_hook_phonebook_groupid2code($gpid) {
    if ($gpid) {
	$db_query = "SELECT gp_code FROM "._DB_PREF_."_toolsSimplephonebook_group WHERE gpid='$gpid'";
	$db_result = dba_query($db_query);
	$db_row = dba_fetch_array($db_result);
	$gp_code = $db_row['gp_code'];
    }
    return $gp_code;
}

function simplephonebook_hook_phonebook_groupcode2id($uid,$gp_code) {
    if ($uid && $gp_code) {
	$db_query = "SELECT gpid FROM "._DB_PREF_."_toolsSimplephonebook_group WHERE uid='$uid' AND gp_code='$gp_code'";
	$db_result = dba_query($db_query);
	$db_row = dba_fetch_array($db_result);
	$gpid = $db_row['gpid'];
    }
    return $gpid;
}

function simplephonebook_hook_phonebook_number2name($p_num) {
    global $username;
    if ($p_num) {
	if (substr($p_num,0,1) == 0) {
	    $p_num = substr($p_num,1);
	}
	$uid = username2uid($username);
	$db_query = "SELECT p_desc FROM "._DB_PREF_."_toolsSimplephonebook WHERE p_num LIKE '%$p_num' AND uid='$uid'";
	$db_result = dba_query($db_query);
	$db_row = dba_fetch_array($db_result);
	$p_desc = $db_row['p_desc'];
    }
    return $p_desc;
}

function simplephonebook_hook_phonebook_getdatabyid($gpid, $orderby="") {
    $ret = array();
    $db_query = "SELECT * FROM "._DB_PREF_."_toolsSimplephonebook WHERE gpid='$gpid'";
    if ($orderby) {
	$db_query .= " ORDER BY ".$orderby;
    }
    $db_result = dba_query($db_query);
    while ($db_row = dba_fetch_array($db_result)) {
	$ret[] = $db_row;
    }
    return $ret;
}

function simplephonebook_hook_phonebook_getdatabyuid($uid, $orderby="") {
    $ret = array();
    $db_query = "SELECT * FROM "._DB_PREF_."_toolsSimplephonebook WHERE uid='$uid'";
    if ($orderby) {
	$db_query .= " ORDER BY ".$orderby;
    }
    $db_result = dba_query($db_query);
    while ($db_row = dba_fetch_array($db_result)) {
	$ret[] = $db_row;
    }
    return $ret;
}

function simplephonebook_hook_phonebook_getsharedgroup($uid) {
    $ret = array();
    $db_query = "
	SELECT 
	    "._DB_PREF_."_toolsSimplephonebook_group.gpid as gpid, 
	    "._DB_PREF_."_toolsSimplephonebook_group.gp_name as gp_name,
	    "._DB_PREF_."_toolsSimplephonebook_group.gp_code as gp_code,
	    "._DB_PREF_."_toolsSimplephonebook_group.uid as uid
	FROM "._DB_PREF_."_toolsSimplephonebook_group,"._DB_PREF_."_toolsSimplephonebook_group_public
	WHERE 
	    "._DB_PREF_."_toolsSimplephonebook_group.gpid="._DB_PREF_."_toolsSimplephonebook_group_public.gpid AND
	    NOT ("._DB_PREF_."_toolsSimplephonebook_group_public.uid='$uid')
	ORDER BY gp_name
    ";
    $db_result = dba_query($db_query);
    while ($db_row = dba_fetch_array($db_result)) {
	$ret[] = $db_row;
    }
    return $ret;
}

function simplephonebook_hook_phonebook_getgroupbyuid($uid, $orderby="") {
    $ret = array();
    $db_query = "SELECT * FROM "._DB_PREF_."_toolsSimplephonebook_group WHERE uid='$uid'";
    if ($orderby) {
	$db_query .= " ORDER BY ".$orderby;
    }
    $db_result = dba_query($db_query);
    while ($db_row = dba_fetch_array($db_result)) {
	$ret[] = $db_row;
    }
    return $ret;
}

?>