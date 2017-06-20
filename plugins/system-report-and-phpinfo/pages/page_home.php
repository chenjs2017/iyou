<?php

class MDT_Page_Home extends MDT_Page
{
	public function __construct()
	{
		$this->title='Matt\'s Dev Tools';
	}

	public function page()
	{

		$this->page_start();
		echo $this->page_data();
		$this->page_end('');
	}

	public function page_data()
	{
		$mdt = Matts_Developer_Tools::get_instance();
		ob_start();
		?>
		<div id="welcome-panel" class="welcome-panel">
			<div class="welcome-panel-content">
				<h2>
					<?php _e('Welcome to Matt\'s Developer Tools!','matts-developer-tools');?>
				</h2>

				<p class="about-description">
					<?php _e('Use the tabs on top to use the available functions:','matts-developer-tools');?>
				</p>
				<?php
				foreach($mdt->pages_config as $page) {
					if('home' == $page) { continue; }
					?>
					<p>
					<h3>
						<a href="<?php menu_page_url( 'mdt_'.$page);?>"><?php echo $mdt->pages[$page]->title;?></a>
					</h3>
					<?php echo $mdt->pages[$page]->description;?>
					</p>
					<?php
				}
				?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	public static function mdt_buttons($buttons)
	{
		return array();
	}
}

// EOFpage_phpinfo.php