<div class="modal fade" id="genericModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="width: 600px;">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<div id="generic-modal-loader" style="display: none;">
    <p style="text-align: center;">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    </p>
</div>
<script type="text/javascript">
  $("#genericModal").on("show.bs.modal", function(e) {
    $(this).find(".modal-body").html($('#generic-modal-loader').html());
    var link = $(e.relatedTarget);
    $(this).find(".modal-body").load(link.attr("href"));
  });
</script>