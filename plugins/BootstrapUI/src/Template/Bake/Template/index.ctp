<%
use Cake\Utility\Inflector;
%>

<div class="ibox">
    <div class="ibox-title">
        <span class="panel-title">
            <%= $pluralHumanName %>
        </span>
        <span  class="ibox-tools">
            <?= $this->Html->link(__('Agregar <%= $singularHumanName %>'), ['action' => 'add'],['class'=>'btn btn-primary', 'escape'=>false] ); ?> 

            <?php $this->Html->link('<i class="fa fa-download"></i> Exportar Excel', '/<%= Inflector::underscore($pluralHumanName) %>.xlsx', ['class'=>'btn-success', 'escape'=>false]); ?> 

        </span>
    </div>
    <div class="ibox-content">
        <?php echo $this->element('all_<%= Inflector::underscore($pluralHumanName) %>');?>
    </div>
</div>