<?php
/**
 * Streaming RDF Mapper abstract class
 *
 * @author Pieter Colpaert
 */

namespace tdt\streamingrdfmapper;
use \EasyRdf_Parser_Ntriples;
use \EasyRdf_Graph;

abstract class AMapper{
    private $mapping;
    public function __construct(&$mapping){
        //validate mapping first
        $this->validate($mapping);
        $this->mapping = $mapping;
    }

    abstract protected function validate(&$mapping);

    abstract public function map(&$chunk);

    /**
     * Maps towards an easyRDF graph
     */
    public function mapToEasyRDF(&$chunk){
        $triples = $this->map($chunk);
        $graph = new EasyRDF_Graph();
        $parser = new EasyRdf_Parser_Ntriples();
        $ntriples = "";
        foreach($triples as $triple){
            $ntriples .= implode(" ",$triple) . ".\n";
        }
        
        $parser->parse($graph, $ntriples, "ntriples", "");
        return $graph;
    }

}