<?php
/* Copyright (C) 2010 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2010 Regis Houssin        <regis@dolibarr.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * or see http://www.gnu.org/
 */

/**
 *  \file		htdocs/includes/menus/smartphone/iphone.lib.php
 *  \brief		Library for file iphone menus
 *  \version	$Id$
 */


/**
 * Core function to output top menu iphone
 *
 * @param $db
 * @param $atarget
 * @param $type_user     0=Internal,1=External,2=All
 */
function print_iphone_menu($db,$atarget,$type_user)
{
	require_once(DOL_DOCUMENT_ROOT."/core/class/menubase.class.php");

	global $user,$conf,$langs,$dolibarr_main_db_name;
	
	$submenus=array();

	// On sauve en session le menu principal choisi
	if (isset($_GET["mainmenu"])) $_SESSION["mainmenu"]=$_GET["mainmenu"];
	if (isset($_GET["idmenu"]))   $_SESSION["idmenu"]=$_GET["idmenu"];
	$_SESSION["leftmenuopened"]="";

	$menutop = new Menubase($db,'iphone','top');
	$menuleft = new Menubase($db,'iphone','left');
	$tabMenu = $menutop->menuTopCharger($type_user,$_SESSION['mainmenu'], 'iphone');
	//var_dump($newmenu);
	
	
	print_start_menu_array('home',$langs->trans('Home'),1);

	for($i=0; $i<count($tabMenu); $i++)
	{
		if ($tabMenu[$i]['enabled'] == true)
		{
			$idsel=(empty($tabMenu[$i]['mainmenu'])?'none':$tabMenu[$i]['mainmenu']);
			if ($tabMenu[$i]['right'] == true)	// Is allowed
			{
				// Define url
				if (preg_match("/^(http:\/\/|https:\/\/)/i",$tabMenu[$i]['url']))
				{
					$url = $tabMenu[$i]['url'];
				}
				else
				{
					$url=DOL_URL_ROOT.$tabMenu[$i]['url'];
					if (! preg_match('/\?/',$url)) $url.='?';
					else $url.='&';
					if (! preg_match('/mainmenu/i',$url) || ! preg_match('/leftmenu/i',$url))
					{
						$url.='mainmenu='.$tabMenu[$i]['mainmenu'].'&leftmenu=&';
					}
					$url.="idmenu=".$tabMenu[$i]['rowid'];
					
					$newmenu = new Menu();
					
					$submenus[$i] = $menuleft->menuLeftCharger($newmenu,$tabMenu[$i]['mainmenu'],'',($user->societe_id?1:0),'iphone');
				}

				print_start_menu_entry();
				print '<a href="#'.$tabMenu[$i]['mainmenu'].'">';
				print_text_menu_entry($tabMenu[$i]['titre']);
				print '</a>';
				print_end_menu_entry();
			}
		}
	}
	
	print_start_menu_entry();
	print '<a href="'.DOL_URL_ROOT.'/user/logout.php" target="_self">';
	print_text_menu_entry($langs->trans('Logout'));
	print '</a>';
	print_end_menu_entry();

	print_end_menu_array();

	print "\n";

	foreach($submenus as $submenu)
	{
		$menu = $submenu->liste;
		
		//var_dump($menu);
		
		if (is_array($menu) && !empty($menu))
		{
			print_start_menu_array($menu[0]['mainmenu'],$menu[0]['titre']);
				
			$num = count($menu);
				
			for($i=0; $i<$num; $i++)
			{
				$url=$menu[$i]['url'];
				if (! preg_match('/\?/',$url)) $url.='?';
				else $url.='&';
				if (! preg_match('/mainmenu/i',$url) || ! preg_match('/leftmenu/i',$url))
				{
					$url.='mainmenu='.$menu[$i]['mainmenu'].'&leftmenu=&';
				}
				$url.="idmenu=".$menu[$i]['rowid'];

				print_start_menu_entry();
				print '<a href="'.$url.'"'.($menu[$i]['atarget']?" target='".$menu[$i]['atarget']."'":($atarget?" target=$atarget":' target="_self"')).'>';
				print_text_menu_entry($menu[$i]['titre']);
				print '</a>';
				print_end_menu_entry();
			}
				
			print_end_menu_array();
		}
	}
}



function print_start_menu_array($id,$title,$selected=0)
{
	print '<ul id="'.$id.'" title="'.$title.'" '.($selected?'selected="true"':'').'>';
	print "\n";
}

function print_start_menu_entry()
{
	print '<li>';
}

function print_text_menu_entry($text)
{
	print '<span class="name">'.$text.'</span>';
	print '<span class="arrow"></span>';
}

function print_end_menu_entry()
{
	print '</li>';
	print "\n";
}

function print_end_menu_array()
{
	print '</ul>';
	print "\n";
}

?>