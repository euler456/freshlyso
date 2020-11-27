<?php if ( $this->is_singular() ) : ?>
<div id="<?php echo fdm_global_unique_id(); ?>" class="fdm-menu fdm-menu-item">
<?php endif; ?>

	<?php if ( $this->is_singular() ) : ?>
	<div<?php echo fdm_format_classes( $this->classes ); ?>>
	<?php else : ?>
	<li<?php echo fdm_format_classes( $this->classes ); ?> data-postid="<?php echo $this->id; ?>" data-section="<?php echo $this->section; ?>" data-timeadded="<?php echo strtotime($this->post->post_date); ?>" <?php if(in_array('fdm-item-newpage-open', $this->classes)) { echo 'data-permalink="'.get_permalink($this->id).'"'; } ?>>
	<?php endif; ?>

		<?php echo $this->print_elements( 'header' ); ?>

		<div class="fdm-item-panel">

			<?php echo $this->print_elements( 'body' ); ?>

			<div class="clearfix"></div>
		</div>

		<?php echo $this->print_elements( 'footer' ); ?>

	<?php if ( $this->is_singular() ) : ?>
	</div>
	<?php else : ?>
	</li>
	<?php endif; ?>


<?php if ( $this->is_singular() ) : ?>
</div>
<?php endif; ?>
