<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

/**
 * XLSXImporter component
 */
class XLSXExporterComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function buildExport($entityAlias, $options, $file, $Sheets = 'Sheet1') {

        $findInEntities = [];

        $Entity = TableRegistry::get($entityAlias);

        $headers = [];

        $fieldNames = array_keys($options['fields']);

        foreach ($fieldNames as $name) {
            $headers[$name] = 'string';
        }

        $data = [];

        $results = $Entity->find();

        if (isset($options['config'])) {
            if (isset($options['config']['select'])) {
                $results->select($options['config']['select']);
            }
            if (isset($options['config']['contain'])) {
                $results->contain($options['config']['contain']);
            }
            if (isset($options['config']['order'])) {
                $results->order($options['config']['order']);
            }
            if (isset($options['config']['innerJoin'])) {
                foreach ($options['config']['innerJoin'] as $join) {
                    $results->innerJoin($join['table'], $join['conditional']);
                }
            }
            if (isset($options['config']['leftJoin'])) {
                foreach ($options['config']['leftJoin'] as $join) {
                    $results->leftJoin($join['table'], $join['conditional']);
                }
            }

            if (isset($options['config']['conditions'])) {
                foreach ($options['config']['conditions'] as $condition) {
                    $key = current(array_keys($condition));
                    switch ($key) {
                        case 'where': $results->where(current($condition));
                            break;
                        case 'andWhere': $results->andWhere(current($condition));
                            break;
                        case 'orWhere': $results->orWhere(current($condition));
                            break;
                    }
                }
            }
        }
        foreach ($results as $result) {
            $row = [];
            foreach ($options['fields'] as $field) {
                if (is_array($field)) {
                    $column = isset($field['field']) ? $field['field'] : '';
                } else {
                    $column = $field;
                }

                if (!empty($column)) {
                    if (strpos($column, '.')) {
                        $fieldParts = explode('.', $column);

                        $elParts = $result;
                        foreach ($fieldParts as $fieldPart) {
                            if (is_numeric($fieldPart) && !empty($elParts[$fieldPart])) {
                                $elParts = $elParts[$fieldPart];
                            } else {
                                if (isset($elParts->$fieldPart) && !empty($elParts->$fieldPart) && !is_null($elParts->$fieldPart)) {
                                    $elParts = $elParts->$fieldPart;
                                } else {
                                    $elParts = '';
                                    break;
                                }
                            }
                        }

                        $value = $elParts;
                    } else {
                        $value = $result->$column;
                    }
                } else {
                    $value = '';
                }

                if (is_array($field)) {

                    if (isset($field['replaces'])) {
                        if (isset($field['replaces']['no_empty'])) {
                            $value = !empty($value) ? $field['replaces']['no_empty'] : $field['replaces']['def'];
                        } else {
                            $value = isset($field['replaces'][$value]) ? $field['replaces'][$value] : (isset($field['replaces']['def']) ? $field['replaces']['def'] : '');
                        }
                    }

                    if ($value) {
                        if (isset($field['type'])) {
                            switch ($field['type']) {
                                case 'date':
                                    $value = $value->i18nFormat('dd/MM/yyyy');
                                    break;
                                case 'date_time':
                                    $value = $value->i18nFormat('dd/MM/yyyy HH:mm:ss');
                                    break;
                            }
                        }

                        if (isset($field['find_in'])) {
                            foreach ($result->{$field['find_in']} as $findRow) {
                                $passTotal = count($field['conditions']);
                                $passCount = 0;
                                foreach ($field['conditions'] as $condField => $condValue) {
                                    if ($findRow->$condField == $condValue) {
                                        $passCount++;
                                    }
                                }
                                if ($passTotal == $passCount) {
                                    $value = $findRow->{$field['return']};
                                }
                            }
                        }

                        if (isset($field['find_in_entity'])) {
                            if (!isset($findInEntities[$field['find_in_entity']])) {
                                $findInEntities[$field['find_in_entity']] = TableRegistry::get($field['find_in_entity']);
                            }

                            $findResult = $findInEntities[$field['find_in_entity']]->find();

                            foreach ($field['conditions'] as $findKey => $findCond) {
                                if (is_array($findCond)) {

                                    if (strpos($findCond['field'], '.')) {
                                        $fieldParts = explode('.', $findCond['field']);

                                        $elParts = $result;

                                        foreach ($fieldParts as $fieldPart) {
                                            if (is_numeric($fieldPart) && !empty($elParts[$fieldPart])) {
                                                $elParts = $elParts[$fieldPart];
                                            } else {
                                                if (isset($elParts->$fieldPart) && !empty($elParts->$fieldPart) && !is_null($elParts->$fieldPart)) {
                                                    $elParts = $elParts->$fieldPart;
                                                } else {
                                                    $elParts = '';
                                                    break;
                                                }
                                            }
                                        }

                                        $findValue = $elParts;
                                    } else {
                                        $findValue = $result->$column;
                                    }

                                    if (isset($findCond['equals_to'])) {
                                        $findResult->where([$findCond['equals_to'] => $findValue]);
                                    }
                                } else {
                                    
                                }
                            }

                            if ($findResult->count()) {
                                $findResult = $findResult->first();
                                $value = $findResult->{$field['return']};
                            }
                        }
                    }
                }

                $row[] = $value;
            }

            $data[] = $row;
        }
        return $this->export($data, $headers, $file, $Sheets);
    }

    public function executeExport($connName, $sql, $file, $Sheets = 'Planilha 1') {
        $conn = ConnectionManager::get('default');

        $stmt = $conn->execute($sql);

        $results = $stmt->fetchAll('assoc');

        $headers = [];

        if (count($results)) {
            foreach (array_keys($results[0]) as $label) {
                $headers[$label] = 'String';
            }

            return $this->export($results, $headers, $file, $Sheets);
        } else {
            return false;
        }
    }

    /**
     * [import description]
     * @param  [type] $file    [description]
     * @param  array  $headers If headers is not empty it will assert the headers
     * @return [type]          [description]
     */
    public function export($data, $headers, $file, $Sheets = 'Planilha 1') {

        $writer = WriterFactory::create(Type::XLSX);
        $writer->openToFile('files/exports' . '/' . $file);

        $sheet = $writer->getCurrentSheet();
        if (is_array($Sheets)) {
            foreach ($Sheets as $key => $sheet) {
                $sheet->setName($sheet);
                $writer->addRow(array_keys($headers[$sheet]));
                $writer->addRows($data[$sheet]);
                if ($key < count($Sheets))
                    $sheet = $writer->addNewSheetAndMakeItCurrent();
            }
        } else {
            $sheet->setName($Sheets);
            $writer->addRow(array_keys($headers));
            $writer->addRows($data);
        }

        $writer->close();
        return 'files/exports' . '/' . $file;
    }

}
