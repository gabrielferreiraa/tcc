<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * File component
 */
class FileComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function upload($file, $name, $dir, $exists = false, $fullUrl = true) {
        if ($name == false)
            $name = uniqid();
        $folders = explode('/', $dir);
        $filePath = WWW_ROOT;
        foreach ($folders as $folder) {
            $filePath .= $folder . DS;
        }

        if (!file_exists($filePath)) {
            $oldmask = umask(0);
            mkdir($filePath, 0777, true);
            umask($oldmask);
        }

        $fileName = explode('.', $file['name']);
        $file_ext = isset($fileName[count($fileName) - 1]) ? '.' . $fileName[count($fileName) - 1] : '';
        $filePath .= $name . $file_ext;

        $returnUrl = $_SERVER['HTTP_HOST'] . $this->request->webroot . $dir . '/' . $name . (isset($fileName[1]) ? '.' . $fileName[1] : '');

        if (file_exists($filePath)) {
            if ($exists) {
                return false;
            } else {
                unlink($filePath);
            }
        }

        move_uploaded_file($file['tmp_name'], $filePath);

        if ($fullUrl) {
            return $returnUrl;
        } else {
            return $dir . '/' . $name . $file_ext;
        }
    }

    public function createFromBase64Png($base64, $name, $dir, $server = true) {
        if ($name == false)
            $name = uniqid();
        $folders = explode('/', $dir);
        $filePath = WWW_ROOT;

        foreach ($folders as $folder) {
            $filePath .= $folder . DS;
        }

        $filePath .= $name . '.png';

        $data = base64_decode(str_replace(' ', '+', str_replace('data:image/png;base64,', '', $base64)));
        try {
            file_put_contents($filePath, $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            exit;
        }

        if ($server)
            return $_SERVER['HTTP_HOST'] . $this->request->webroot . $dir . '/' . $name . '.png';
        return $dir . '/' . $name . '.png';
    }

    public function createFromBase64($base64, $name, $ext, $dir, $server = true) {
        if ($name == false)
            $name = uniqid();
        $folders = explode('/', $dir);
        $filePath = WWW_ROOT;

        foreach ($folders as $folder) {
            $filePath .= $folder . DS;
        }

        $filePath .= $name . '.' . $ext;

        // Remove the headers (data:,) part.
        $filteredData = substr($base64, strpos($base64, ",") + 1);
        // Need to decode before saving since the data we received is already base64 encoded
        $data = base64_decode($filteredData);

        try {
            file_put_contents($filePath, $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            exit;
        }

        if ($server)
            return $_SERVER['HTTP_HOST'] . $this->request->webroot . $dir . '/' . $name . '.png';
        return $dir . '/' . $name . '.' . $ext;
    }

    public function fileDelete($file, $dir) {

        $name = str_replace($_SERVER['HTTP_HOST'] . $this->request->webroot . $dir . '/', '', $file);

        $folders = explode('/', $dir);
        $filePath = WWW_ROOT;

        foreach ($folders as $folder) {
            $filePath .= $folder . DS;
        }

        $filePath .= $name;

        if (file_exists($filePath))
            unlink($filePath);
    }

    public function fileDeleteAlt($file) {
        $filePath = WWW_ROOT . $file;
        if (file_exists($filePath) && is_file($filePath))
            unlink($filePath);
    }

}
