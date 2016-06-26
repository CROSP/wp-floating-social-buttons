<?php 
	interface Admin_Page {
		public function render();
		public function init();
		public function submit();
		public function load_defaults();
		public function save_changes();
		public function enqueue_scripts();		
		public function register_settings();
	}