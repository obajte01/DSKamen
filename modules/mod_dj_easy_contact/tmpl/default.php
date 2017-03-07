<?php
/**
 * @version $Id: mod_dj_easy_contact.php 20 2015-02-06 15:57:45Z marcin $
 * @package DJ-EasyContact
 * @copyright Copyright (C) 2012 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Marcin Łyczko - marcin.lyczko@design-joomla.eu
 *
 *
 * DJ-EasyContact is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-EasyContact is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-EasyContact. If not, see <http://www.gnu.org/licenses/>.
 *
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// getting form fields
$input = JFactory::getApplication()->input;

// get style
$style = $params->get('styles', '');
if ($style == 0){
	$style_file = '1';
} else if($style == 1){
	$style_file = '2';
} else if($style == 2){
	$style_file = '3';
} else if($style == 3){
	$style_file = '4';
} else if($style == 4){
	$style_file = '5';
}

// get Joomla version
$version = new JVersion;
$jversion = '3';
if (version_compare($version->getShortVersion(), '3.0.0', '<')) {
    $jversion = '2.5';
}

JHTML::_('behavior.formvalidation');
if($style_file == '5'){
	if($jversion == '2.5'){
		echo JText::_('MOD_DJ_EASYCONTACT_JOOMLA_OLD_MESSAGE');
		return;
	}
	JHTML::_('behavior.modal');
}

$dj_name = $input->post->getString('dj_name');
if ($dj_name) {
  $valid_name = htmlentities($dj_name, ENT_COMPAT, "UTF-8");

  $dj_message = $input->post->getString('dj_message');
  if($dj_message){
  	$valid_message = htmlentities($dj_message, ENT_COMPAT, "UTF-8");
  }	
  
  $dj_email = $input->post->getString('dj_email');
  if($dj_email){
  	$valid_email = htmlentities($dj_email, ENT_COMPAT, "UTF-8");
  }
  

	if ($enable_anti_spam) {
		$g_recaptcha_response = $input->post->getString('g-recaptcha-response');
		if($g_recaptcha_response){
	      $captcha = $g_recaptcha_response;
	    }
		$contextOpts = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false
            )
        );
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret='".$recaptcha_secret_key."'&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'], false, stream_context_create($contextOpts));
		$result_captcha = json_decode( $response, true );
		$result_captcha['success'];
		 if($result_captcha['success'] != 1){
		     header("Content-type: text/html; charset=utf-8");
		     if (!count(array_diff(ob_list_handlers(), array('default output handler'))) || ob_get_length()) {
		        while(@ob_end_clean());
		     } 
		     echo JText::_('MOD_DJ_EASYCONTACT_WRONG_CAPTCHA');
		     die();
			 $error_message .=  ' <span class="error-dj-simple-contact-form">'.JText::_('MOD_DJ_EASYCONTACT_WRONG_CAPTCHA').'</span>';
		 }
	 }

	$current_url = JText::_('MOD_DJ_EASYCONTACT_SEND_FROM').' '.JURI::current();
	$user_ip = JText::_('MOD_DJ_EASYCONTACT_IP').' '.$_SERVER['REMOTE_ADDR'];
 	jimport('joomla.environment.browser');
    $doc = JFactory::getDocument();
    $browser = JBrowser::getInstance();
    $browserType = JText::_('MOD_DJ_EASYCONTACT_BROWSER_TYPE').' '.$browser->getBrowser();
    $browserVersion = JText::_('MOD_DJ_EASYCONTACT_BROWSER_VERSION').' '.$browser->getMajor();
	$full_agent_string = JText::_('MOD_DJ_EASYCONTACT_FULL_AGENT_STRING').' '.$browser->getAgentString();

	
    if($email_required == 1){
	$message_text = JText::_('MOD_DJ_EASYCONTACT_MESSAGE_INFO'). ' ' . $dj_name.' - '.$dj_email ."\n\n". $dj_message."\n\n".$current_url."\n\n".$user_ip
	."\n\n".$browserType."\n\n".$browserVersion."\n\n".$full_agent_string;
    } else {
    	$message_text = $dj_message."\n\n".$current_url."\n\n".$user_ip
		."\n\n".$browserType."\n\n".$browserVersion."\n\n".$full_agent_string;
    }
    
	// sending email to admin
    $mailSender = JFactory::getMailer();
    $mailSender->addRecipient($recipient);
    $mailSender->setSender(array($fromEmail,$dj_name));
	if($email_required){
		$mailSender->addReplyTo($dj_email, '' );
	}
    $mailSender->setSubject($mySubject);
    $mailSender->setBody($message_text);
	$mailSender->Send();

	// sending thanks message
	if($email_thanks && $email_required){
		$mailSender_thanks = JFactory::getMailer();
		$mailSender_thanks->addRecipient($dj_email);
		
	    $mailSender_thanks->setSender(array( $fromEmail, $sendersname ));
	    $mailSender_thanks->addReplyTo($fromEmail,'');
		
	    $mailSender_thanks->setSubject($email_thanks_subject);
	    $mailSender_thanks->setBody($email_thanks_message."\n\n".JText::_('MOD_DJ_EASYCONTACT_YOUR_MESSAGE')."\n".$dj_message);
		
	    $mailSender_thanks->Send();		
	}
    if (!count(array_diff(ob_list_handlers(), array('default output handler'))) || ob_get_length()) {
        while(@ob_end_clean());
    } 
	echo 'OK';
    jexit();
} 



// check recipient
if ($recipient === "") {
  $myReplacement = '<span class="error-dj-simple-contact-form">'.JText::_('MOD_DJ_EASYCONTACT_NO_RECIPIENT').'</span>';
  print $myReplacement;
  return true;
}
$is_email_field_on = 'email-field-active';
if($email_required != 1){
	$is_email_field_on = 'email-field-not-active';
}
if($style_file == '5'){ ?>
	<div id="modal-dj-easy-contact-box" class="modal hide fade">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&nbsp;</span></button>
	    <h3 id="myModalLabel"><?php echo JText::_('MOD_DJ_EASYCONTACT_MODAL_HEADER'); ?></h3>
	  </div>
	  <div class="modal-body">
	  		<div class="modal-dj-easy-contact-message"></div>
<?php }
			echo '<div class=" ' . $mod_class_suffix . ' '. $is_email_field_on . '"><form class="easy-contact-form form-validate" action="'.JFactory::getURI().'" method="post">' . "\n";
			echo '<span class="dj-simple-contact-form-introtext">'.$introtext.'</span>';
			
			
			if ($error_message != '') {
			  print $error_message;
			}
			if($style_file != '5'){
				$placeholder_name = "placeholder='".JText::_('MOD_DJ_EASYCONTACT_NAME_LABEL')."'";
				$placeholder_email = "placeholder='".JText::_('MOD_DJ_EASYCONTACT_EMAIL_LABEL')."'";
				$placeholder_message = "placeholder='".$message_label."'";
			} else {
				$placeholder_name = "";
				$placeholder_email = "";
				$placeholder_message = "";
			}

			
			echo '<div class="contact-form">';
			
			// print name input
			echo '<div class="dj-simple-contact-form-row name">
			<input '.$placeholder_name.' class="dj-simple-contact-form required ' . $mod_class_suffix . '" type="text" name="dj_name" id="dj_name-'.$moduleId.'" value="'.$valid_name.'" required="required" />';
			if($style_file == '5'){
				echo '<span class="highlight"></span>';
				echo '<span class="bar"></span>';
			}
			echo '<label for="dj_name-'.$moduleId.'" style="display: none;">'.JText::_('MOD_DJ_EASYCONTACT_NAME_LABEL').'</label>';
			echo '</div>' . "\n";
			
			// print email input
			if($email_required == 1){
				print '<div class="dj-simple-contact-form-row email">
				<input '.$placeholder_email.' class="dj-simple-contact-form required validate-email ' . $mod_class_suffix . '" type="email" name="dj_email" id="dj_email-'.$moduleId.'" value="'.$valid_email.'" required="required" />';
				if($style_file == '5'){
					echo '<span class="highlight"></span>';
					echo '<span class="bar"></span>';
				}
				echo '<label for="dj_email-'.$moduleId.'" style="display: none;">'.JText::_('MOD_DJ_EASYCONTACT_EMAIL_LABEL').'</label>';
				echo '</div>' . "\n";
			}
			
			// print message input
			if($message_type == 1){
				echo '<div class="dj-simple-contact-form-row message">
				<textarea '.$placeholder_message.' class="dj-simple-contact-form required ' . $mod_class_suffix . '" name="dj_message" id="dj_message-'.$moduleId.'" cols="4" rows="5" required="required">'.$valid_message.'</textarea>';
				if($style_file == '5'){
					echo '<span class="highlight"></span>';
					echo '<span class="bar"></span>';
				}
				echo '<label for="dj_message-'.$moduleId.'" style="display: none;">'.$message_label.'</label>';
				echo '</div>' . "\n";
			} else {
				print '<div class="dj-simple-contact-form-row message">
				<input '.$placeholder_message.' class="dj-simple-contact-form required ' . $mod_class_suffix . '" type="text" name="dj_message" id="dj_message-'.$moduleId.'" value="'.$valid_message.'" required="required" />';
				if($style_file == '5'){
					echo '<span class="highlight"></span>';
					echo '<span class="bar"></span>';
				}
				echo '<label for="dj_message-'.$moduleId.'" style="display: none;">'.$message_label.'</label>';
				echo '</div>' . "\n";
			}
			
			//print anti-spam
			if ($enable_anti_spam && $recaptcha_site_key && $recaptcha_secret_key) {
			    print "<div class='captcha-box'><div class='g-recaptcha' data-sitekey=".$recaptcha_site_key."></div></div>";
			}
			
			// print button
			if($style_file == '5'){
				print '<div class="button-box"><button class="dj-simple-contact-form button validate ' . $mod_class_suffix . '"><span>'.JText::_('MOD_DJ_EASYCONTACT_BUTTON_LABEL').'</span></button></div></div></form></div>' . "\n";
			} else {
				print '<div class="button-box"><button class="btn btn-default col-xs-12 col-sm-6 col-sm-offset-3 ' . $mod_class_suffix . '" type="submit" ><span>'.JText::_('MOD_DJ_EASYCONTACT_BUTTON_LABEL').'</span></button></div></div></form></div>' . "\n";
			}

		if($style_file == '5'){ ?>
				</div>
			</div>
			<button href="#modal-dj-easy-contact-box" role="button" class="btn btn-default col-xs-12 col-sm-6 col-sm-offset-3" data-toggle="modal"><span>&nbsp;</span></button>
		<?php } ?>

<?php if ($enable_anti_spam) { ?>
	<script src='https://www.google.com/recaptcha/api.js'></script>
<?php } ?>