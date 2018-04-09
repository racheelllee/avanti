<div id="update<%= $pluralHumanName %>Index" class="table-responsive" >

    <?php echo $this->Search->searchForm('<%= $pluralHumanName %>', ['legend'=>false, 'updateDivId'=>'update<%= $pluralHumanName %>Index']); ?>
    <?php echo $this->element('Usermgmt.paginator', ['updateDivId'=>'update<%= $pluralHumanName %>Index']); ?>

    <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
            	<% foreach ($fields as $field): %>
                <th class="psorting"><?php echo $this->Paginator->sort('<%= $pluralHumanName %>.<%= $field %>', __('<%= $field %>')); ?></th>
                <% endforeach; %>
                <th class="actions">Acciones</th>    
            </tr>
        </thead>
        <tbody>
            <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
                <tr>
                    <%
                    foreach ($fields as $field) {
                    	$isKey = false;
                    	if (!empty($associations['BelongsTo'])) {
                            foreach ($associations['BelongsTo'] as $alias => $details) {
                                if ($field === $details['foreignKey']) {
                                    $isKey = true;
                    %>
                                    <td>
                                        <?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?>
                                    </td>
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
                    <td class="actions col-sm-1">
                        <div class="dropdown pull-right">
                            <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i>&nbsp;Editar', ['action' => 'edit', <%= $pk %>], ['title' => __('Editar'), "escape" => false]) ?></li>
                                <li role="presentation"><?= $this->Form->postLink('<i class="fa fa-trash"></i>&nbsp;Borrar', ['action' => 'delete', <%= $pk %>], ['confirm' => __('Seguro que quiere borrar # {0}?', <%= $pk %>), 'title' => __('Delete'), "escape" => false]) ?></li>
                            </ul>
                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

     <?php if(!empty($<%= $pluralVar %>)) {        
        echo $this->element('Usermgmt.pagination', ['paginationText'=>__('Number of <%= $pluralVar %>')]);
    }?>

</div>
