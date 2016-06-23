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

JCckDev::initScript( 'typo', $this->item );
$texts	=	array(
				'COM_CCK_PHP_STRING_START',
				'COM_CCK_PHP_STRING_LENGTH',
				'COM_CCK_PHP_STRING_SEARCH',
				'COM_CCK_PHP_STRING_REPLACE',
				'COM_CCK_STRING'
			);
foreach ( $texts as $t ) {
	JText::script( $t );
}
?>

<div class="seblod">
	<?php echo JCckDev::renderLegend( JText::_( 'COM_CCK_CONSTRUCTION' ), JText::_( 'PLG_CCK_FIELD_TYPO_'.$this->item->name.'_DESC' ) ); ?>
    <ul class="adminformlist adminformlist-2cols">
        <?php
		echo JCckDev::renderForm( 'core_dev_select', '', $config, array( 'label'=>'Function', 'selectlabel'=>'Select', 'options'=>'str_repeat||str_replace||strip_tags||strtolower||strtoupper||substr||ucfirst||acldeny||ucwords', 'bool8'=>0, 'storage_field'=>'function' ) );
		echo JCckDev::renderForm( 'core_dev_text', '', $config, array( 'label'=>'Php String Start', 'storage_field'=>'arg1', 'required'=>'required' ) );
		echo JCckDev::renderBlank( '<input type="hidden" id="blank_li" value="" />' );
		echo JCckDev::renderForm( 'core_dev_text', '', $config, array( 'label'=>'Php String Length', 'storage_field'=>'arg2' ) );
		echo JCckDev::renderBlank( '<input type="hidden" id="blank_li2" value="" />' );
		echo JCckDev::renderForm( 'core_dev_text', '', $config, array( 'label'=>'Php String Suffix Overflow', 'storage_field'=>'suffix_overflow' ) );
		echo JCckDev::renderForm( 'core_dev_bool', '', $config, array( 'label'=>'Php String Lower first', 'defaultvalue'=>'0', 'storage_field'=>'force' ) );
        ?>
    </ul>
    <ul class="adminformlist adminformlist-2cols">
        <?php
		echo JCckDev::renderForm( 'core_dev_text', '', $config, array( 'label'=>'Php String Prefix', 'storage_field'=>'prefix' ) );
		echo JCckDev::renderForm( 'core_dev_text', '', $config, array( 'label'=>'Php String Suffix', 'storage_field'=>'suffix' ) );

		echo JCckDev::renderSpacer( JText::_( 'COM_CCK_CONSTRUCTION' ) . '<span class="mini">('.JText::_( 'COM_CCK_GENERIC' ).')</span>' );
		echo JCckDev::renderForm( 'core_dev_bool', '', $config, array( 'label'=>'Typo Label', 'selectlabel'=>'', 'defaultvalue'=>'0', 'storage_field'=>'typo_label' ) );
		echo JCckDev::renderBlank();
        ?>
    </ul>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	var v = $('#function').val();
	if (v == 'str_replace') {
		$('#force').parent().hide();
		$('#arg1').parent().find('label').html(Joomla.JText.COM_CCK_PHP_STRING_SEARCH+'<span class="star"> *</span>');
		$('#arg2').parent().find('label').html(Joomla.JText.COM_CCK_PHP_STRING_REPLACE);
		$('#arg1,#arg2,#blank_li').parent().show();
		$('#suffix_overflow,#blank_li2').parent().hide();
	} else if (v == 'substr') {
		$('#force').parent().hide();
		$('#arg1').parent().find('label').html(Joomla.JText.COM_CCK_PHP_STRING_START+'<span class="star"> *</span>');
		$('#arg2').parent().find('label').html(Joomla.JText.COM_CCK_PHP_STRING_LENGTH);
		$('#arg1,#arg2,#blank_li').parent().show();
		$('#suffix_overflow,#blank_li2').parent().show();
	} else if (v == 'str_repeat') {
		$('#force').parent().hide();
		$('#arg1').parent().show().find('label').html(Joomla.JText.COM_CCK_STRING+'<span class="star"> *</span>');
		$('#arg2,#blank_li').parent().hide();
		$('#suffix_overflow,#blank_li2').parent().hide();
	} else {
		if ( v == 'ucfirst' || v == 'ucwords' ) {
			$('#force').parent().show();
		} else {
			$('#force').parent().hide();
		}
		$('#arg1,#arg2,#blank_li').parent().hide();
		$('#suffix_overflow,#blank_li2').parent().hide();
	}
	$("form#adminForm").on("change", "#function", function() {
		var v = $(this).val();
		if (v == 'str_replace') {
			$('#force').parent().hide();
			$('#arg1').parent().find('label').html(Joomla.JText.COM_CCK_PHP_STRING_SEARCH+'<span class="star"> *</span>');
			$('#arg2').parent().find('label').html(Joomla.JText.COM_CCK_PHP_STRING_REPLACE);
			$('#arg1,#arg2,#blank_li').parent().show();
			$('#suffix_overflow,#blank_li2').parent().hide();
		} else if (v == 'substr') {
			$('#force').parent().hide();
			$('#arg1').parent().find('label').html(Joomla.JText.COM_CCK_PHP_STRING_START+'<span class="star"> *</span>');
			$('#arg2').parent().find('label').html(Joomla.JText.COM_CCK_PHP_STRING_LENGTH);
			$('#arg1,#arg2,#blank_li').parent().show();
			$('#suffix_overflow,#blank_li2').parent().show();
		} else if (v == 'str_repeat') {
			$('#force').parent().hide();
			$('#arg1').parent().show().find('label').html(Joomla.JText.COM_CCK_STRING+'<span class="star"> *</span>');
			$('#arg2,#blank_li').parent().hide();
			$('#suffix_overflow,#blank_li2').parent().hide();
		} else {
			if ( v == 'ucfirst' || v == 'ucwords' ) {
				$('#force').parent().show();
			} else {
				$('#force').parent().hide();
			}
			$('#arg1,#arg2,#blank_li').parent().hide();
			$('#suffix_overflow,#blank_li2').parent().hide();
		}
	});
});
</script>