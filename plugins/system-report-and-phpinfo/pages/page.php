<?php

abstract class MDT_Page
{
	public $title = NULL;

	public $file_extension = 'txt';
	public $file_mime = 'text/plain';

	public $menu_slug = 'SLUG';

	public $description = 'Amazing Features Here';

	public function page_start($export_key = '')
	{
		$mdt = Matts_Developer_Tools::get_instance();

		wp_enqueue_style('mdt_common', $mdt::assets_path().'css/common.css');
		?>
		<h2><?php echo __('Matt\'s Developer Tools','wordpress-system-report'); ?></h2>
		<div class="wrap mdt-wrap">
			<h3 class="nav-tab-wrapper wp-clearfix">
			<?php
			foreach($mdt->pages_config as $page) {
				$active = ('mdt_' . $page == $_GET['page']) ? 'nav-tab-active' :'';
				printf('<a href="%s" class="nav-tab %s">%s</a>', menu_page_url( 'mdt_'.$page, FALSE ), $active, $mdt->pages[$page]->title);
			}
			?>
			</h3>

				<?php
				// Export Button
				$mdt_buttons = array();
				ob_start();
				?>
				<form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
					<input type="hidden" name="export_content" value="<?php echo $export_key; ?>">
					<input type="hidden" name="system_report_export" value="1">
					<input type="submit" value="<?php echo __('&darr; Export', 'wordpress-system-report'); ?>"
						   class="button button-primary">
				</form>
				<?php
				$mdt_buttons['export'] = ob_get_clean();

				// Reload button
				ob_start();
				?>
				<form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
					<input type="submit" value="<?php echo __('&#8634; Refresh', 'wordpress-system-report'); ?>"
						   class="button button-secondary">
				</form>
				<?php
				$mdt_buttons['reload'] = ob_get_clean();

				$mdt_buttons = apply_filters('mdt_buttons', $mdt_buttons);

				if(count($mdt_buttons)) {
					printf('<div class="mdt-action-buttons">%s</div>', implode(' ', $mdt_buttons));
				}
	}

	public function page_end()
	{
		?>
		</div>
		<div class="center">
			<?php echo __('Developed with love at <a href="http://mattsplugins.io" target="_blank">Matt\'s plugins</a> by <a href="http://jwr.sk" target="_blank">Matt Jaworski</a>.','matts-developer-tools');?>
		</div>
		<?php
	}

	public static function mdt_buttons($buttons){
		return $buttons;
	}

	abstract public function page();

	abstract public function page_data();
}