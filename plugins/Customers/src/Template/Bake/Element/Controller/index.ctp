<%
// <?
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
$logicDelete =  in_array('deleted', $modelObj->schema()->columns());
$conditions = $logicDelete ? "'{$currentModelName}.deleted' => 0" : '';
%>

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $<%= $singularName %> = $this-><%= $currentModelName %>->newEntity();
<% $belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo'); %>
<% if ($belongsTo): %>
        $this->paginate = [
            'conditions' => [<%= $conditions %>],
            'contain' => [<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>]
        ];
<% endif; %>
        $<%= $pluralName %> = $this->paginate($this-><%= $currentModelName %>);
<%
        $associations = array_merge(
            $this->Bake->aliasExtractor($modelObj, 'BelongsTo'),
            $this->Bake->aliasExtractor($modelObj, 'BelongsToMany')
        );
        foreach ($associations as $assoc):
            $association = $modelObj->association($assoc);
            $otherName = $association->target()->alias();
            $otherPlural = $this->_variableName($otherName);
%>
        $<%= $otherPlural %> = $this-><%= $currentModelName %>-><%= $otherName %>->find('list', ['limit' => 200]);
<%
            $compact[] = "'$otherPlural'";
        endforeach;
%>

<%
        if (isset($compact) && !empty($compact)) :
%>
            $this->set(compact('<%= $singularName %>', '<%= $pluralName %>', <%= join(', ', $compact) %>));
<%
        else:
%>
            $this->set(compact('<%= $singularName %>', '<%= $pluralName %>'));
<%
        endif;
%>
        
        $this->set('_serialize', ['<%= $pluralName %>']);
    }
