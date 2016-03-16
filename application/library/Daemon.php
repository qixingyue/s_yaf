<?php

global $dup2_stdout,$dup2_stdin;

class Daemon {

	public static function changeToDaemon($stdoutfile = false,$stdinfile = false){
			self::runAsDaemon(function(){},true,$stdoutfile,$stdinfile);	
	}

	public static function runAsDaemon($daemonTask,$postTaskGoOn = false,$stdoutfile = false,$stdinfile=false){
		if(!is_callable($daemonTask)){
			throw new Yaf_Exception("daemonTask must can be called ! ");
		}
		if(!extension_loaded("pcntl") || !extension_loaded("posix")){
			throw new Yaf_Exception("pcntl must loaded ! ");
		}
		$pid = pcntl_fork();
		if($pid == 0) {
			//child process

			set_time_limit(0);
			chdir("/");
			umask(0);
	
			self::dup2Stdout($stdoutfile);	
			self::dup2Stdin($stdinfile);	

			call_user_func($daemonTask);			
			if(false === $postTaskGoOn){
				exit();
			}
		} else if($pid > 0 ) {
			exit();	
		} else {
			throw new Yaf_Exception("pcntl fork  error ! ");
		}
	}

	public static function dup2Stdin($f){
		if(false != $f){ 
			fclose(STDIN);	
			global $dup2_stdiin;
			$dup2_stdiin = fopen($f,"w");
		}
	}

	public static function dup2Stdout($f){
		if(false != $f){ 
			fclose(STDOUT);	
			global $dup2_stdout ;
			$dup2_stdout = fopen($f,"a+");
		}
	}

	public function runIgnore($task){
		if(!is_callable($task)){
			throw new Yaf_Exception("daemonTask must can be called ! ");
		}
		$pid = pcntl_fork();
		if($pid == 0) {
			call_user_func($task);
			exit();
		} else if($pid > 0 ){
			return true;	
		} else {
			return false;	
		}
	}

}
