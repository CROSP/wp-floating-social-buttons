<?php 
class Settings {
	 public static $view_settings_constants = 
                  ['tabs' => 
                          [
                            'general' => ['argument' => '','title' => 'General'],
                            'social-buttons' => ['argument' => 'social_buttons','title' => 'Social buttons']
                          ]
                  ];
    public static $settings_constants = 
				    [
				    	'fssb_floating_position' => 
				    	[
                            'verically-top-left' => 'Top Left Vertically',
                            'verically-bottom-left' => 'Bottom Left Vertically',
                            'verically-right' => 'Right Vertically',
                            'verically-left' => 'Left Vertically',
                            'verically-top-right' => 'Top Right Vertically',
                            'verically-bottom-right' => 'Bottom Right Vertically',
                            'horizontal-bottom-center' => 'Bottom Center Horizontally',
                            'horizontal-bottom-left' => 'Bottom Left Horizontally',
                            'horizontal-bottom-right' => 'Bottom Right Horizontally',
                            'horizontal-top-center' => 'Top Center Horizontally',
                            'horizontal-top-left' => 'Top Left Horizontally',
                            'horizontal-top-righ' => 'Bottom Right Horizontally',
                            'not-set' => 'Not set (should be set via custom css)'
              ],
              'fssb_button_shape' => 
              [
                            'square' => 'Square',
                            'circle' => 'Circle',
                            'not-set' => 'Not set (should be set via custom css)'
              ],
              'fssb_substitution_patterns' => 
                      [
                        '%%URL%%',
                        '%%POST_TITLE%%',
                        '%%POST_EXCERPT%%',
                        '%%PAGE_TITLE%%' 
                      ]


				    ];
    public static $default_settings = 
            [
             	'fssb_enable' => true,
             	'fssb_share_popup_prefix' => 'Share this article on ',
              'fssb_show_shares_count' => true,
              'fssb_button_shape' => 'circle',
             	'fssb_floating_position' => 'verically-left',
              'fssb_default_icon_color' => '#008EC2',
              'fssb_social_buttons' => "{\"fssb_facebook\":{\"enabled\":0,\"title\":\"Facebook\",\"share_url\":\"https:\/\/www.facebook.com\/sharer\/sharer.php?u=%%URL%%\",\"shares_count_url\":\"https:\/\/api.facebook.com\/method\/links.getStats?urls=%%URL%%&format=json\",\"count_parameter\":\"share_count\",\"cutsom_data\":\"\",\"use_regex\":false,\"icon\":\"fa-facebook\",\"shape_background_color\":\"#3B5998\",\"icon_text_color\":\"#3B5998\"},\"fssb_linked_in\":{\"enabled\":1,\"title\":\"LinkedIn\",\"share_url\":\"https:\/\/www.linkedin.com\/shareArticle?mini=true&url=%%URL%%t&title=%%PAGE_TITLE%%\",\"shares_count_url\":\"http:\/\/www.linkedin.com\/countserv\/count\/share?url=%%URL%%&format=json\",\"count_parameter\":\"count\",\"cutsom_data\":\"\",\"use_regex\":false,\"icon\":\"fa-linkedin\",\"shape_background_color\":\"#1B86BD\",\"icon_text_color\":\"#1B86BD\"},\"fssb_google_plus\":{\"enabled\":0,\"title\":\"Google Plus\",\"share_url\":\"https:\/\/plus.google.com\/share?url=%%URL%%\",\"shares_count_url\":\"https:\/\/plusone.google.com\/u\/0\/_\/+1\/fastbutton?count=true&url=%%URL%%\",\"count_parameter\":\"Lio8ZGl2IGlkPSJhZ2dyZWdhdGVDb3VudCIgY2xhc3M9Ii4rIj4oXHcrKTxcL2Rpdj4uKg==\",\"cutsom_data\":\"\",\"use_regex\":true,\"icon\":\"fa-google-plus-official\",\"shape_background_color\":\"#DB4437\",\"icon_text_color\":\"#DB4437\"},\"fssb_vk\":{\"enabled\":0,\"title\":\"VK\",\"share_url\":\"http:\/\/vk.com\/share.php?url=%%URL%%\",\"shares_count_url\":\"http:\/\/vk.com\/share.php?act=count&url=%%URL%%\",\"count_parameter\":\"VksuU2hhcmUuY291bnRcKFxkKywgKFxkKylcKTs=\",\"cutsom_data\":\"\",\"use_regex\":true,\"icon\":\"fa-vk\",\"shape_background_color\":\"#517397\",\"icon_text_color\":\"#517397\"},\"fssb_twitter\":{\"enabled\":1,\"title\":\"Twitter\",\"share_url\":\"https:\/\/twitter.com\/intent\/tweet?text=%%PAGE_TITLE%% %%URL%%\",\"shares_count_url\":\"http:\/\/cdn.api.twitter.com\/1\/urls\/count.json?url=%%URL%%\",\"count_parameter\":\"count\",\"cutsom_data\":\"\",\"use_regex\":false,\"icon\":\"fa-twitter\",\"shape_background_color\":\"#517397\",\"icon_text_color\":\"#00B6F1\"}}"
            ];
}