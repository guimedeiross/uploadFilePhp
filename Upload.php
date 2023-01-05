<?php

class Upload{
	private $name;
	
	private $extension;
	
	private $type;
	
	private $tmpName;
	
	private $error;
	
	private $size;
	
	private $duplicates = 0;
	
	public function __construct(array $file){
		$this->type = $file['type'];
		$this->tmpName = $file['tmp_name'];
		$this->error = $file['error'];
		$this->size = $file['size'];
		
		$info = pathinfo($file['name']);
		$this->name = $info['filename'];
		$this->extension = $info['extension'];
	}
	
	public function getBasename(): string {
		$extension = strlen($this->extension) ? '.'.$this->extension : '';
		
		$duplicates = $this->duplicates > 0 ? '-'.$this->duplicates : '';
		
		return str_replace(" ","-",$this->name.$duplicates.$extension);
	}
	
	private function getPossibleBasename(string $dir, bool $overwrite) {
		if ($overwrite) return $this->getBasename();
		
		$basename = $this->getBasename();
		
		if(!file_exists($dir.'/'.$basename)){
			return $basename;
		}
		
		$this->duplicates++;
		
		return $this->getPossibleBasename($dir,$overwrite);
	}
	
	public function upload(string $dir,bool $overwrite= true): bool {
		
		if($this->error !=0 ) return false;
		
		$path = $dir.'/'.$this->getPossibleBasename($dir,$overwrite);
		
		return move_uploaded_file($this->tmpName,$path);
	}
	
}
