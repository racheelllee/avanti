<div class="row">
	<div class="col-xs-12 paginator">
	    <ul class="pagination" style="float: right;">
	        <?= $this->Paginator->prev('< ') ?>
	        <?php if ($this->Paginator->numbers()) : ?>
	    		<?= $this->Paginator->numbers() ?>
	        <?php else: ?>
	    		<li class="active"><a href="#">1</a></li>
	        <?php endif; ?>
	        <?= $this->Paginator->next(' >') ?>
	    </ul>
	</div>
</div>