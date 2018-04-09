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
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>
    <?= $this->Form->create($<%= $singularVar %>, ['url' => '/<%= $pluralVar %>/add','class' => 'form-horizontal']) ?>
    <div class="row">
        <div class="col-md-12" style="padding: 20px;">
<%
                                                    // <?php
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>
            <div class="form-group">
              <label class="col-md-4 control-label"><?= __('<%= Inflector::humanize($field) %>') ?></label>
                <div class="col-md-6">
                    <?= $this->Form->input('<%= $field %>', [
                        'options' => $<%= $keyFields[$field] %>, 
                        'class'=>'form-control', 
                        'empty' => true,
                        'label'=>false, 
                        'div'=>false, 
                    ]); ?>
                </div>
            </div>
<%
                } else {
%>
            <div class="form-group">
              <label class="col-md-4 control-label"><?= __('<%= Inflector::humanize($field) %>') ?></label>
                <div class="col-md-6">
                    <?= $this->Form->input('<%= $field %>', [
                        'options' => $<%= $keyFields[$field] %>,
                        'data-validation' => 'required',
                        'class'=>'form-control', 
                        'label'=>false, 
                        'div'=>false,                         
                    ]); ?>
                </div>
            </div>

<%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (in_array($fieldData['type'], ['date', 'datetime', 'time']) && (!empty($fieldData['null']))) {
%>
            <div class="form-group">
              <label class="col-md-4 control-label"><?= __('<%= Inflector::humanize($field) %>') ?></label>
                <div class="col-md-6">
                    <?= $this->Form->input('<%= $field %>', [
                        'class'=>'form-control', 
                        'empty' => true
                        'label'=>false, 
                        'div'=>false, 
                    ]); ?>
                </div>
            </div>

<%
                } else {
%>
            <div class="form-group">
              <label class="col-md-4 control-label"><?= __('<%= Inflector::humanize($field) %>') ?></label>
                <div class="col-md-6">
                    <?= $this->Form->input('<%= $field %>', [
                        'data-validation' => 'required',
                        'class'=>'form-control', 
                        'label'=>false, 
                        'div'=>false, 
                    ]); ?>
                </div>
            </div>
<%
                }
            }
        }

        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            <?= $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]); ?>
<%
            }
        }
%>
        </div>
    </div>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>