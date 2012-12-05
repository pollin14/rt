<?php

class Node{
	
	private $father;
	private $children = array();
	private $value;
	private $id;
	private $leaf = false;
	
	
	public function __construct($id,$value,$father){
		$this->id = $id;
		$this->value= $value;
		$this->father = $father;
	}
	
	public function appendChild($node){
		array_push($this->children, $node);
	}
	
	public function setFather($nodo){
		$this->father = $nodo;
	}
	
	public function setValue($value){
		$this->value = $value;
	}
	
	
	public function insertNode($root,$node){
		
		if($root->id() == $node->father()){
			$root->appendChild($node);
			return true;
		}
	
		$c = $root->children();
		
		while( count($c) != 0){
			$child = array_pop($c);
			if( $this->insertNode($child,$node) ){
				return true;
			}
		}
		
		return false;
	}
	
	public function id(){
		return $this->id;
	}
	
	public function father(){
		return $this->father;
	}
	
	public function children(){
		return $this->children;
	}
	
	public function value(){
		return $this->value;
	}
	
	public function leaf($yes_not = null){
		if( $yes_not == null ){
			return $this->leaf;
		}else{
			$this->leaf = $yes_not;
		}
	}
	
	public function toUL($id_name = null){
		
		$eul = '';
		$father_ul = '';
		$father_ul_end = '';
		
		if( $this->father() == null){
			$father_ul .= '<ul>';
			$father_ul_end .= '</ul>';
		}
		
		if($father_ul != ''){
			$li = '<li class="center"><a>' . $this->id() . ' -> ' . $this->value(). "</a>\n";
		}else{
			$li = '<li><a>' . $this->id() . ' -> ' . $this->value(). "</a>\n";
		}
		
		$c = $this->children();
		
		if( count($c) > 0){ //¿tiene hijos?
			$li .= '<ul>';
			$eul .= '</ul>';
		}
		
		while( count($c) != 0 ){
			$n = array_pop($c);
			$li .= $n->toUL() . "\n";
		}
		
		$ul = $father_ul . $li . '</li>' . $eul . $father_ul_end . "\n";
		return $ul;
		
	}
}
?>