<?php


namespace common\components;


class XmlGen
{
    public $doc;

    public $phat = 'xmls/';

    public function __construct()
    {
        $this->doc = new \DOMDocument('1.0', 'utf-8');
        $this->doc->formatOutput = true;
        $this->doc->preserveWhiteSpace = true;
    }

    /**
     * @param $content
     * @return array
     */
    public function GetDataOfXml($content)
    {
        $xml = simplexml_load_string($content) or die("Error: Cannot create object");
        return $this->XmlToArray($xml);
    }

    /**
     * @param $xmlObject
     * @param array $out
     * @return array
     */
    public function XmlToArray($xmlObject, $out = [])
    {
        foreach ((array)$xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? $this->XmlToArray($node) : $node;

        return $out;
    }

    /**
     * @param $key
     * @param $value
     * @param \DOMDocument $doc
     * @param $node
     */
    function createNodes($key, $value, \DOMDocument $doc, $node)
    {
        $key = $doc->createElement($key);
        $node->appendChild($key);
        $key->appendChild($doc->createTextNode($value));
    }

    /**
     * @param array $data
     * @return bool|string
     */
    public function GetXml($data = [],$name)
    {
        $root = $this->doc->createElement('data');
        $this->doc->appendChild($root);

        foreach ($data as $key => $value) {
            $this->createNodes($value['name'], $value['val'], $this->doc, $root);
        }

        $file = $this->GetFile($name);
        if ($this->doc->save($file)) {
            return $file;
        };

        return false;
    }

    /**
     * @return string
     */
    public function GetFile($name)
    {
        return $this->phat . $name . ".xml";
    }
}