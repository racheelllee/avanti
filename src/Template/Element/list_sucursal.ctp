<div class="col-md-6" style="margin-top: 50px;">
  <div class="row">
    <div class="col-md-6">
      <div class="location">
        <h3> AVANTI <span> <?= $sucursal->name ?> </span> </h3>

        <ul>
          <li> <i class="fa fa-map-marker" aria-hidden="true"></i> <?= $sucursal->direccion ?> </li>
          <li> <i class="fa fa-phone" aria-hidden="true"></i> <?= $sucursal->telefono ?> </li>
          <li> <i class="fa fa-clock-o" aria-hidden="true"></i> <?= $sucursal->horario ?> </li>
        </ul>
      </div>
    </div>

    <div class="col-md-6" style="height:250px;">
      <?= $sucursal->iframe ?> 
    </div>
  </div>
</div>