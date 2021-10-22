<?php
/**
 * Provide a admin area view for the settings.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @package    Wplegalpages
 * @subpackage Wplegalpages/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$baseurl = '';
if ( isset( $_SERVER['PHP_SELF'] ) ) {
	$baseurl = esc_url_raw( wp_unslash( $_SERVER['PHP_SELF'] ) );
}

if ( isset( $_POST['lp_submit'] ) && 'Accept' === $_POST['lp_submit'] ) {
	check_admin_referer( 'lp-submit-accept-terms' );
	update_option( 'lp_accept_terms', isset( $_POST['lp_accept_terms'] ) ? sanitize_text_field( wp_unslash( $_POST['lp_accept_terms'] ) ) : '' );
}

?>
<div class="wrap">
<?php
wp_enqueue_script( 'jquery' );
$lp_pro_active     = get_option( '_lp_pro_active' );
$lpterms           = get_option( 'lp_accept_terms' );
$lp_pro_installed  = get_option( '_lp_pro_installed' );
$lp_footer_options = get_option( 'lp_footer_options' );
if ( false === $lp_footer_options || empty( $lp_footer_options ) ) {
	$lp_footer_options = array(
		'footer_legal_pages' => '',
		'show_footer'        => '0',
		'footer_bg_color'    => '#ffffff',
		'footer_text_align'  => 'center',
		'footer_separator'   => '',
		'footer_new_tab'     => '0',
		'footer_text_color'  => '#333333',
		'footer_link_color'  => '#333333',
		'footer_font'        => 'Open Sans',
		'footer_font_id'     => 'Open+Sans',
		'footer_font_size'   => '16',
		'footer_custom_css'  => '',
	);
	update_option( 'lp_footer_options', $lp_footer_options );
}
if ( '1' === $lpterms ) {
	?>
	<?php if ( '1' !== $lp_pro_installed ) : ?>
	<div style="">
		<div style="line-height: 2.4em;" class='wplegalpages-pro-promotion'>
			<a href="https://club.wpeka.com/product/wplegalpages/?utm_source=legalpages%20lite%20banner&utm_campaign=legal%20pages%20lite%20banner&utm_medium=banner" target="_blank">
				<img alt="Upgrade to Pro" src="<?php echo esc_url_raw( WPL_LITE_PLUGIN_URL ) . 'admin/images/upgrade-to-pro.jpg'; ?>">
			</a>
		</div>
		<h4>
		<?php
		echo sprintf(
			/* translators: %s: Club link */
			esc_html__( 'WPLegalPages is also available as a part of %s Membership with 20+ more premium WordPress products.', 'wplegalpages' ),
			sprintf(
			/* translators: %s: Club link */
				'<a href="%s" target="_blank">WPEka Club</a>',
				esc_url( 'https://club.wpeka.com/' )
			)
		);
		?>
		</h4>
<!--		<h4>WPLegalPages is also available as a part of <a href="https://club.wpeka.com/" target="_blank">WPEka Club</a> <h4>-->
	</div>
	<div style="clear:both;"></div>
		<?php endif; ?>
	<div id="WP-Feedback-legal-pages" align="center"></div>
	<?php
	if ( get_option( 'wplegalpages_pro_version' ) && version_compare( get_option( 'wplegalpages_pro_version' ), '8.2.0' ) < 0 ) {
		if ( ! empty( $_POST ) && isset( $_POST['lp-greset'] ) ) :

			$lp_general = array(
				'domain'       => '',
				'business'     => '',
				'phone'        => '',
				'street'       => '',
				'cityState'    => '',
				'country'      => '',
				'email'        => '',
				'address'      => '',
				'niche'        => '',
				'privacy'      => '',
				'privacy_page' => '',
				'pagefooter'   => '',
				'generate'     => '',
			);

			update_option( 'lp_general', $lp_general );

			?>
			<div id="message">
			<p><span class="label label-success myAlert"><?php esc_attr_e( 'Settings Reset.', 'wplegalpages' ); ?></span></p>
		</div>
			<?php
		endif;
		if ( ! empty( $_POST ) && isset( $_POST['lp-gsubmit'] ) ) :


			$lp_general = array(
				'domain'    => isset( $_POST['lp-domain-name'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-domain-name'] ) ) : '',
				'business'  => isset( $_POST['lp-business-name'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-business-name'] ) ) : '',
				'phone'     => isset( $_POST['lp-phone'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-phone'] ) ) : '',
				'street'    => isset( $_POST['lp-street'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-street'] ) ) : '',
				'cityState' => isset( $_POST['lp-city-state'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-city-state'] ) ) : '',
				'country'   => isset( $_POST['lp-country'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-country'] ) ) : '',
				'email'     => isset( $_POST['lp-email'] ) ? sanitize_email( wp_unslash( $_POST['lp-email'] ) ) : '',
				'address'   => isset( $_POST['lp-address'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-address'] ) ) : '',
				'niche'     => isset( $_POST['lp-niche'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-niche'] ) ) : '',
				'generate'  => isset( $_POST['lp-generate'] ) ? sanitize_text_field( wp_unslash( $_POST['lp-generate'] ) ) : '',
			);
			$lp_general = apply_filters( 'wplegalpages_save_settings', $lp_general, $_POST );
			update_option( 'lp_general', $lp_general );
			?>
		<div id="message">
			<p><span class="label label-success myAlert"><?php esc_attr_e( 'Settings Saved.', 'wplegalpages' ); ?></span></p>
		</div>
			<?php
		endif;
	}
	$checked    = 'checked="checked"';
	$selected   = 'selected="selected"';
	$lp_general = get_option( 'lp_general' );
	if ( ! isset( $wpgattack ) ) {
		global $wpgattack;
	}
	?>
	<?php
	if ( get_option( 'wplegalpages_pro_version' ) && version_compare( get_option( 'wplegalpages_pro_version' ), '8.2.0' ) < 0 ) {
		if ( $lp_pro_active ) {
			?>
			<div class="postbox legalpages-settings" style="min-height:1240px!important;">
		<?php } else { ?>
			<div class="postbox legalpages-settings">
			<?php
		}
		?>

	<h3 class="hndle myLabel-head"  style="cursor:pointer; padding:7px 10px; font-size:20px;"> <?php esc_attr_e( 'General', 'wplegalpages' ); ?> </h3>
	<div id="lp_admin_generalid">
	<table align="center"><tr>
	<td style="width:65%">


	<form name="glegal" method="post" action="" enctype="">
		<table cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td></td><td></td><td><b class="hndle myLabel"><?php esc_attr_e( 'Shortcodes(Use as placeholder)', 'wplegalpages' ); ?></b></td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'Domain Name:', 'wplegalpages' ); ?></b></td><td><input type="text" name="lp-domain-name" value="<?php echo ! empty( $lp_general['domain'] ) ? esc_attr( $lp_general['domain'] ) : esc_url_raw( get_bloginfo( 'url' ) ); ?>" /></td><td>[Domain]</td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'Business Name:', 'wplegalpages' ); ?></b></td><td><input type="text" name="lp-business-name" value="<?php echo ! empty( $lp_general['business'] ) ? esc_attr( $lp_general['business'] ) : ''; ?>" /></td><td>[Business Name]</td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'Phone:', 'wplegalpages' ); ?></b></td><td><input type="text" size="30" name="lp-phone" value="<?php echo ! empty( $lp_general['phone'] ) ? esc_attr( $lp_general['phone'] ) : ''; ?>" /></td><td>[Phone]</td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'Street:', 'wplegalpages' ); ?></b></td><td><input type="text" size="30" name="lp-street" value="<?php echo ! empty( $lp_general['street'] ) ? esc_attr( $lp_general['street'] ) : ''; ?>" /></td><td>[Street]</td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'City, State, Zip code:', 'wplegalpages' ); ?></b></td><td><input type="text" size="30" name="lp-city-state" value="<?php echo ! empty( $lp_general['cityState'] ) ? esc_attr( $lp_general['cityState'] ) : ''; ?>" /></td><td>[City, State, Zip code]</td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'Country:', 'wplegalpages' ); ?></b></td><td><input type="text" size="30" name="lp-country" value="<?php echo ! empty( $lp_general['country'] ) ? esc_attr( $lp_general['country'] ) : ''; ?>" /></td><td>[Country]</td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'Email:', 'wplegalpages' ); ?></b></td><td><input type="text" size="30" name="lp-email" value="<?php echo ! empty( $lp_general['email'] ) ? esc_attr( $lp_general['email'] ) : esc_attr( get_option( 'admin_email' ) ); ?>" /></td><td>[Email]</td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'Address:', 'wplegalpages' ); ?></b></td><td><input type="text" size="30" name="lp-address" value="<?php echo ! empty( $lp_general['address'] ) ? esc_attr( $lp_general['address'] ) : ''; ?>" /></td><td>[Address]</td>
			</tr>
			<tr>
				<td><b><?php esc_attr_e( 'Niche:', 'wplegalpages' ); ?></b></td> <td><input type="text" size="30" name="lp-niche" value="<?php echo ! empty( $lp_general['niche'] ) ? esc_attr( $lp_general['niche'] ) : ''; ?>" /></td> <td>[Niche]</td>
			</tr>
			<?php do_action( 'wplegalpages_admin_settings', $lp_general ); ?>
			<tr>
				<td><b><?php esc_attr_e( 'Give Credit:', 'wplegalpages' ); ?></b></td>
				<td><label class="switch"><input type="checkbox" <?php echo ( isset( $lp_general['generate'] ) && '1' === $lp_general['generate'] ) ? 'checked="checked"' : ''; ?> name="lp-generate" value="1" >
						<div class="slider round"></div>
					</label>
				</td>
			</tr>
			<tr align="center">
				<td colspan="3"><input type="submit" name="lp-gsubmit" class="btn btn-primary" value="<?php esc_attr_e( 'Save', 'wplegalpages' ); ?>" /> <input type="submit" class="btn btn-primary" name="lp-greset" value="<?php esc_attr_e( 'Reset', 'wplegalpages' ); ?>" /></td>
			</tr>
		</table>
		</form>


	</td>
	</tr></table>
	</div>
</div>
<div class='lp-pro-link'>
	<a href="<?php echo esc_url( $baseurl ); ?>?page=lp-create-page"><h3 class="hndle"  style="cursor:pointer; padding:7px 10px; font-size:20px;"><?php esc_attr_e( 'Click Here to Create Legal Pages &raquo;', 'wplegalpages' ); ?></h3></a>
</div>
		<?php
	} else {
		?>
	<div id="app" v-cloak>
	<div class="adc-nav">
		<div class="adc-nav-inner">
			<div class="adc-logo"></div>
		</div>
	</div>

	<div id="wplegalpages-save-settings-alert">Settings saved</div>
	<c-tabs ref="active_tab" id="wplegalpages_tabs">

		<c-tab class = "wplegalpages-nav-menu-item" title="<?php esc_attr_e( 'General', 'wplegalpages' ); ?>" active href="#general">

			<?php do_action( 'wp_legalpages_notice' ); ?>
			<c-card class="wplegalpages-table-card">
				<c-card-body class="wplegalpages-table-card-body">
					<div id="lp_admin_generalid" class="lp_settings_table">


							<table class="wplegalpages-settings-table" cellpadding="5" cellspacing="0" border="0">
								<tr>
									<td></td><td></td><td><b class="hndle shortcode-label"><?php esc_attr_e( 'Shortcodes', 'wplegalpages' ); ?><p><?php esc_attr_e( '(Use as a placeholder)', 'wplegalpages' ); ?></p></b></td>
								</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'Domain Name', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Enter your website URL', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td><td><c-input class="wplegalpages-settings-input" type="text" name="lp-domain-name" value="<?php echo ! empty( $lp_general['domain'] ) ? esc_attr( $lp_general['domain'] ) : esc_url_raw( get_bloginfo( 'url' ) ); ?>"></c-input><td class="wplegalpages-settings-shortcode">[Domain]</td>
									</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'Business Name', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Enter your Legal business name', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td><td><c-input class="wplegalpages-settings-input" type="text" name="lp-business-name" value="<?php echo ! empty( $lp_general['business'] ) ? esc_attr( $lp_general['business'] ) : ''; ?>"></c-input></td><td class="wplegalpages-settings-shortcode">[Business Name]</td>
								</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'Phone', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Certain policies like CCPA require your contact details', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td><td><c-input class="wplegalpages-settings-input" type="text"  name="lp-phone" value="<?php echo ! empty( $lp_general['phone'] ) ? esc_attr( $lp_general['phone'] ) : ''; ?>"></c-input></td><td class="wplegalpages-settings-shortcode">[Phone]</td>
								</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'Street', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Certain policies like CCPA require your contact details ', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td><td><c-input class="wplegalpages-settings-input" type="text" name="lp-street" value="<?php echo ! empty( $lp_general['street'] ) ? esc_attr( $lp_general['street'] ) : ''; ?>"></c-input></td><td class="wplegalpages-settings-shortcode">[Street]</td>
								</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'City, State, Zip code', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Certain policies like CCPA require your contact details', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td><td><c-input class="wplegalpages-settings-input" type="text"  name="lp-city-state" value="<?php echo ! empty( $lp_general['cityState'] ) ? esc_attr( $lp_general['cityState'] ) : ''; ?>"></c-input></td><td class="wplegalpages-settings-shortcode">[City, State, Zip code]</td>
								</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'Country', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Certain policies like CCPA require your contact details', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td><td><c-input class="wplegalpages-settings-input" type="text" name="lp-country" value="<?php echo ! empty( $lp_general['country'] ) ? esc_attr( $lp_general['country'] ) : ''; ?>"></c-input></td><td class="wplegalpages-settings-shortcode">[Country]</td>
								</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'Email', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Certain policies like CCPA require your contact details', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td><td><c-input class="wplegalpages-settings-input" type="text"  name="lp-email" value="<?php echo ! empty( $lp_general['email'] ) ? esc_attr( $lp_general['email'] ) : esc_attr( get_option( 'admin_email' ) ); ?>" ></c-input></td><td class="wplegalpages-settings-shortcode">[Email]</td>
								</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'Address', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Certain policies like CCPA require your contact details', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td><td><c-input class="wplegalpages-settings-input"type="text" name="lp-address" value="<?php echo ! empty( $lp_general['address'] ) ? esc_attr( $lp_general['address'] ) : ''; ?>"></c-input></td><td class="wplegalpages-settings-shortcode">[Address]</td>
								</tr>
								<tr>
									<td class="wplegalpages-settings-label"><b><?php esc_attr_e( 'Niche', 'wplegalpages' ); ?></b>
									<c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( ' Fill the general niche of your business', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon>
								</td> <td><c-input class="wplegalpages-settings-input" type="text" name="lp-niche" value="<?php echo ! empty( $lp_general['niche'] ) ? esc_attr( $lp_general['niche'] ) : ''; ?>"></c-input></td> <td class="wplegalpages-settings-shortcode">[Niche]</td>
								</tr>
								<?php do_action( 'wplegalpages_admin_settings', $lp_general ); ?>

								<tr align="center">
								</tr>					
						</table>
					</div>	
				</c-card-body>
			</c-card>				
		</c-tab>
		<?php do_action( 'wp_legalpages_after_general_tab' ); ?>
		<?php do_action( 'wp_legalpages_after_data_tab' ); ?>
		<c-tab class = "wplegalpages-nav-menu-item" title="<?php esc_attr_e( 'Compliances', 'wplegalpages' ); ?>" href="#features">
			<div class="wplegalpages-additonal-features-tab">
			<c-card>
				<c-card-header class="wplegalpages-settings-card-heading"><?php esc_html_e( 'Add Legal Pages Link to the Footer', 'wplegalpages' ); ?></c-card-header>
				<c-card-body>
					<div class="wplegalpages-additional-features-descripiton">
						<p class="wplegalpages-additonal-features-card-description"><?php esc_html_e( 'Display links to your legal pages in the footer section of your website.', 'wplegalpages' ); ?></p>
					</div>
					<div class="wplegalpages-additional-features-buttons">
					<c-button class="wplegalpages_settings_enable_button" @click="onClickFooter">
						<span class="wplegalpages_settings_button_text" v-show="is_footer"><?php esc_attr_e( 'Disable' ); ?></span>
						<span class="wplegalpages_settings_button_text" v-show="!is_footer"><?php esc_attr_e( 'Enable' ); ?></span>
					</c-button>
					<c-button class="wplegalpages_settings_configure_button" @click="showFooterForm">
						<span class="wplegalpages_settings_button_text"><?php esc_attr_e( 'Configure' ); ?></span>
					</c-button>
					</div>
					<input type="hidden" name="lp-footer" ref="footer" v-model="is_footer">	
				</c-card-body>
			</c-card>
			<c-card>
				<c-card-header class="wplegalpages-settings-card-heading"><?php esc_html_e( 'Announcement Banner for Legal Pages', 'wplegalpages' ); ?></c-card-header>
				<c-card-body>
					<div class="wplegalpages-additional-features-descripiton">
						<p class="wplegalpages-additonal-features-card-description"><?php esc_html_e( 'Display announcement banners on your website whenever any legal pages have been updated.', 'wplegalpages' ); ?></p>
					</div>
					<div class="wplegalpages-additional-features-buttons">
					<c-button class="wplegalpages_settings_enable_button" @click="onClickBanner">
						<span class="wplegalpages_settings_button_text" v-show="is_banner"><?php esc_attr_e( 'Disable' ); ?></span>
						<span class="wplegalpages_settings_button_text" v-show="!is_banner"><?php esc_attr_e( 'Enable' ); ?></span>
					</c-button>
					<c-button class="wplegalpages_settings_configure_button"  @click="showBannerForm">
						<span class="wplegalpages_settings_button_text"><?php esc_attr_e( 'Configure' ); ?></span>
					</c-button>
					</div>
					<input type="hidden" name="lp-banner" ref="banner" v-model="is_banner">
				</c-card-body>
			</c-card>
			<?php // do_action( 'wplegalpages_compliances_settings' ); ?>
			</div>
			<div id="wplegalpages-form-modal-footer-form">
				<div class="wplegalpages-form-modal-dialog">
					<div class="wplegalpages-form-modal-navbar">
						<span class="wplegalpages-form-modal-title"><?php esc_html_e( 'Add Legal Pages Link to the Footer', 'wplegalpages' ); ?></span>
						<span class="wplegalpages-form-modal-close" @click="showFooterForm">X</span>
					</div>
					<div class="wplegalpages-form-modal-content">
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-show-footer"><?php esc_html_e( 'Enabled', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Add Privacy Policy links to the footer.', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<c-switch  class="wplegalpages-form-modal-switch" ref="switch_footer" v-model="is_footer" id="wplegalpages-show-footer" variant="3d" size="sm" color="dark" :checked="is_footer" v-on:update:checked="onSwitchFooter"></c-switch>
							<input type="hidden" name="lp-is-footer" v-model="is_footer">
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-footer-page"><?php esc_html_e( 'Legal Pages', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the Legal Pages you want to add to the footer.', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							<input type="hidden" ref="footer_legal_pages" v-model="footer_legal_pages" name="footer_legal_pages">
							<input type="hidden" ref="footer_legal_pages_mount" value="<?php echo esc_html( stripslashes( $lp_footer_options['footer_legal_pages'] ) ); ?>">
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<v-select id="wplegalpages-footer-pages" :options="page_options" multiple v-model="footer_legal_pages"  >
							</v-select>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-footer-bgcolor"><?php esc_html_e( 'Background Color', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the background color for the footer section', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<colorpicker class="wplegalpages-input-color-picker" id="wplegalpages-footer-bgcolor" :color="link_bg_color" v-model="link_bg_color" />
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-footer-font"><?php esc_html_e( 'Font', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the font', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<font-picker class="wplegalpages-font-picker" id="wplegalpages-footer-font" :api-key="apiKey"  :active-font="footer_font" @change="onFooterFont"></font-picker>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-footer-font-size"><?php esc_html_e( 'Font Size', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'ASelect the Font size for the footer section', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							<input type="hidden" ref="footer_font_size" v-model="footer_font_size" name="lp-footer-font-size">
							<input type="hidden" ref="footer_font_size_mount" value="<?php echo esc_html( stripslashes( $lp_footer_options['footer_font_size'] ) ); ?>">
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<v-select id="wplegalpages-footer-font-size" :options="font_size_options" v-model="footer_font_size">
							</v-select>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-footer-text-color"><?php esc_html_e( 'Text Color', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the color for the text', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<colorpicker class="wplegalpages-input-color-picker" id="wplegalpages-footer-text-color" :color="footer_text_color" v-model="footer_text_color"></colorpicker>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-footer-align"><?php esc_html_e( 'Text Alignment', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the text alignment', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							<input type="hidden" ref="footer_text_align" v-model="footer_text_align" name="lp-footer-text-align">
							<input type="hidden" ref="footer_text_align_mount" value="<?php echo esc_html( stripslashes( $lp_footer_options['footer_text_align'] ) ); ?>">
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<v-select id="wplegalpages-footer-align" :options="footer_align_options" v-model="footer_text_align">
							</v-select>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-footer-link-color"><?php esc_html_e( 'Link Color', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the color for links in the footer', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<colorpicker class="wplegalpages-input-color-picker" id="wplegalpages-footer-link-color" :color="footer_link_color" v-model="footer_link_color"></colorpicker>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-lp-form-separator"><?php esc_html_e( 'Links Separator', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'Select link separator element', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<c-input id="wplegalpages-lp-form-separator" type="text" name="lp-footer-separator" value="<?php echo esc_html( $lp_footer_options['footer_separator'] ); ?>"></c-input>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-footer-new-tab"><?php esc_html_e( 'Open Link in New Tab', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Enable if you want to open links in the new Tab', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<c-switch  class="wplegalpages-form-modal-switch" ref="footer_new_tab" v-model="footer_new_tab" id="wplegalpages-footer-new-tab" variant="3d" size="sm" color="dark" :checked="footer_new_tab" v-on:update:checked="onClickNewTab"></c-switch>
							<input type="hidden" name="lp-footer-new-tab" v-model="footer_new_tab">
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-lp-form-separator"><?php esc_html_e( 'Additional CSS', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'You can add CSS to change the style of the footer.', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<div id="wplegal-pages-form-css-editor">
								<vue-editor id="wplegalpages-lp-footer-custom-css" :editor-toolbar="customToolbarForm" v-model="footer_custom_css"></vue-editor>
								</div>
								<p class="wplegalpages-custom-css-heading">Available CSS Selectors</p>
								<p class="wplegalpages-custom-css-selector">Container ID's: <span class="wplegalpages-custom-css-links" @click="addContainerID">#wplegalpages_footer_links_container</span></p>
								<p class="wplegalpages-custom-css-selector">Links class: <span class="wplegalpages-custom-css-links" @click="addLinksClass">.wplegalpages_footer_link</span></p>
								<p class="wplegalpages-custom-css-selector">Text class: <span class="wplegalpages-custom-css-links" @click="addTextClass">.wplegalpages_footer_separator_text</span></p>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-footer-order-links"><?php esc_html_e( 'Links Order', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Drag to reorder the links.', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<draggable id="wplegalpages-footer-order-links" v-model="footer_legal_pages">
								<div class="wplegalpages-draggable-item" v-for="footer_page in footer_legal_pages" :key="footer_page">{{footer_page}}</div>
							</draggable>
							</div>
						</div>
						<input type="hidden" id="wplegalpages-footer-form-nonce" name="lp-footer-form-nonce" value="<?php echo wp_create_nonce( 'settings_footer_form_nonce' ); ?>"/>
						<div class="wplegalpages-form-modal-buttons">
							<c-button @click="showFooterForm" class="wplegalpages-form-modal-save-button" color="info" id="wplegalpages-footer-form-submit">Save</c-button>
							<c-button @click="showFooterForm" class="wplegalpages-form-modal-cancel-button" color="danger" id="wplegalpages-footer-form-submit">Cancel</c-button>
						</div>
					</div>
				</div>
			</div>
			<div id="wplegalpages-announcement-popup-form">
				<div class="wplegalpages-form-modal-dialog">
					<div class="wplegalpages-form-modal-navbar">
						<span class="wplegalpages-form-modal-title"><?php esc_html_e( 'Show Announcement Banner', 'wplegalpages' ); ?></span>
						<span class="wplegalpages-form-modal-close" @click="showBannerForm">X</span>
					</div>
					<div class="wplegalpages-form-modal-content">
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-show-footer" ><?php esc_attr_e( 'Enable', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Show announcement bar after any privacy policy is changed', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<c-switch class="wplegalpages-form-modal-switch" ref="switch_banner" v-model="is_banner" id="wplegalpages-show-footer" variant="3d" size="sm" color="dark" :checked="is_banner" v-on:update:checked="onSwitchBanner"></c-switch>
								<input type="hidden" name="lp-is-banner" v-model="is_banner">
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-bar-position"><?php esc_attr_e( 'Announcement Bar Position', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the Announcement Bar Position', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
								<input type="hidden" ref="bar_position" v-model="bar_position" name="lp-bar-position">
								<input type="hidden" ref="bar_position_mount" value="<?php echo esc_html( stripslashes( isset( $lp_banner_options['bar_position'] ) ? $lp_banner_options['bar_position'] : '' ) ); ?>">
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<v-select id="wplegalpages-bar-position" :options="bar_position_options" v-model="bar_position"></v-select>
							</div>
						</div>
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-bar-type"><?php esc_attr_e( 'Announcement Bar type', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the Announcement bar type', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
								<input type="hidden" ref="bar_type" v-model="bar_type" name="lp-bar-type">
								<input type="hidden" ref="bar_type_mount" value="<?php echo esc_html( stripslashes( isset( $lp_banner_options['bar_type'] ) ? $lp_banner_options['bar_type'] : '' ) ); ?>">
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<v-select id="wplegalpages-bar-type" :options="bar_type_options" v-model="bar_type"></v-select>
							</div>
						</div>

						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-bar-expiry"><?php esc_attr_e( 'Announcement Duration', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select how long to show the announcement after any privacy policy is changed', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
								<input type="hidden" ref="bar_num_of_days" v-model="bar_num_of_days" name="lp-bar-num-of-days">
								<input type="hidden" ref="bar_num_of_days_mount" value="<?php echo esc_html( stripslashes( isset( $lp_banner_options['bar_num_of_days'] ) ? $lp_banner_options['bar_num_of_days'] : '1' ) ); ?>">
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<v-select id="wplegalpages-bar-expiry" :options="banner_number_of_days" v-model="bar_num_of_days">
							</div>
						</div>

						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-lp-banner-message"><?php esc_html_e( 'Message', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Message that will be displayed when single privacy policy page is changed', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<div id="wplegal-pages-banner-message-editor">
								<vue-editor id="wplegalpages-lp-banner-message" :editor-toolbar="customToolbar" v-model="banner_message"></vue-editor>
								</div>
								<p class="wplegalpages-custom-css-selector">Insert Shortcodes 
								<span class="wplegalpages-custom-css-links" @click="addBannerPageCode">title</span>
								<span class="wplegalpages-custom-css-links" @click="addBannerPageLinkTitle">link</span>
								<span class="wplegalpages-custom-css-links" @click="addBannerPageHref">href</span>
								<span class="wplegalpages-custom-css-links" @click="addBannerPageLed">last effective date</span>
								</p>
								<p class="wplegalpages-custom-css-selector">You can also
								<span class="wplegalpages-custom-css-links" @click="addBannerDefaultMsg">revert message to default.</span>
								</p>
							</div>
						</div>			
						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-lp-banner-message"><?php esc_html_e( 'Message for multiple updated pages', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Message that will be displayed when multiple privacy policy pages are changed', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<div id="wplegal-pages-banner-message-editor">
								<vue-editor id="wplegalpages-lp-banner-multiple-message" :editor-toolbar="customToolbar" v-model="banner_multiple_message"></vue-editor>
								</div>
								<p class="wplegalpages-custom-css-selector">Insert Shortcodes 
								<span class="wplegalpages-custom-css-links" @click="addBannerMultiplePageCode">titles</span>
								<span class="wplegalpages-custom-css-links" @click="addBannerMultiplePageLinkTitle">link</span>
								<span class="wplegalpages-custom-css-links" @click="addBannerMultiplePageLed">last effective date</span>
								</p>
								<p class="wplegalpages-custom-css-selector">You can also
								<span class="wplegalpages-custom-css-links" @click="addBannerMultipleDefaultMsg">revert message to default.</span>
								</p>
							</div>
						</div>	

						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-banner-close-message"><?php esc_attr_e( 'Close Button', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Edit the text for the close button', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<c-input type="text" name="lp-banner-font-size" id="wplegalpages-banner-close-message" v-model="banner_close_message" value="<?php echo ! empty( $lp_banner_options['banner_close_message'] ) ? esc_attr( $lp_banner_options['banner_close_message'] ) : 'Close'; ?>"></c-input>
							</div>
						</div>

						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-banner-bg-color"><?php esc_attr_e( 'Background Color', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the background color for the announcement bar', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
							<colorpicker id="wplegalpages-banner-bg-color" :color="banner_bg_color" v-model="banner_bg_color" />
							</div>
						</div>

						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-banner-font"><?php esc_attr_e( 'Font', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the font', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<font-picker id="wplegalpages-banner-font"  class="wplegalpages-font-picker" :api-key="apiKey"  :active-font="banner_font" @change="onBannerFont"></font-picker>
							</div>
						</div>

						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-banner-font-size"><?php esc_attr_e( 'Font Size', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the Font size for the announcement bar', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
								<input type="hidden" ref="banner_font_size" v-model="banner_font_size" name="lp-banner-font-size">
								<input type="hidden" ref="banner_font_size_mount" value="<?php echo esc_html( stripslashes( isset( $lp_banner_options['banner_font_size'] ) ? $lp_banner_options['banner_font_size'] : '20px' ) ); ?>">
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<v-select id="wplegalpages-banner-font-size" :options="banner_font_size_option" v-model="banner_font_size">	
							</div>
						</div>


						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-banner-text-color"><?php esc_attr_e( 'Text Color', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the color for the text', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<colorpicker id="wplegalpages-banner-text-color" :color="banner_text_color" v-model="banner_text_color" />
							</div>
						</div>

						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
								<label for="wplegalpages-banner-link-color"><?php esc_attr_e( 'Link Color', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip='"<?php esc_html_e( 'Select the color for links in the announcement bar', 'wplegalpages' ); ?>"' color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<colorpicker id="wplegalpages-banner-link-color" :color="banner_link_color" v-model="banner_link_color" />
							</div>
						</div>

						<div class="wplegalpages-form-modal-input-group">
							<div class="wplegalpages-form-modal-label">
							<label for="wplegalpages-lp-form-separator"><?php esc_html_e( 'Additional CSS', 'wplegalpages' ); ?><c-icon class="wplegalpages-tooltip" v-c-tooltip="'<?php esc_html_e( 'You can add CSS to change the style of the announcement bar', 'wplegalpages' ); ?>'" color="primary" name="cib-google-keep"></c-icon></label>
							</div>
							<div class="wplegalpages-form-modal-inputs">
								<div id="wplegal-pages-banner-css-editor">
								<vue-editor id="wplegalpages-lp-banner-custom-css" :editor-toolbar="customToolbar" v-model="banner_custom_css"></vue-editor>
								</div>
								<p class="wplegalpages-custom-css-heading">Available CSS Selectors</p>
								<p class="wplegalpages-custom-css-selector">Container ID's: <span class="wplegalpages-custom-css-links" @click="addBannerContainerID">.wplegalpages_banner_content</span></p>
								<p class="wplegalpages-custom-css-selector">Links class: <span class="wplegalpages-custom-css-links" @click="addBannerLinksClass">.wplegalpages_banner_link</span></p>
							</div>
						</div>
						<input type="hidden" id="wplegalpages-banner-form-nonce" name="lp-footer-banner-nonce" value="<?php echo wp_create_nonce( 'settings_banner_form_nonce' ); ?>"/>						<div class="wplegalpages-form-modal-buttons">
						<c-button color="info" id="wplegalpages-banner-form-submit" class="wplegalpages-form-modal-save-button" @click="showBannerForm" >Save</c-button>
						<c-button color="danger" class="wplegalpages-form-modal-cancel-button" @click="showBannerForm">Cancel</c-button>
						</div>
					</div>
				</div>
			</div>
		</c-tab>
	</c-tabs>
</div>
		<?php
	}
} else {
	?>
	<h2 class="hndle myLabel-head">DISCLAIMER</h2>
	<form action="" method="post">
	<textarea rows="20" cols="130">WPLegalPages.com ("Site") and the documents or pages that it may provide, are provided on the condition that you accept these terms, and any other terms or disclaimers that we may provide.  You may not use or post any of the templates or legal documents until and unless you agreed.  We are not licensed attorneys and do not purport to be.

WPLegalPages.com is not a law firm, is not comprised of a law firm, and its employees are not lawyers.  We do not review your site and we will not review your site. We do not purport to act as your attorney and do not make any claims that would constitute legal advice. We do not practice law in any state, nor are any of the documents provided via our Site intended to be in lieu of receiving legal advice.  The information we may provide is general in nature, and may be different in your jurisdiction.  In other words, do not take these documents to be "bulletproof" or to give you protection from lawsuits.  They are not a substitute for legal advice and you should have an attorney review them.

Accordingly, we disclaim any and all liability and make no warranties, including disclaimer of warranty for implied purpose, merchantability, or fitness for a particular purpose.  We provide these documents on an as is basis, and offer no express or implied warranties.  The use of our plugin and its related documents is not intended to create any representation or approval of the legality of your site and you may not represent it as such.  We will have no responsibility or liability for any claim of loss, injury, or damages related to your use or reliance on these documents, or any third parties use or reliance on these documents.  They are to be used at your own risk.  Your only remedy for any loss or dissatisfaction with WPLegalPages is to discontinue your use of the service and remove any documents you may have downloaded.

To the degree that we have had a licensed attorney review these documents it is for our own internal purposes and you may not rely on this as legal advice.  Since the law is different in every state, you should have these documents reviewed by an attorney in your jurisdiction.  As stated below, we disclaim any and all liability and warranties, including damages or loss that may result from your use or misuse of the documents.  Unless prohibited or limited by law, our damages in any matter are limited to the amount you paid for the WPLegalPages plugin.</textarea><br/><br/>
	Please Tick this checkbox to accept our Terms and Policy <input type="checkbox" name="lp_accept_terms" value="1" 
	<?php
	if ( '1' === $lpterms ) {
		echo 'checked';}
	?>
	onclick="jQuery('#lp_submit').toggle();"/>
	<?php
	if ( function_exists( 'wp_nonce_field' ) ) {
		wp_nonce_field( 'lp-submit-accept-terms' );
	}
	?>
	<br/><br/><input type="submit" name="lp_submit" class="btn btn-primary"  id="lp_submit" style="display:none;" value="Accept" />
	</form>
	<?php
}
?>
</div>
