<%
    #<?
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

$bannedFields = ['id', 'created', 'modified', 'updated', 'deleted', 'modificado_por'];

    #<?
%>
    <?= $this->Form->create($<%= $singularVar %>, [
      'url' => "<%= $plugin ? '/' . strtolower($plugin) : '' %>/<%= $pluralVar %>/<%= $action %>/{$<%= $singularVar %>->id}",
      'class' => 'form-horizontal',
      'data-parsley-validate',
      'enctype' => 'multipart/form-data',
      'id' => 'save-<%= $pluralVar %>',
    ]) ?>
    <div class="row">
        <div class="col-md-12" style="padding: 20px;">
<%
                                                    // <?php
        foreach ($fields as $field) {
            if (in_array($field, $bannedFields)) continue;
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>                                                  // ?>
            <div class="form-group">
                <!-- label class="col-md-4 control-label"><?= __('<%= Inflector::humanize($field) %>') ?></label -->
                <div class="col-md-6">
                    <?= $this->Form->input('<%= $field %>', [
                        'options' => $<%= $keyFields[$field] %>,
                        'class' => 'form-control',
                        'empty' => true,
                        'label' => '<%= Inflector::humanize($field) %>',
                        'div' => false,
                    ]); ?>
                </div>
            </div>
<%
                } else {
%>
            <div class="form-group">
                <!-- label class="col-md-4 control-label"><?= __('<%= Inflector::humanize($field) %>') ?></label -->
                <div class="col-md-6">
                    <?= $this->Form->input('<%= $field %>', [
                        'options' => $<%= $keyFields[$field] %>,
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => '<%= Inflector::humanize($field) %>',
                        'div' => false,
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
                <!-- label class="col-md-4 control-label"><?= __('<%= Inflector::humanize($field) %>') ?></label -->
                <div class="col-md-6">
                    <?= $this->Form->input('<%= $field %>', [
                        'type' => 'text',
                        'class' => 'form-control custom-datepicker',
                        'empty' => true,
                        'label' => '<%= Inflector::humanize($field) %>',
                        'div' => false,
                    ]); ?>
                </div>
            </div>

<%
                } else {
%>
            <div class="form-group">
                <!-- label class="col-md-4 control-label"><?= __('<%= Inflector::humanize($field) %>') ?></label -->
                <div class="col-md-6">
                    <?= $this->Form->input('<%= $field %>', [
                        'required' => 'required',
                        'class' => 'form-control',
                        'label' => '<%= Inflector::humanize($field) %>',
                        'div' => false,
                    ]); ?>
                </div>
            </div>
<%
                }
            }
        }
%>
        </div>
    </div>
    <div class="modal-footer">
      <div class="col-lg-offset-3 col-md-6" style="text-align: center;">
        <button id="cancel-save-<%= $pluralVar %>" type="button" class="btn btn-default" data-dismiss="modal"><?= __('Cancel') ?></button>
        <?= $this->Form->button(__('Save'), ['class' => 'btn btn-span btn-md btn-primary', 'id' => 'save-<%= $pluralVar %>-btn']) ?>
      </div>
    </div>
<?= $this->Form->end() ?>
<script type="text/javascript">
  $(function(){
    $('#save-<%= $pluralVar %>').parsley().on('form:success', function() {
        $('#save-<%= $pluralVar %>-btn').prop('disabled', 'disabled')
    });
    $('#save-<%= $pluralVar %>').parsley();
    $('.custom-datepicker').pickadate({
      'format': 'dd/mm/yyyy',
      'formatSubmit': 'yyyy-mm-dd',
      hiddenName: true,
      selectYears: true,
      selectMonths: true,
    });
    /*$(".phone").inputmask("+52 (99) 9999 9999", {
        placeholder: " ",
        clearMaskOnLostFocus: true
    });*/
    /*$(".postal-code").inputmask("99999", {
        placeholder: " ",
        clearMaskOnLostFocus: true
    });*/
  });
</script>
