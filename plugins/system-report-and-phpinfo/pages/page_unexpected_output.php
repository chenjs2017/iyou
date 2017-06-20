<?php

class MDT_Page_Unexpected_Output extends MDT_Page
{
	public $file_extension = 'html';
	public $file_mime = 'text/html';

	public function __construct()
	{
		$this->title 		= 'Unexpected Output';
		$this->description	= __('Catch and debug "Unexpected Output" issues during plugin activation. Exports as HTML file.', 'matts-developer-tools');
	}

	public function page()
	{
		$this->page_start('unexpected_output');
		printf('<div style="width:1500px; max-width:95%%;padding:10px;">%s</div>', $this->page_data());
		$this->page_end();
	}

	public function page_data()
	{
		ob_start();
		if ( count($errors = get_user_option('mdt_plugin_activation_error')) && is_array($errors)) {
			$i=0;
			foreach ($errors as $error) {
				$i++;
			?>
			<div class="welcome-panel">
				<div class="welcome-panel-content">

					<h1><?php printf(__('Error #%s', 'matts-developer-tools'),$i);?></h1>

					<hr/>
					<h2><?php echo __('Output','matts-developer-tools');?></h2>
					<?php echo $error;?>

					<hr/>
					<h2><?php echo __('Raw output','matts-developer-tools');?></h2>
					<pre><?php echo htmlspecialchars($error);?></pre>

				</div>
			</div>
			<?php
			}
		} else {
			?>
			<div class="welcome-panel">
				<div class="welcome-panel-content">
					<div class="center">
						<p>
						<?php _e('No Unexpected Output errors caught so far.', 'matts-developer-tools');?>
						</p>
					</div>
				</div>
			</div>
			<?php
		}
		return ob_get_clean();
	}

	public static function mdt_buttons($buttons)
	{
		ob_start();
		?>
		<form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
			<input type="submit" name="mdt_plugin_activation_error_reset" value="<?php echo __('✕ Clean up', 'wordpress-system-report'); ?>"
				   class="button button-secondary">
		</form>
		<?php
		$buttons['unexpected_output'] = ob_get_clean();
		return $buttons;
	}
}

// EOF