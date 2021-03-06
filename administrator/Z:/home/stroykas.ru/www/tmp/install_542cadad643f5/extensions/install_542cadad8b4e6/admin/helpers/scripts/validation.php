<?php
/**
* @version 			SEBLOD 3.x Core ~ $Id: validation.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				http://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2013 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

require_once JPATH_ADMINISTRATOR.'/components/com_cck/helpers/helper_admin.php';

$id			=	$this->item->id;
$name		=	$this->item->name;
$lang   	=	JFactory::getLanguage();
$ajax_load	=	'components/com_cck/assets/styles/seblod/images/ajax.gif';
//Helper_Include::addDependencies( 'box', 'edit' );
Helper_Include::addTooltip( 'span[title].qtip_cck', 'left center', 'right center' );

$doc	=	JFactory::getDocument();
$doc->addStyleSheet( JROOT_MEDIA_CCK.'/scripts/jquery-colorbox/css/colorbox.css' );
$doc->addScript( JROOT_MEDIA_CCK.'/scripts/jquery-colorbox/js/jquery.colorbox-min.js' );
$js		=	'
			(function ($){
				JCck.Dev = {
					ajaxLayer: function(elem, data, opts) {
						var loading = \'<img align="center" src="'.$ajax_load.'" alt="" />\';
						$.ajax({
						  cache: false,
						  data: data,
						  type: "POST",
						  url: "index.php?option=com_cck&task=box.add&layout=raw&tmpl=component",
						  beforeSend:function(){ $("#loading").html(loading); $(elem).html(""); },
						  success: function(response){ $("#loading").html(""); $(elem).html(response); if (opts) { JCck.Dev.setOptions(opts); } },
						  error:function(){ $(elem).html("<div><strong>Oops!</strong> Try to close the page & re-open it properly.</div>"); }
						});
					},
					reset: function() {
						var eid = "'.$id.'";
						parent.jQuery("#"+eid+"_required_alert").val("");
						parent.jQuery("#"+eid+"_validation").val("");
						parent.jQuery("#"+eid+"_validation_options").val("");
						this.close();
					},
					setOptions: function(opts) {
						var data = $.evalJSON(opts);
						$.each(data, function(k, v) {
							$("#"+k).myVal(v);
						});
					},
					submit: function() {
						if ( $("#adminForm").validationEngine("validate") === true ) {
							var eid = "'.$id.'";
							var data = $("#required").val();
							var text = data ? "'.JText::_( 'COM_CCK_REQUIRED' ).'" : "'.JText::_( 'COM_CCK_OPTIONAL' ).'";
							parent.jQuery("#"+eid+"_required").val(data);
							data = $("#required_alert").val();
							parent.jQuery("#"+eid+"_required_alert").val(data);
							data = $("#validation").val();
							if (data) {
								text += " + 1";
							}
							parent.jQuery("#"+eid+"_validation").val(data);
							data = {};
							data["alert"] = ($("#alert").prop("disabled") !== false) ? "" : $("#alert").myVal();
							$("#layer input.text, #layer select.select, #layer fieldset.checkbox, #layer fieldset.radios").each(function(i) {
								id = $(this).attr("id");
								data[id] = $(this).myVal();
							});
							var encoded	= $.toJSON(data);
							parent.jQuery("#"+eid+"_validation_options").val(encoded).next("span").html(text);
							this.close();
							return;
						}
					}
    			}
				$(document).ready(function(){
					var eid = "'.$id.'";
					var data = parent.jQuery("#"+eid+"_required").val();
					$("#required").val(data);
					data = parent.jQuery("#"+eid+"_required_alert").val();
					$("#required_alert").val(data);
					
					var opts = parent.jQuery("#"+eid+"_validation_options").val();
					opts = (opts != "") ? opts : "{}";
					JCck.Dev.setOptions(opts);
					$("#validation").live("change", function() {
						var validation = $(this).val();
						if (validation) {
							JCck.Dev.ajaxLayer("#layer", "&file=plugins/cck_field_validation/"+validation+"/tmpl/edit.php&name="+validation, opts);
						} else {
							$("#layer").html("");
						}
					});
				});
			})(jQuery);
			';
$doc->addScriptDeclaration( $js );
?>

<div class="seblod">
	<?php echo JCckDev::renderLegend( JText::_( 'COM_CCK_REQUIRED' ) ); ?>
    <ul class="adminformlist adminformlist-2cols">
        <?php
		echo JCckDev::renderForm( 'core_dev_select', '', $config, array( 'label'=>'Required', 'selectlabel'=>'', 'options'=>'No=||Yes=required', 'storage_field'=>'required' ) );
		echo JCckDev::renderForm( 'core_dev_text', '', $config, array( 'label'=>'Alert', 'storage_field'=>'required_alert' ) );
        ?>
    </ul>
</div>
<div class="seblod">
	<?php echo JCckDev::renderLegend( JText::_( 'COM_CCK_VALIDATION' ) ); ?>
    <div id="loading" class="loading"></div>
    <ul class="adminformlist adminformlist-2cols">
        <?php
		$options	=	Helper_Admin::getPluginOptions( 'field_validation', 'cck_', false, true, true, array( 'required' ) );
		$validation	=	JHtml::_( 'select.genericlist', $options, 'validation', 'size="1" class="inputbox select" style="max-width:175px;"', 'value', 'text', $name, 'validation' );
        ?>
        <li><label><?php echo JText::_( 'COM_CCK_VALIDATION' ); ?></label><?php echo $validation; ?></li>
        <?php echo JCckDev::renderForm( 'core_validation_alert', '', $config ); ?>
    </ul>
    <ul id="layer" class="adminformlist adminformlist-2cols">
		<?php
        if ( $name ) {
            $layer	=	JPATH_PLUGINS.'/cck_field_validation/'.$name.'/tmpl/edit.php';
            if ( is_file( $layer ) ) {
                include_once $layer;
            }
        }
        ?>
    </ul>
</div>