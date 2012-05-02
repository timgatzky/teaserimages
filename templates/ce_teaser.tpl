<?php new ArticleImage($this, true); ?>

<div class="<?php echo $this->class; ?> ce_text block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php if ($this->headline): ?>

<h1><?php echo $this->headline; ?></h1>
<?php endif; ?>

<?php if (!$this->addBefore): ?>
<?php echo $this->text; ?> <a href="<?php echo $this->articleHref; ?>" title="<?php echo $this->readMore; ?>" class="more"><?php echo $this->more; ?> <span class="invisible"><?php echo $this->headline; ?></span></a>
<?php endif; ?>

<?php if ($this->addImage): ?>
<div class="image_container<?php echo $this->floatClass; ?>"<?php if ($this->margin || $this->float): ?> style="<?php echo trim($this->margin . $this->float); ?>"<?php endif; ?>>
<?php if ($this->imageHref): ?>
<a href="<?php echo $this->imageHref; ?>"<?php echo $this->attributes; ?> title="<?php echo $this->alt; ?>">
<?php endif; ?>
<img src="<?php echo $this->src; ?>"<?php echo $this->imgSize; ?> alt="<?php echo $this->alt; ?>" />
<?php if ($this->imageHref): ?>
</a>
<?php endif; ?>
<?php if ($this->caption): ?>
<div class="caption" style="width:<?php echo $this->arrSize[0]; ?>px"><?php echo $this->caption; ?></div>
<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->addBefore): ?>
<?php echo $this->text; ?> <a href="<?php echo $this->articleHref; ?>" title="<?php echo $this->readMore; ?>" class="more"><?php echo $this->more; ?> <span class="invisible"><?php echo $this->headline; ?></span></a>
<?php endif; ?>

</div>