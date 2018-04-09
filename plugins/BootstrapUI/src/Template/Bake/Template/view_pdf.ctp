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


$this->setFilename(__("<%= $singularVar  %> Details") );


$this->verNavegador();


?>
<page>

	<h1><?php echo __('<%= ucfirst($singularVar)  %> Details'); ?> </h1> <br>



<% if ($groupedFields['string']) : %>
    
<% foreach ($groupedFields['string'] as $field) : %>
           
<% if (isset($associationFields[$field])) :
                    $details = $associationFields[$field];
                    %>


        <span><b><?= __('<%= Inflector::humanize($details['property']) %>') ?>:</b></span>


        <span><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></span><br>


<% else : %>


        <span><b><?= __('<%= Inflector::humanize($field) %>') ?>: </b></span> 
        
        <span><?= h($<%= $singularVar %>-><%= $field %>) ?></span> <br>
                <% endif; %>

          
            <% endforeach; %>
    
<% endif; %>
<% if ($groupedFields['number']) : %>
    
<% foreach ($groupedFields['number'] as $field) : %>
           
        <span><b><?= __('<%= Inflector::humanize($field) %>') ?>:</b></span> 
        <span><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></span><br>
         
<% endforeach; %>
   
<% endif; %>
<% if ($groupedFields['date']) : %>
    
<% foreach ($groupedFields['date'] as $field) : %>
           
        <span><b><%= "<%= __('" . Inflector::humanize($field) . "') %>" %>:</b></span> 

        <span><?= h($<%= $singularVar %>-><%= $field %>) ?></span><br>
          
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['boolean']) : %>
<% foreach ($groupedFields['boolean'] as $field) : %>
      
        <span><b><?= __('<%= Inflector::humanize($field) %>') ?>: </b></span>
        <span><?= $<%= $singularVar %>-><%= $field %> ? __('Yes') : __('No'); ?></span><br>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['text']) : %>
<% foreach ($groupedFields['text'] as $field) : %>

        <span><b><?= __('<%= Inflector::humanize($field) %>') ?>:</b></span> 
        <span><?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)); ?></span><br>
         
    <% endforeach; %>
<% endif; %>

</page>