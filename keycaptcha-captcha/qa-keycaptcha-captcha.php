<?php


	if (!defined('QA_VERSION')) { 
		header('Location: ../');
		exit;
	}


	class qa_keycaptcha_captcha {
	
		var $directory;
		
		function load_module($directory, $urltoroot)
		{
			$this->directory=$directory;
		}


		function admin_form()
		{
			$saved=false;
			
			if (qa_clicked('keycaptcha_save_button')) {
				qa_opt('keycaptcha_private_key', qa_post_text('keycaptcha_private_key_field'));
				qa_opt('keycaptcha_custom_text', qa_post_text('keycaptcha_custom_text_field'));				
				$saved=true;
			}
			
			$form=array(
				'ok' => $saved ? 'KeyCAPTCHA settings saved' : null,
				
				'fields' => array(
					'private' => array(
						'label' => 'KeyCAPTCHA private key:',
						'value' => qa_opt('keycaptcha_private_key'),
						'tags' => 'name="keycaptcha_private_key_field"',
						'error' => $this->keycaptcha_error_html(),
					),
					'text' => array(
						'label' => 'Custom text over KeyCAPTCHA:',
						'value' => qa_opt('keycaptcha_custom_text'),
						'tags' => 'name="keycaptcha_custom_text_field"',
					),
					
				),

				'buttons' => array(
					array(
						'label' => 'Save Changes',
						'tags' => 'name="keycaptcha_save_button"',
					),
				),
			);
			
			return $form;
		}
		

		function keycaptcha_error_html()
		{
			if (!strlen(trim(qa_opt('keycaptcha_private_key'))))  {
				return 'To use KeyCAPTCHA, you must <a href="https://keycaptcha.com/">sign up</a> to get private key.';
			}
			return null;				
		}
	
	
		function allow_captcha()
		{
			return strlen(trim(qa_opt('keycaptcha_private_key')));
		}

		
		function form_html(&$qa_content, $error)
		{
			require_once $this->directory.'keycaptcha_class.php';
			$kc_o = new KeyCAPTCHA_CLASS(qa_opt('keycaptcha_private_key'));
			$kc_tmpl = qa_opt('keycaptcha_custom_text').'<input type= hidden name="capcode" id="capcode" value="123">'.$kc_o->render_js();
			return $kc_tmpl;
		}


		function validate_post(&$error)
		{
			if (!empty($_POST['capcode'])) {
				require_once $this->directory.'keycaptcha_class.php';
				
				$kc_o = new KeyCAPTCHA_CLASS(qa_opt('keycaptcha_private_key'));
				if ($kc_o->check_result($_POST['capcode']))
					return true;

				$error='Wrong CAPTCHA! please try again.';
			}
			
			return false;
		}
	
	}
	

/*
	Omit PHP closing tag to help avoid accidental output
*/