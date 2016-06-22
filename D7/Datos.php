<?php
interface Datos
{

    public function insert(stdClass $o):bool;

    public function update(stdClass $o):bool;
 
    public function exists(string $id):bool;

    public function delete(string $id):bool;
    
    public function all():array;

    public function select(string $id):stdClass;
}