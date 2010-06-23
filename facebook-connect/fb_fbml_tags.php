<?php
    /**
    *   @author Anuj Chauhan <anuj@arcgate.com>
    */

    class FbmlTags
    {
        private $app_id;
        private $href;
        private $event_id;

	function __construct()
        {
            $this->app_id = FB_APPID;
            $this->href = FB_SITE_HREF;
            $this->event_id = FB_EVENT_ID;
	}

        /**
        *   Facebook Like button.
        */
	public function fbc_get_like_button($href)
        {
	    if($href)
            {
                $like_button = '<fb:like href="'.$href.'"></fb:like>';
            }
	    else
            {
                $like_button = '<fb:like></fb:like>';
            }
	    return $like_button;
	}

        /**
        *   Facebook Login button
        */
	public function fbc_get_login_button()
        {
            $wp_user = wp_get_current_user();
	    if(!empty($wp_user))
            {
                $login_button = $wp_user->first_name . " " .$wp_user->last_name;
	    }
	    $login_button .= '<fb:login-button autologoutlink="true" perms="read_stream,offline_access,publish_stream,email,status_update" size="large" background="light"></fb:login-button>';
	    return $login_button;
	}

        /**
        *   Facebook Recommendation block.
        */
	public function fbc_get_recommendation_block()
        {
	    $recommendation_block = '<fb:recommendations site="'.get_option('site_url').'" width="300" header="false"></fb:recommendations>';
	    return $recommendation_block;
	}

        /**
        *   Facebook Share button
        */
	public function fbc_get_share_button($url)
        {
	    $share_button = '<fb:share-button href="'.$url.'" type="button_count"></fb:share-button>';
	    return $share_button;
	}

        /**
        *   Facebook Activity block.
        */
	public function fbc_get_activity_block()
        {
            $activity_block = '<fb:activity site="'.get_option('site_url').'" width="280"></fb:activity>';
            return $activity_block;
	}

        /**
        *   Facebook Comments block
        */
	public function fbc_get_comments_block()
        {
	    $comments_block = '<fb:comments></fb:comments>';
	    return $comments_block;
	}

        /**
        *   Facebook LiveStream functionality.
        */
        public function fbc_get_live_stream_block()
        {
            $live_stream = '<fb:live-stream event_app_id="'.$this->event_id.'" width="280"></fb:live-stream>';
	    return $live_stream;
	}

        /**
        *   Facebook Javascript Code.
        *   Gets Added in wp-footer.
        */
	public function fbc_fbml_js()
        {
	    $facebook_js = "<div id='fb-root'></div>
                            <script>
				window.fbAsyncInit = function()
                                {
                                    FB.init({appId: ". FB_APPID .", status: true, cookie: true,xfbml: true});
				};
				(function()
                                {
                                    var e = document.createElement('script'); e.async = true;
                                    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
                                    document.getElementById('fb-root').appendChild(e);
				}());
                            </script>";
	    echo $facebook_js;
	}

        /**
        *   Function to render like button in content posts.
        *   @param $content string post content.
        *   @return string return content.
        */
	public function fbc_the_fshare_content($content)
        {
	    global $post;
	    if(!is_page())
            {
                $url = get_permalink($post->ID);
		$content .= '<div class="fbconnect_head_share">';
		if(get_option('fbc_enable_flike'))
                {
                    $content .= FbmlTags::fbc_get_like_button($url);
                }
		if(get_option('fbc_enable_fshare'))
                {
                    $content .= FbmlTags::fbc_get_share_button($url);
                }
		$content .=  '</div>';
	    }
	    return $content;
	}

        /**
        *   function to render XFBML tag in head part
        *   @param $html string doctype
        *   @return string return doctype
        */
	public function fbc_set_xfbml_tag($html)
        {
            return "xmlns:fb=\"http://www.facebook.com/2008/fbml\" ".$html;
	}

        /**
        *   Function to render Recommendation Block in Sidebar.
        *   @param $args Array sidebar widget arguments.
        *   @return string return sidebar block.
        */
	public function fbc_recommendation_widget($args)
        {
            extract($args);
	    $rec_widget = $before_widget;
	    $rec_widget .= $before_title.'<div class="headline_box"><h2 class="headline">Recommended for you</h2></div><div id="side_box">';
	    $rec_widget .= $after_title;
	    $rec_widget .= FbmlTags::fbc_get_recommendation_block();
	    $rec_widget .= '</div>'.$after_widget;
	    echo $rec_widget;
	}

        /**
        *   Function to render Activity Block in Sidebar.
        *   @param $args Array sidebar widget arguments.
        *   @return string return sidebar block.
        */
	public function fbc_activity_widget($args)
        {
	    extract($args);
	    $act_widget = $before_widget;
            $act_widget .= $before_title;
            $act_widget .= "Facebook Activity";
            $act_widget .= $after_title;
            $act_widget .= FbmlTags::fbc_get_activity_block();
            $act_widget .= $after_widget;
            echo $act_widget;
	}

        /**
        *   Function to render Login Block in Sidebar.
        *   @param $args Array sidebar widget arguments.
        *   @return string return sidebar block.
        */
	public function fbc_login_widget($args)
        {
            extract($args);
            $act_widget = $before_widget;
            $act_widget .= $before_title ."Facebook Login";
            $act_widget .= $after_title;
            $act_widget .= FbmlTags::fbc_get_login_button();
            $act_widget .= $after_widget;
            echo $act_widget;
	}
    }

    // Creating A Global Object.
    global $fbml_tags;
    $fbml_tags = new FbmlTags();
?>