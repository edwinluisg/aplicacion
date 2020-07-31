<?php
namespace core;

class File
{

    protected $file;

    public function __construct($date)
    {

        $this->file = $date;

    }

    public function saveFile($path, $prefix = '')
    {

        $img = $this->file;
        $ruta_provicional = $img["tmp_name"];
        $extencion = pathinfo($img["name"])['extension'];
        $name_file = $prefix . time() . "_." . $extencion;
        move_uploaded_file($ruta_provicional, $path . $name_file);
        return $name_file;

    }

    public function hasFile()
    {

        $resp = false;
        if (isset($this->file)) {
            if ($this->file["error"] <= 0) {
                $resp = true;
            }
        }
        return $resp;

    }

    public function validateExtImg()
    {

        $img = $this->file;
        $extencion = pathinfo($img["name"])['extension'];
        $array = array("jpg", "jpeg", "png", "JPG", "JPEG", "PNG");
        $res = false;
        foreach ($array as $value) {
            if ($value == $extencion) {
                $res = true;
                break;
            }
        }
        return $res;

    }

}
