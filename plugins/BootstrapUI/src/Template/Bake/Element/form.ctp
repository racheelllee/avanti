<%

use Cake\Utility\Inflector;

$fields = collection($fields)
        ->filter(function($field) use ($schema) {
    return $schema->columnType($field) !== 'binary';
});
%>

<div class="ibox">
    <div class="ibox-title">
<span class="panel-title">
<?= __('<%= Inflector::humanize($action) %> {0}', ['<%= $singularHumanName %>']) ?>
</span>
    </div>
    <div class="ibox-content">
    <?= $this->Form->create($<%= $singularVar %> , [ 'class'=>'form-horizontal'] ); ?>
   
       
        
   
        <%
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            $fieldData = $schema->column($field);


            %>
        <div class="um-form-row form-group">
            <%
            if (isset($keyFields[$field])) {
                %>
             <?= $this->Form->input('<%= $field %>', [ 'div'=>false, 'label' => false, 'options' => $<%= $keyFields[$field] %>]); ?>
                <%

                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $dateClass = "";
                if ($fieldData['type'] === 'date')
                    $dateClass = "datepicker";

                $datetimeClass = "";
                if( $fieldData['type'] === 'datetime')
                    $datetimeClass = "datetimepicker";



                $rclas = '';
                if(empty($fieldData['null']))
                    $rclas = "required";

                
                %>

            <label class="col-sm-2 control-label" >

                <?=  __('<%= ucfirst($field) %>'); ?>

            </label>

            <div class="col-sm-3">

            <?= $this->Form->input('<%= $field %>', [ 'div'=>false, 'class' => 'form-control <%= $dateClass %> <%= $datetimeClass  %>' , 'label' => false]); ?>

            </div>
                <%
            }

            %>
            </div>
            <%
        }


        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
                %>

       <div class="um-form-row form-group"> 

       <label class="col-sm-2 control-label " >

                <?=  __('<%=  ucfirst($assocData['property'])  %>'); ?>

            </label>        
        <div class="col-sm-3">
        <?=  $this->Form->input('<%= $assocData['property'] %>._ids', [ 'label'=> false, 'options' => $<%= $assocData['variable'] %>]); ?>
        </div>
        </div>

                <%
            }

            
        }
        
        %>
        
    <div class="um-button-row">
    <?= $this->Form->button( __('<%= Inflector::humanize($action) %>' ) , ['class'=>'btn btn-primary'  ]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
</div>