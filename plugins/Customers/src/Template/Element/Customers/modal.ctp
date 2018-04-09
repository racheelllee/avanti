<div class="modal fade" id="customersModal" role="dialog">
  <div class="modal-dialog" style="min-width: 60%;">
    <div class="modal-content">
      <div class="modal-body" style="padding: 15px 30px;"></div>
    </div>
  </div>
</div>
<div id="loader-content" style="display: none;">
    <p style="text-align: center;">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    </p>
</div>
<script type="text/javascript">
  $("#customersModal").on("show.bs.modal", function(e) {
        $(this).find(".modal-body").html($('#loader-content').html());
        var link = $(e.relatedTarget);
        $(this).find(".modal-body").load(link.attr("href"));
  });
</script>