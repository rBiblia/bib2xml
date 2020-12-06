<?php

declare(strict_types=1);

namespace rBibliaBibleConverter\Xml;

use SimpleXMLElement;

class SimpleXMLExtended extends SimpleXMLElement
{
    public function addCData($text)
    {
        $node = dom_import_simplexml($this);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($text));
    }
}
