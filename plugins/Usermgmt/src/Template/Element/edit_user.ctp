 <div class="modal fade" id="usersModal<?= $user->id ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Editar Usuario</h4>
        </div>
        <div class="modal-body">
          <?php //$this->element('edit_user_form', compact('user')); ?>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript">
  $("#usersModal<?= $user->id ?>").on("show.bs.modal", function(e) {
      var link = $(e.relatedTarget);
      $(this).find(".modal-body").load(link.attr("href"));
  });
  $("#usersModal<?= $user->id ?>").on("hidden.bs.modal", function(e) {
      $(this).find(".modal-body").html("<br>");
  });
</script>