<?php do_action( 'deep_admin_dashboard' ); ?>
	<div id="webnus-dashboard" class="wrap about-wrap">
		<div class="welcome-content w-clearfix extra">
			<div class="w-row">
				<div class="deep-docs-search">
					<span><i class="ti-search"></i></span>
					<form action="https://webnus.net/deep-premium-wordpress-theme-documentation/" target="_blank">
						<input class="deep-search-input" placeholder="Search for answers.." name="s"
						title="Search" autocomplete="off" autocapitalize="off" autocorrect="off" 0="" type="text">
					</form>
				</div>
			</div>
			<div class="w-row">
				<div class="w-col-sm-4">
					<div class="deep-category-box">
						<h4>Options</h4>
						<ul>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/general/" target="_blank">General</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/footer/" target="_blank">Footer</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/pages/" target="_blank">Pages</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/styling/" target="_blank">Styling</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/typography/" target="_blank">Typography</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/maintenance-mode/" target="_blank">Maintenance
									Mode</a></li>
						</ul>
					</div>
				</div>
				<div class="w-col-sm-4">
					<div class="deep-category-box">
						<h4>Header</h4>
						<ul>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/header-builder/" target="_blank">Header
									Builder</a></li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/import-pre-defined-headers/" target="_blank">Pre-defined
									Headers</a></li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/header-elements/" target="_blank">Header
									Elements</a></li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/responsive-options/" target="_blank">Responsive</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/create-menu-with-header-builder/" target="_blank">Menu</a>
							</li>
							<li> <a href="https://webnus.net/deep-premium-wordpress-theme-documentation/mega-menu/" target="_blank">Mega
									Menu</a></li>
						</ul>
					</div>
				</div>
				<div class="w-col-sm-4">
					<div class="deep-category-box" style="min-height: 264px;">
						<h4>Blog</h4>
						<ul>
							<li> <a href="https://webnus.net/deep-premium-wordpress-theme-documentation/post-options/" target="_blank">Post
									Options</a></li>
							<li> <a href="https://webnus.net/deep-premium-wordpress-theme-documentation/blog-options/" target="_blank">Blog
									Options</a></li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/sidebars/" target="_blank">Sidebars</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/blog-magazine-shortcodes/" target="_blank">Blog
									& Magazine Shortcodes</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="w-col-sm-4">
					<div class="deep-category-box">
						<h4>Installation</h4>
						<ul>
							<li> <a href="https://webnus.net/deep-premium-wordpress-theme-documentation/install-deep-theme/" target="_blank">Installing Deep Theme</a></li>
							<li> <a href="https://webnus.net/deep-premium-wordpress-theme-documentation/plugins-installation/" target="_blank">Installing Plugins</a></li>
							<li> <a href="https://webnus.net/deep-premium-wordpress-theme-documentation/import-demo/" target="_blank">Importing Demo</a></li>
						</ul>
					</div>
				</div>
				<div class="w-col-sm-4">
					<div class="deep-category-box">
						<h4>Footer</h4>
						<ul>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/footer/" target="_blank">Footer</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/widgets/" target="_blank">Widgets</a>
							</li>
							<li> <a
									href="https://webnus.net/deep-premium-wordpress-theme-documentation/footer-builder/" target="_blank">Footer
									Builder</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		wp_enqueue_script(
			'deep-help',
			DEEP_ASSETS_URL . 'js/backend/help.js',
			[],
			DEEP_VERSION,
			true
		);

		wp_enqueue_script(
			'freshworks',
			'https://widget.freshworks.com/widgets/47000002173.js',
			[],
			DEEP_VERSION,
			true
		);
	?>
<?php do_action( 'deep_admin_dashboard_end' ); ?>