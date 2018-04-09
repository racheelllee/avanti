<%

use Cake\Utility\Inflector;

$associations += ['BelongsTo' => [], 'HasOne' => [], 'HasMany' => [], 'BelongsToMany' => []];
$immediateAssociations = $associations['BelongsTo'] + $associations['HasOne'];
$associationFields = collection($fields)
        ->map(function($field) use ($immediateAssociations) {
            foreach ($immediateAssociations as $alias => $details) {
                if ($field === $details['foreignKey']) {
                    return [$field => $details];
                }
            }
        })
        ->filter()
        ->reduce(function($fields, $value) {
    return $fields + $value;
}, []);

$groupedFields = collection($fields)
        ->filter(function($field) use ($schema) {
            return $schema->columnType($field) !== 'binary';
        })
        ->groupBy(function($field) use ($schema, $associationFields) {
            $type = $schema->columnType($field);
            if (isset($associationFields[$field])) {
                return 'string';
            }
            if (in_array($type, ['integer', 'float', 'decimal', 'biginteger'])) {
                return 'number';
            }
            if (in_array($type, ['date', 'time', 'datetime', 'timestamp'])) {
                return 'date';
            }
            return in_array($type, ['text', 'boolean']) ? $type : 'string';
        })
        ->toArray();

$groupedFields += ['number' => [], 'string' => [], 'boolean' => [], 'date' => [], 'text' => []];
$pk = "\$$singularVar->{$primaryKey[0]}";
%>
<?php
$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('Editar <%= $singularHumanName %>'), ['action' => 'edit', <%= $pk %>]) ?> </li>
    <li><?= $this->Form->postLink(__('Eliminar <%= $singularHumanName %>'), ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>)]) ?> </li>
    <li><?= $this->Html->link(__('Listar <%= $pluralHumanName %>'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('Nuevo <%= $singularHumanName %>'), ['action' => 'add']) ?> </li>
    <%
    $done = [];
    foreach ($associations as $type => $data) {
        foreach ($data as $alias => $details) {
            if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                %>
    <li><?= $this->Html->link(__('Listar <%= $this->_pluralHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'index']) ?> </li>
                <li><?= $this->Html->link(__('Agregar <%= Inflector::humanize(Inflector::singularize(Inflector::underscore($alias))) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'add']) ?> </li>
                <%
                $done[] = $details['controller'];
            }
        }
    }
    %>
</ul>
<?php $this->end(); ?>

<h2><?= h($<%= $singularVar %>-><%= $displayField %>) ?></h2>
<div class="row">
    <% if ($groupedFields['string']) : %>
    <div class="col-lg-5">
            <% foreach ($groupedFields['string'] as $field) : %>
                <%
                if (isset($associationFields[$field])) :
                    $details = $associationFields[$field];
                    %>
        <h6><?= __('<%= Inflector::humanize($details['property']) %>') ?></h6>
                    <p><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></p>
                <% else : %>
        <h6><?= __('<%= Inflector::humanize($field) %>') ?></h6>
                    <p><?= h($<%= $singularVar %>-><%= $field %>) ?></p>
                <% endif; %>
            <% endforeach; %>
    </div>
    <% endif; %>
    <% if ($groupedFields['number']) : %>
    <div class="col-lg-2">
            <% foreach ($groupedFields['number'] as $field) : %>
        <h6><?= __('<%= Inflector::humanize($field) %>') ?></h6>
                <p><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></p>
            <% endforeach; %>
    </div>
    <% endif; %>
    <% if ($groupedFields['date']) : %>
    <div class="col-lg-2">
            <% foreach ($groupedFields['date'] as $field) : %>
        <h6><%= "<%= __('" . Inflector::humanize($field) . "') %>" %></h6>
                <p><?= h($<%= $singularVar %>-><%= $field %>) ?></p>
            <% endforeach; %>
    </div>
    <% endif; %>
    <% if ($groupedFields['boolean']) : %>
    <div class="col-lg-2">
            <% foreach ($groupedFields['boolean'] as $field) : %>
        <h6><?= __('<%= Inflector::humanize($field) %>') ?></h6>
                <p><?= $<%= $singularVar %>-><%= $field %> ? __('Yes') : __('No'); ?></p>
            <% endforeach; %>
    </div>
    <% endif; %>
</div>
<% if ($groupedFields['text']) : %>
    <% foreach ($groupedFields['text'] as $field) : %>
<div class="row texts">
            <div class="col-lg-9">
                <h6><?= __('<%= Inflector::humanize($field) %>') ?></h6>
                <?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)); ?>
            </div>
        </div>
    <% endforeach; %>
<% endif; %>
<ul id="myTab" class="nav nav-tabs" role="tablist">
<%
//Vamos a usar tabs, asi que recorro los asociados para ponerlos.
$relations = $associations['HasMany'] + $associations['BelongsToMany'];
$active="active";
foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize($details['controller']);
    %>
    <li role="presentation" class="<%= $active; %>">
        <a href="#<%= $alias; %>" id="<%= $alias; %>-tab" role="tab" data-toggle="tab" aria-controls="<%= $alias; %>" aria-expanded="true"><%= $otherPluralHumanName %></a>
      </li>
      <% $active=""; %>
<% endforeach; %>   
</ul>

<div id="myTabContent" class="tab-content">
<%
$active="active";
foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize($details['controller']);
    %>
<div role="tabpanel" class="tab-pane fade in <%= $active; %>" id="<%= $alias; %>" aria-labelledBy="<%= $alias; %>-tab">
    <div class="related row">
        <div class = "col-lg-12"><br>            
            <?php if (!empty($<%= $singularVar %>-><%= $details['property'] %>)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <% foreach ($details['fields'] as $field): %>
                    <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
                        <% endforeach; %>
                    <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($<%= $singularVar %>-><%= $details['property'] %> as $<%= $otherSingularVar %>): ?>
                    <tr>
                        <% foreach ($details['fields'] as $field): %>
                    <td><?= h($<%= $otherSingularVar %>-><%= $field %>) ?></td>
                        <% endforeach; %>
                        <% $otherPk = "\${$otherSingularVar}->{$details['primaryKey'][0]}"; %>
                    <td class="actions">
                            <?= $this->Html->link('', ['controller' => '<%= $details['controller'] %>', 'action' => 'view', <%= $otherPk %>],['title' => __('View'), 'class' => 'btn btn-default fa fa-eye']) ?>
                            <?= $this->Html->link('', ['controller' => '<%= $details['controller'] %>', 'action' => 'edit', <%= $otherPk %>], ['title' => __('Edit'), 'class' => 'btn btn-default fa fa-pencil']) ?>
                            <?= $this->Form->postLink('', ['controller' => '<%= $details['controller'] %>', 'action' => 'delete', <%= $otherPk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $otherPk %>), 'title' => __('Delete'), 'class' => 'btn btn-default fa fa-trash']) ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
         <?php else: ?>
            <h4><?= __('No existen <%= $otherPluralHumanName %> asociados') ?></h4>
        <?php endif; ?>
        </div>
    </div>
</div>
<% $active=""; %>
<% endforeach; %>
</div>

