<ul <?php echo fdm_format_classes( $this->classes ); ?>>
	<li class="fdm-section-header<?php echo ($this->background_image_placement == 'background' ? ' fdm-section-background-image' : ''); ?>" id="fdm-section-header-<?php echo $this->slug; ?>">

		<?php if ( ( $this->background_image_placement == 'background' ) and $this->image_url ) : ?>
			<div class="fdm-section-header-image-area" style="background-image: url(<?php echo $this->image_url; ?>); background-repeat: no-repeat; background-size: cover;">
				<h3 class='<?php echo $this->title_class; ?> h3-on-image'><?php echo $this->title; ?></h3>
			</div>
		<?php endif; ?>
		
		<?php if ( ( $this->background_image_placement == 'above' ) and $this->image_url ) : ?>
			<div class="fdm-section-header-image-area" style="background-image: url(<?php echo $this->image_url; ?>); background-repeat: no-repeat; background-size: cover;"></div>
		<?php endif; ?>

		<?php if ( ( $this->background_image_placement == 'background' and $this->image_url == '' ) or $this->background_image_placement != 'background' ) : ?>
			<h3 class='<?php echo $this->title_class; ?>'><?php echo $this->title; ?></h3>
		<?php endif; ?>

		<?php if ( $this->background_image_placement == 'below' and $this->image_url ) : ?>
			<div class="fdm-section-header-image-area" style="background-image: url(<?php echo $this->image_url; ?>); background-repeat: no-repeat; background-size: cover;"></div>
		<?php endif; ?>

		<?php if ( $this->description ) : ?>
		<p><?php echo $this->description; ?></p>
		<?php endif; ?>

	</li>
	<?php echo $this->print_items(); ?>
</ul>