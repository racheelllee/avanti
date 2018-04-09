<?php
namespace App\Shell\Task;

use Bake\Shell\Task\SimpleBakeTask;
use Cake\Core\Configure;
use Cake\Utility\Inflector;

use Cake\Console\ConsoleInputArgument;

use Cake\ORM\TableRegistry;
use Bake\Utility\Model\AssociationFilter;
use Cake\Console\Shell;

class AllElementsTask extends SimpleBakeTask
{
    public $pathFragment = 'Template/';

    public function name()
    {
        return 'all_elements';
    }

    public function fileName($name)
    {
        return 'Element/all_' . strtolower( $name ) . '.ctp';
    }

    public function template()
    {
        return 'Element/all_elements';
    }

    public function templateData()
    {
        $namespace = Configure::read('App.namespace');
        
        if ($this->plugin) {
            $namespace = $this->_pluginNamespace($this->plugin);
        }

        $tableName  = $this->_camelize($this->args[0]);

        $plugin             = null;
        $params             = $this->params;

        if (!empty($params['plugin'])) {
            $plugin = $params['plugin'] . '.';
        }

        $this->modelName = $plugin . $tableName;
        $this->controllerName = $this->args[0];

        $modelObject = TableRegistry::get($this->modelName);

        $primaryKey         = (array)$modelObject->primaryKey();
        $displayField       = $modelObject->displayField();
        $singularVar        = $this->_singularName($this->controllerName);
        $singularHumanName  = $this->_singularHumanName($this->controllerName);
        $schema             = $modelObject->schema();
        $fields             = $schema->columns();
        $modelClass         = $this->modelName;

        $pluralVar          = Inflector::variable($this->controllerName);
        $pluralHumanName    = $this->_pluralHumanName($this->controllerName);

        $asocFilter         = new AssociationFilter;
        $associations       = $asocFilter->filterAssociations($modelObject);

        $keyFields          = [];

        if (!empty($associations['BelongsTo'])) {
            foreach ($associations['BelongsTo'] as $assoc) {
                $keyFields[$assoc['foreignKey']] = $assoc['variable'];
            }
        }

        $fields = collection($fields)
        ->filter(function($field) use ($schema) {
            return !in_array($schema->columnType($field), ['binary', 'text']);
        });

        return compact(
            'primaryKey', 
            'displayField', 
            'singularVar', 
            'singularHumanName', 
            'schema', 
            'fields', 
            'modelClass', 
            'pluralVar', 
            'pluralHumanName', 
            'asocFilter', 
            'associations', 
            'fields', 
            'namespace', 
            'params' 
        );

    }
}