<?php
/**
* @version 			SEBLOD 3.x More
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				http://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2013 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

// Plugin
class plgCCK_Field_TypoPhp_String extends JCckPluginTypo
{
	protected static $type	=	'php_string';
	
	// -------- -------- -------- -------- -------- -------- -------- -------- // Prepare
	
	// onCCK_Field_TypoPrepareContent
	public function onCCK_Field_TypoPrepareContent( &$field, $target = 'value', &$config = array() )
	{
		if ( self::$type != $field->typo ) {
			return;
		}
		
		// Prepare
		$typo	=	parent::g_getTypo( $field->typo_options );
		$value	=	parent::g_hasLink( $field, $typo, $field->$target );
		
		// Set
		if ( $field->typo_label ) {
			$field->label	=	self::_typo( $typo, $field, $field->label, $config );
		}
		$field->typo		=	self::_typo( $typo, $field, $value, $config );
	}
	
	// _typo
	protected static function _typo( $typo, $field, $value, &$config = array() )
	{
		$function	=	$typo->get( 'function', '' );
		$arg1		=	$typo->get( 'arg1', '' );
		$arg2		=	$typo->get( 'arg2', '' );
		$force		=	$typo->get( 'force', '' );
		$prefix		=	$typo->get( 'prefix', '' );
		$suffix		=	$typo->get( 'suffix', '' );

		switch ( $function ) {
			case 'str_repeat':
				$value	=	str_repeat( $arg1, (int)$value );
				break;
			case 'str_replace':
				$value	=	str_replace( $arg1, $arg2, $value );
				break;
			case 'strip_tags':
				$value	=	strip_tags( $value );
				break;
			case 'strtolower':
				$value	=	JString::strtolower( $value );
				break;
			case 'strtoupper':
				$value	=	JString::strtoupper( $value );
				break;
			case 'substr':
				$value2	=	( $arg2 != '' ) ? JString::substr( $value, $arg1, $arg2 ) : JString::substr( $value, $arg1 );
				if ( $value2 != $value ) {
					$value		=	trim( $value2 ).$typo->get( 'suffix_overflow', '' );
				}
				break;
			case 'ucfirst':
				if ( $force ) {
					$value	=	JString::strtolower( $value );
				}
				$value	=	JString::ucfirst( $value );
				break;
				//acl+
			case 'acldeny':
				$user = &JFactory::getUser()->id;
				$idart = JRequest::getInt('id');
				$db =& JFactory::getDBO();
				$db->setQuery('SELECT `created_by` FROM `#__content` WHERE `id` = '.$idart);
				$res= $db->loadResult();
				//if+
				//echo $user==$res;
				if ( $user!==$res ) {
					$value	= ' ';
				}
				//if-
				break;
				//acl-
			case 'ucwords':
				if ( $force ) {
					$value	=	JString::strtolower( $value );
				}
				$value	=	JString::ucwords( $value );
				break;
			default:
				break;
		}
		
		return $prefix.$value.$suffix;
	}
}
?>