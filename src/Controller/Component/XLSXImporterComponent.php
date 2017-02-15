<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
use Cake\I18n\Time;

/**
 * XLSXImporter component
 */
class XLSXImporterComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $_assertExistsData = [];
    protected $_loadedEntities = [];
    public $components = ['Task', 'Util'];

    public function importInsert($file, $db, $conf, $task) {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        if ($task) {
            $this->Task->update($task, 0, 'Salvando');
            sleep(2);
        }

        $realPath = realpath('xlsx-reader/xlsx-reader-insert.js');
        $filePath = escapeshellarg(realpath($file));

        $dbConn = base64_encode(json_encode($db));
        $dbInsert = base64_encode(json_encode($conf));

        $nodeExec = "node --max_old_space_size=2048 $realPath $filePath '$dbConn' '$dbInsert' ";
        $result = json_decode(shell_exec($nodeExec));

        if ($task) {
            $this->Task->update($task, 100);
            sleep(1);
        }

        return $result;
    }

    public function import($file, $headers = [], $task = false, $validateGroup = false, $fixedData = false) {

        ini_set('memory_limit', '-1');
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        if ($task) {
            $this->Task->update($task, 0, 'Lendo');
            sleep(2);
        }

        $realPath = realpath('xlsx-reader/xlsx-reader.js');
        $filePath = realpath($file);
        $commmmand = "node $realPath";
        $result = json_decode(shell_exec($commmmand . " " . escapeshellarg($filePath)));

        if ($task) {
            $this->Task->update($task, 100);
            sleep(1);
        }

        if (isset($result->status) && sizeof($headers) > 0 && $result->status == "success" && isset($result->headers) && sizeof($result->headers) > 0) {
            $assertResult = $this->assertHeaders($result, $headers);

            if ($assertResult->status == "success") {

                $validate = $this->validateResults($result->data, $headers, $task, $validateGroup, $fixedData);
                return $validate;
            } else {
                return $assertResult;
            }
        } else {
            return $result;
        }
    }

    public function assertHeaders($importerResult, $headers) {
        $errors = [];
        $result = [];

        foreach ($headers as $header => $value) {
            if (!in_array($header, $importerResult->headers)) {
                $errors[] = sprintf("O campo %s requerido não foi encontrado no cabeçalho do documento.", $header);
            }
        }

        if (sizeof($errors) > 0) {
            $result['status'] = "error";
            $result['reason'] = $errors;
            return (object) $result;
        } else {
            $result['status'] = "success";
            return (object) $result;
        }
    }

    function validateResults($results, $headers, $task = false, $validateGroup = false, $fixedData = false) {

        if ($task) {
            $this->Task->update($task, 0, 'Validando');
        }

        $result = [];
        $data = [];
        $dataChild = [];
        $errors = [];

        $rowCount = 1;

        foreach ($results as $key => $row) {
            foreach ($row as $field => $col) {
                $v = $col;

                if (!isset($headers[$field]['set']) || $headers[$field]['set'] != 'notSet') {
                    if (isset($headers[$field]['required']) && empty($v)) {
                        $errors[] = __($headers[$field]['required'], $key + 1);
                    } else {
                        if (isset($headers[$field]['behavior'])) {
                            foreach ($headers[$field]['behavior'] as $type => $value) {
                                switch ($type) {
                                    case 'padLeft':
                                        if (!empty($v)) {
                                            $lenght = current(array_keys($value));
                                            $fill = current($value);
                                            $v = str_pad($v, $lenght, $fill, STR_PAD_LEFT);
                                        }
                                        break;
                                    case 'padRight':
                                        if (!empty($v)) {
                                            $lenght = current(array_keys($value));
                                            $fill = current($value);
                                            $v = str_pad($v, $lenght, $fill);
                                        }
                                        break;
                                    case 'date':
                                        if (!empty($v)) {
                                            list($d, $m, $y) = explode('/', $v);
                                            $v = Time::now();
                                            $v->year($y)->month($m)->day($d);
                                        } else {
                                            $v = null;
                                        }
                                        break;
                                    case 'getPeriod':
                                        if (!empty($v)) {
                                            switch ($value) {
                                                case 1:
                                                    $v = $this->Util->getMonth($v);
                                                    break;
                                            }
                                        }
                                        break;
                                    case 'empty':
                                        if (empty($v)) {
                                            $v = $value;
                                        }
                                        break;
                                    case 'stringLimit':
                                        if (is_string($v) && strlen($v) > $value) {
                                            $v = substr($v, 0, $value);
                                        }
                                        break;
                                }
                            }
                        }
                        if (isset($headers[$field]['validation'])) {
                            $validation = $this->validateValue($headers[$field]['validation'], $v, $key + 1, $row, isset($headers[$field]['validation']['conditions']) ? $headers[$field]['validation']['conditions'] : []);

                            if ($validation['status'] == 'success') {
                                $v = $validation['value'];
                            } else {
                                $errors[] = $validation['msg'];
                                $v = 0;
                            }
                        }

                        if (isset($headers[$field])) {
                            if (is_array($headers[$field]['field'])) {
                                switch ($headers[$field]['field']['type']) {
                                    case 'hasMany':

                                        $childData = [
                                            'type' => 'hasMany',
                                            'foreignKey' => $headers[$field]['field']['foreignKey'],
                                            'data' => [
                                                $headers[$field]['field']['field'] => $v
                                            ]
                                        ];

                                        if (isset($headers[$field]['field']['defaultValues'])) {
                                            $childData['data'] = array_merge($childData['data'], $headers[$field]['field']['defaultValues']);
                                        }

                                        $dataChild[$key][$headers[$field]['field']['entity']][] = $childData;
                                        break;

                                    case 'hasOne':

                                        if (!isset($dataChild[$key][$headers[$field]['field']['entity']])) {
                                            $dataChild[$key][$headers[$field]['field']['entity']] = [
                                                0 => [
                                                    'type' => 'hasMany',
                                                    'foreignKey' => $headers[$field]['field']['foreignKey'],
                                                    'data' => []
                                                ]
                                            ];
                                        }

                                        $dataChild[$key][$headers[$field]['field']['entity']][0]['data'][$headers[$field]['field']['field']] = $v;

                                        if (isset($headers[$field]['field']['defaultValues'])) {
                                            foreach ($headers[$field]['field']['defaultValues'] as $defField => $defValue) {
                                                $dataChild[$key][$headers[$field]['field']['entity']][0]['data'][$defField] = $defValue;
                                            }
                                        }

                                        break;
                                }
                            } else {
                                if (!isset($data[$key][$headers[$field]['field']]) || empty($data[$key][$headers[$field]['field']])) {
                                    $data[$key][$headers[$field]['field']] = $v;
                                }
                            }
                        }
                    }
                }
            }

            if ($fixedData) {
                foreach ($fixedData as $fixedField => $fixedValud) {
                    $data[$key][$fixedField] = $fixedValud;
                }
            }

            if ($validateGroup && !count($errors)) {
                foreach ($validateGroup as $validation) {
                    $validation = $this->validateGroup($validation, $data[$key], $key + 1);
                    if ($validation['status'] != 'success') {
                        $errors[] = $validation['msg'];
                    }
                }
            }

            $rowCount++;
            if ($rowCount >= 300) {

                $rowCount = 1;

                if ($task) {
                    $percent = number_format((($key + 1) / count($results)) * 100, 0);
                    $this->Task->update($task, $percent, 'Validando');
                }

                usleep(100000);
            }

            if (count($errors) >= 150) {
                break;
            }
        }

        if (sizeof($errors) > 0) {
            $result['status'] = "error";
            $result['reason'] = $errors;
            return (object) $result;
        } else {

            if ($task) {
                $this->Task->update($task, 100);
                sleep(1);
            }

            $result['status'] = "success";
            $result['data'] = $data;
            if (count($dataChild)) {
                $result['dataChild'] = $dataChild;
            }
            return (object) $result;
        }
    }

    private function validateValue($validation, $value, $line, $lineData = false, $conditions = []) {

        $error = false;

        if (!empty($value)) {
            switch ($validation['type']) {
                case 'exists':
                    $this->loadEntity($validation['entity']);
                    if (!$this->assertExists($this->_loadedEntities[$validation['entity']], $validation['column'], $value, $conditions)) {
                        $error = __($validation['message'], $value, $line);
                    }
                    break;

                case 'notExists':
                    $this->loadEntity($validation['entity']);
                    if ($this->assertExists($this->_loadedEntities[$validation['entity']], $validation['column'], $value, $conditions)) {
                        $error = __($validation['message'], $value, $line);
                    }
                    break;
                case 'existsId':
                    $this->loadEntity($validation['entity']);
                    $existsKey = $this->assertExists($this->_loadedEntities[$validation['entity']], $validation['column'], $value, $conditions, true, isset($validation['returnField']) ? $validation['returnField'] : 'id');
                    if (!$existsKey) {
                        $error = __($validation['message'], $value, $line);
                    } else {
                        $value = $existsKey;
                    }
                    break;
                case 'existsCityStateName':
                    $this->loadEntity('Cities');
                    $this->loadEntity('States');
                    if ($lineData) {
                        $stateField = $validation['stateField'];
                        $stateKey = $this->assertExists($this->_loadedEntities['States'], 'name', $lineData->$stateField, $conditions, true);
                    } else {
                        $stateKey = false;
                    }
                    if ($stateKey) {
                        $cityKey = $this->assertExists($this->_loadedEntities['Cities'], $validation['column'], $value, ['state_id' => $stateKey], true);
                        if ($cityKey) {
                            $value = $cityKey;
                        } else {
                            $error = __($validation['cityMessage'], $value, $line);
                        }
                    } else {
                        $error = __($validation['stateMessage'], $lineData->$stateField, $line);
                    }
                    break;
            }
        }

        if ($error) {
            return ['status' => 'error', 'msg' => $error];
        } else {
            return ['status' => 'success', 'value' => $value];
        }
    }

    private function validateGroup($validation, $rowData, $line) {

        $error = false;

        switch ($validation['type']) {
            case 'notExists':
                $this->loadEntity($validation['entity']);

                $arrValue = [];

                foreach ($validation['columns'] as $column) {
                    $arrValue[$column] = $rowData[$column];
                }

                if (isset($validation['fixed'])) {
                    $arrValue = array_merge($arrValue, $validation['fixed']);
                }

                if ($this->assertExists($this->_loadedEntities[$validation['entity']], $validation['columns'], $arrValue)) {
                    $error = __($validation['message'], $line);
                }
                break;
        }

        if ($error) {
            return ['status' => 'error', 'msg' => $error];
        } else {
            return ['status' => 'success'];
        }
    }

    private function loadEntity($entity) {
        if (!isset($this->_loadedEntities[$entity])) {
            $this->_loadedEntities[$entity] = TableRegistry::get($entity);
        }
    }

    function assertExists($entity, $field, $value, $conditions = [], $returnKey = false, $keyValue = 'id') {

        if (!isset($this->_assertExistsData[$entity->alias()])) {
            $this->_assertExistsData[$entity->alias()] = [];
        }

        if (is_array($value)) {
            $valueSearch = implode('_', $value);
        } else {
            $valueSearch = $value;
        }

        if (in_array($valueSearch, $this->_assertExistsData[$entity->alias()])) {
            if ($returnKey) {
                return array_search($valueSearch, $this->_assertExistsData[$entity->alias()]);
            } else {
                return true;
            }
        } else {
            $where = $conditions;

            if (is_array($value)) {
                foreach ($value as $field => $val) {
                    if (is_numeric($val)) {
                        $where["{$field}"] = $val;
                    } else {
                        $where["unaccent({$field}) ILIKE"] = $this->r_acc($val);
                    }
                }
            } else {
                if (is_numeric($valueSearch)) {
                    $where["{$field}"] = $valueSearch;
                } else {
                    $where["unaccent({$field}) ILIKE"] = $this->r_acc($valueSearch);
                }
            }

            $entityResult = $entity->find()->where($where)->first();

            if ($entityResult) {
                $this->_assertExistsData[$entity->alias()][$entityResult->id] = $valueSearch;
                if ($returnKey) {
                    return $entityResult->$keyValue;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    public function r_acc($string) {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');

        return str_replace($a, $b, trim($string));
    }

}
