<div class="modal inmodal" id="modalURL" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; z-index: 10051;">
    <div class="modal-dialog">
      <div style="background-color: #FFFFFF" class="modal-content animated fadeIn panel panel-info">
      </div>
    </div>
</div>

<div class="modal inmodal" id="modalURL2" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; z-index: 10051;">
    <div class="modal-dialog">
      <div style="background-color: #FFFFFF" class="modal-content animated fadeIn panel panel-info">
      </div>
    </div>
</div>

<script type="text/javascript">
	$(document).on({click: function(e){        
        
        var spinner = "<div class='text-center'><i class='fa fa-spinner fa-spin fa-5x fa-fw' style='margin:40px; font-size:20px;'></i></div>";
          $("#modalURL .modal-content").html(spinner);
        
          $("#modalURL .modal-content").load($(this).attr('href'));

    }}, 'a[data-target="#modalURL"]');

    $(document).on({click: function(e){        
        
        var spinner = "<div class='text-center'><i class='fa fa-spinner fa-spin fa-5x fa-fw' style='margin:40px; font-size:20px;'></i></div>";
          $("#modalURL2 .modal-content").html(spinner);
        
          $("#modalURL2 .modal-content").load($(this).attr('href'));

    }}, 'a[data-target="#modalURL2"]');

</script>