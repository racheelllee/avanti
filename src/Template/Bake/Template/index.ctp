<%
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

%>
<div class="row">
    <div class="col-xs-6 w-title w-color666">
      <h3 style="position: absolute; margin-top:30px;"><?php echo __('List of <%= $pluralHumanName %>');?></h3>
    </div>
    <div class="col-xs-6">
        <button class="btn btn-default w-AvenirLight w-btnNewUsers" data-toggle="modal" data-target="#<%= $pluralVar %>Modal">
            +  <?= __('New <%= $singularVar %>') ?>
        </button>
    </div>
</div>
<div class="table-reponsive <%= $pluralVar %>" style="margin-top:30px;">
    <table id="<%= $pluralVar %>Table" >
        <thead>
            <tr>
<% foreach ($fields as $field): %>
                <th scope="col"><?= $this->Paginator->sort('<%= $field %>') ?></th>
<% endforeach; %>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
            <tr>
<%        foreach ($fields as $field) {
            $isKey = false;
            if (!empty($associations['BelongsTo'])) {
                foreach ($associations['BelongsTo'] as $alias => $details) {
                    if ($field === $details['foreignKey']) {
                        $isKey = true;
%>
                <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
<%
                        break;
                    }
                }
            }
            if ($isKey !== true) {
                if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
                <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                } else {
%>
                <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                }
            }
        }

        $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
                <td class="actions">
                    <div class='btn-group'>
                        <button 
                                class='btn w-btnBorder578EBE btn-xs btn-outline dropdown-toggle dropdown-toggle btn-actions' data-toggle='dropdown' 
                                aria-expanded='false'>
                            <?= __('Actions') ?>
                            <span class='caret'></span>
                        </button>
                        <ul class='dropdown-menu pull-right'>
                            <li>
                                <!--a href="#" data-toggle="modal" data-target="#<%= $pluralVar %>Modal<?=<%= $pk %>?>">
                                    <?= __('Edit') ?>
                                </a-->
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', <%= $pk %>]) ?>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#<%= $pluralVar %>Table').DataTable({
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: -1 },
            ]
        });
    });
</script>
<div class="modal fade" id="<%= $pluralVar %>Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><?= __('Add <%= $singularVar %>') ?></h4>
      </div>
      <?= $this->render('add', false, compact('dependencies')) ?>
    </div>
  </div>
</div>