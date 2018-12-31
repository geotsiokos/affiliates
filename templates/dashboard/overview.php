<?php
/**
 * overview.php
 *
 * Copyright (c) 2010 - 2018 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates
 * @since affiliates 4.0.0
 *
 * This is a template file. You can customize it by copying it
 * into the appropriate subfolder of your theme:
 *
 *   mytheme/affiliates/dashboard/overview.php
 *
 * It is highly recommended to use a child theme for such customizations.
 * Child themes are suitable to keep things up-to-date when the parent
 * theme is updated, while any customizations in the child theme are kept.
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var Affiliates_Dashboard_Overview $section Section object available for use in the template.
 */

$totals    = $section->get_totals();
$hits      = isset( $totals['hits'] ) ? intval( $totals['hits'] ) : 0;
$visits    = isset( $totals['visits'] ) ? intval( $totals['visits'] ) : 0;
$amounts   = array();
if ( isset( $totals['amounts_by_currency'] ) ) {
	foreach ( $totals['amounts_by_currency'] as $currency_id => $amount ) {
		$amounts[$currency_id] = round( $amount, affiliates_get_referral_amount_decimals( 'display' ), PHP_ROUND_HALF_UP );
	}
}
$pname      = get_option( 'aff_pname', AFFILIATES_PNAME );
$encoded_id = affiliates_encode_affiliate_id( $section->get_affiliate_id() );
$link_info  = wp_kses(
	sprintf( __( 'You can also add <code>?%s=%s</code> to any link on %s to track referrals from your account.', 'affiliates' ), $pname, $encoded_id, esc_url( site_url() ) ),
	array( 'code' => array(), 'a' => array( 'href' => array() ) )
);
?>
<h2><?php esc_html_e( 'Overview', 'affiliates' ); ?></h2>
<div class="dashboard-section dashboard-section-overview" style="display:grid">
	<div class="stats-container" style="display:flex">
		<div class="stats-item" style="flex-grow:1">
			<div class="stats-item-heading"><?php _e( 'Recent Visits', 'affiliates' ); ?></div>
			<div class="stats-item-value"><?php echo esc_html( $hits ); ?></div>
		</div>
		<div class="stats-item" style="flex-grow:1">
			<div class="stats-item-heading"><?php _e( 'Recent Referrals', 'affiliates' ); ?></div>
			<div class="stats-item-value"><?php echo esc_html( $visits ); ?></div>
		</div>
		<div class="stats-item" style="flex-grow:1">
			<div class="stats-item-heading"><?php _e( 'Recent Earnings', 'affiliates' )?></div>
			<?php foreach ( $amounts as $currency_id => $amount ) { ?>
				<div class="stats-item-value">
					<span class="stats-item-currency"><?php echo esc_html( $currency_id ); ?> <span class="stats-item-amount"><?php echo esc_html( $amount ); ?></span>
				</div>
			<?php } ?>
		</div>
	</div>
	<div id="affiliates-dashboard-overview-graph" class="graph" style="width:100%; height: 400px;"></div>
	<div id="affiliates-dashboard-overview-legend" class="legend"></div>
	<br/>
	<h3><?php esc_html_e( 'Links', 'affiliates' ); ?></h3>
	<div class="affiliates-dashboard-overview-link">
		<p><?php esc_html_e( 'Your affiliate URL:', 'affiliates' ); ?></p>
		<p>
			<textarea id="copy-to-clipboard-source" class="affiliate-url" readonly="readonly" onmouseover="this.focus();" onfocus="this.select();"><?php echo esc_html( Affiliates_Shortcodes::affiliates_url( array() ) ); ?></textarea>
		</p>
		<p>
			<span class="button copy-to-clipboard-trigger" data-source="copy-to-clipboard-source"><?php esc_html_e( 'Copy to Clipboard', 'affiliates' ); ?></span>
		</p>
		<p>
			<?php echo $link_info; ?>
		</p>
	</div>
</div>

<style type="text/css">
.dashboard-section .stats-container {
	margin: 0;
}
.dashboard-section .stats-item {
	background-color: #f2f2f2;
	border-radius: 4px;
	margin: 4px;
	padding: 4px;
	text-align: center;
	font-size: 16px;
}
.dashboard-section .stats-item .stats-item-heading {
	font-weight: bold;
}
.dashboard-section .stats-item .stats-item-value {
	font-size: 24px;
}
.dashboard-section .graph {
	background-color: #fafafa;
	border-radius: 4px;
	margin: 4px;
}
.dashboard-section .legend {
	display: flex;
	text-align: center;
	background-color: #f2f2f2;
	border-radius: 4px;
	margin: 4px;
}
.dashboard-section .legend-item {
flex-grow:1;
}
.dashboard-section .legend-item.active {
	background-color: #e0e0e0;
	border-radius: 2px;
}
.dashboard-section .legend-item-label {
	font-size: 14px;
	display:inline-block;
	vertical-align:middle;
	padding: 4px;
}
.dashboard-section .legend-item-color {
	width: 16px;
	height: 16px;
	display:inline-block;
	vertical-align:middle;
}
</style>
