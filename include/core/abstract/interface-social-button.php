<?php 
	interface Social_Button {
		public function share_article($article_url);
		public function get_shares_count($article_url);
	}