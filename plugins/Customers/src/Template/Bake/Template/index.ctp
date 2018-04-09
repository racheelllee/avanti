<%
    # <?
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return !in_array($schema->columnType($field), ['binary', 'text']);
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}

if (!empty($indexColumns)) {
    $fields = $fields->take($indexColumns);
}

$bannedFields = ['id', 'created', 'modified', 'deleted'];

$belongsTo = [];
if (isset($associations['BelongsTo'])) {
  foreach ($associations['BelongsTo'] as $key => $assoc) {
    $belongsTo[$assoc['foreignKey']] = "{$assoc['property']}->{$assoc['displayField']}";
  }
}

    # ?>
%>

<style type="text/css">
  .dataTables_info{
    display:none;
  }
  .sorting-link a{
    color:#333;
  }
  .parsley-errors-list
  {
    padding-left: 0;
  }
  .parsley-errors-list li.parsley-required,
  .parsley-errors-list li.parsley-type
  {
    color: #ad0101;
    list-style: none;
    text-align: left;
  }
  .custom-datepicker{
    text-transform: capitalize;
  }
  .save-customers .control-label .required, .form-group .required{
    color: #333;
  }
  .picker__holder
  {
    overflow: hidden !important; 
  }
  .picker__button--clear, .picker__button--close, .picker__button--today{
    text-transform: capitalize;
  }
  table.dataTable>tbody>tr.child span.dtr-title a{
    color: #333;
  }
  ul.pagination{
    font-size: 12px;
  }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/themes/default.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/themes/default.date.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/themes/default.time.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/picker.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/picker.date.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/picker.time.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/translations/es_ES.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/parsleyjs/2.7.1/parsley.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/parsleyjs/2.7.1/i18n/es.js"></script>

<div class="portlet light bordered ">
  <div class="portlet-title">
    <div class="caption font-dark">
      <i class="fa fa-user font-dark"></i>
      <span class="caption-subject bold uppercase"><?= __('<%= $pluralHumanName %>') ?></span>
    </div>
    <div class="actions">
      <a
        class="btn btn-default w-btnAddUsers"
        href="<%= $plugin ? '/' . strtolower($plugin) : '' %>/<%= $pluralVar %>/add"
        data-remote="false"
        data-toggle="modal"
        data-target="#<%= $pluralVar %>Modal">
        <i class="fa fa-plus-circle"></i>
        <?= __('New') ?> <?= __('<%= $singularVar %>') ?>
      </a>
    </div>
  </div>

  <div class="table-reponsive <%= $pluralVar %>" style="margin-top:10px;">
      <table id="<%= $pluralVar %>Table" class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline w-AvenirLight collapsed">
          <thead>
              <tr>
  <% foreach ($fields as $field): %>
      <% if ( ! in_array($field, $bannedFields) ): %>
                  <th scope="col" class="sorting-link"><?= $this->Paginator->sort('<%= $field %>', __('<%= Inflector::humanize($field) %>')) ?></th>
      <% endif; %>
  <% endforeach; %>
                  <th scope="col" class="actions"><?= __('Actions') ?></th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
              <tr>
  <%      foreach ($fields as $field) {
              if ( ! in_array($field, $bannedFields) ){
                if (!in_array($schema->columnType($field), ['biginteger', 'decimal', 'float'])) {
                    if ( isset($belongsTo[$field]) ){
  %>
              <td><?= $<%= $singularVar %>-><%= $belongsTo[$field] %> ?></td>
  <%
                    } else {
  %>
              <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
  <%
                    }
                  } else {
  %>
              <td><?= number_format($<%= $singularVar %>-><%= $field %>, 2) ?></td>
  <%
                  }
              }
          }

              $pk = '$' . $singularVar . '->' . $primaryKey[0];
  %>
                  <td class="actions">
                      <div class='btn-group'>
                        <button class='btn dropdown-toggle dropdown-toggle btn-actions' data-toggle='dropdown' aria-expanded='false'>
                            <?= __('Acciones') ?>
                            <span class='caret'></span>
                        </button>
                          <ul class='dropdown-menu pull-right'>
                              <li>
                                  <a 
                                      href="<%= $plugin ? '/' . strtolower($plugin) : '' %>/<%= $pluralVar %>/edit/<?= $<%= $singularVar %>->id ?>" 
                                      data-remote="false" 
                                      data-toggle="modal" 
                                      data-target="#<%= $pluralVar %>Modal">
                                      <?= __('Edit <%= $singularVar %>') ?>
                                  </a>
                              </li>
                              <li>
                                  <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>)]) ?>
                              </li>
                          </ul>
                      </div>
                  </td>
              </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#<%= $pluralVar %>Table').DataTable({
            responsive: true,
            searching: false,
            bSort: false,
            bPaginate: false,
            columnDefs: [
                { responsivePriority: 1, targets: -1 },
            ]
        });
    });
</script>
<div class="modal fade" id="<%= $pluralVar %>Modal" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<div id="loader-content" style="display: none;">
    <p style="text-align: center;">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    </p>
</div>
<script type="text/javascript">
  $("#<%= $pluralVar %>Modal").on("show.bs.modal", function(e) {
        $(this).find(".modal-body").html($('#loader-content').html());
        var link = $(e.relatedTarget);
        $(this).find(".modal-body").load(link.attr("href"));
  });
</script>
