<?php
/*
Plugin Name: Nefertem Twitter Widget
Plugin URI: https://github.com/mfloryan/nefertem/tree/master/wordpress/plugins/
Description: A simple twitter widget based on Twitter Widget Pro and Wickett Twitter Widget
Version: 1.0
Author: Marcin Floryan
Author URI: http://marcin.floryan.pl/
License: GPLv2

This is the free Twitter (Jetpack) widget extended by Marcin Floryan for Nefertem

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( !function_exists('wpcom_time_since') ) :
/*
 * Time since function taken from WordPress.com
 */

function wpcom_time_since( $original, $do_more = 0 ) {
	// array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365 , 'year' ),
		array( 60 * 60 * 24 * 30 , 'month' ),
		array( 60 * 60 * 24 * 7, 'week' ),
		array( 60 * 60 * 24 , 'day' ),
		array( 60 * 60 , 'hour' ),
		array( 60 , 'minute' ),
	);

	$today = time();
	$since = $today - $original;

	for ( $i = 0, $j = count( $chunks ); $i < $j; $i++ ) {
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];

		if ( ( $count = floor( $since / $seconds ) ) != 0 )
			break;
	}

	$print = ( $count == 1 ) ? '1 ' . $name : "$count {$name}s";

	if ( $i + 1 < $j ) {
		$seconds2 = $chunks[$i + 1][0];
		$name2 = $chunks[$i + 1][1];

		// add second item if it's greater than 0
		if ( ( ( $count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2 ) ) != 0 ) && $do_more )
			$print .= ( $count2 == 1 ) ? ', 1 ' . $name2 : ", $count2 {$name2}s";
	}
	return $print;
}

endif;

class Nefertem_Twitter_Widget_Settings {
    public $screen_name;
    public $title = "On Twitter";
    public $max_count = 10;
    public $hideReplies = false;
    public $includeRetweets = true;
    public $showFollowButton = false;
    public $showIntents = false;

    const SCREEN_NAME = 'screen_name';
    const TITLE = 'title';
    const MAX_COUNT = 'max_count';
    const HIDEREPLIES = 'hidereplies';
    const INCLUDERETWEETS = 'includeretweets';
    const SHOW_FOLLOW_BUTTON = 'showfollowbutton';
    const SHOW_INTENTS = 'showintents';

    public function __construct($instance) {
        if ($instance != null) {
            $this->screen_name = $instance[self::SCREEN_NAME];
            $this->title = $instance[self::TITLE];
            $this->max_count = $instance[self::MAX_COUNT];
            $this->hideReplies = $instance[self::HIDEREPLIES];
            $this->includeRetweets = $instance[self::INCLUDERETWEETS];
            $this->showFollowButton = $instance[self::SHOW_FOLLOW_BUTTON];
            $this->showIntents = $instance[self::SHOW_INTENTS];
        }
    }

    function ScreenName() {
        return trim(urlencode($this->screen_name));
    }

    function MaxCount() {
        $count = absint($this->max_count);
        if ($count > 200) return 200;
        return $count;
    }

    static function update($old_instance, $new_instance) {

        $instance = $old_instance;

        $account = trim( strip_tags( stripslashes( $new_instance[self::SCREEN_NAME] ) ) );
        $account = str_replace( 'http://twitter.com/', '', $account );
        $account = str_replace( '/', '', $account );
        $account = str_replace( '@', '', $account );
        $account = str_replace( '#!', '', $account ); // account for the Ajax URI

        $instance[self::SCREEN_NAME] = $account;
        $instance[self::TITLE] = strip_tags( stripslashes( $new_instance[self::TITLE] ) );
        $instance[self::MAX_COUNT] = absint( $new_instance[self::MAX_COUNT] );
        $instance[self::HIDEREPLIES] = isset( $new_instance[self::HIDEREPLIES] );
        $instance[self::INCLUDERETWEETS] = isset( $new_instance[self::INCLUDERETWEETS] );
        $instance[self::SHOW_FOLLOW_BUTTON] = isset( $new_instance[self::SHOW_FOLLOW_BUTTON] );
        $instance[self::SHOW_INTENTS] = isset( $new_instance[self::SHOW_INTENTS] );

        return $instance;
    }
}

class Nefertem_Twitter_Widget extends WP_Widget {

	function Nefertem_Twitter_Widget() {
		$widget_ops = array( 'classname' => 'widget_twitter', 'description' => __( 'Display your tweets from Twitter', 'nefertem' ) );
		parent::WP_Widget( 'nefertem-twitter', __( 'Twitter (Nefertem)', 'nefertem' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

        $settings = new Nefertem_Twitter_Widget_Settings($instance);

		$account = $settings->ScreenName();
		if ( empty($account) ) return;

		$title = apply_filters( 'widget_title', $settings->title );

		$show = $settings->max_count;  // # of Updates to show
		if ( $show > 200 ) // Twitter paginates at 200 max tweets. update() should not have accepted greater than 20
			$show = 200;

        $hidereplies = (bool) $settings->hideReplies;
		$include_retweets = (bool) $settings->includeRetweets;

        if ($settings->showIntents || $settings->showFollowButton) {
            wp_enqueue_script('twitter-widgets', 'http://platform.twitter.com/widgets.js', array(), '1.0.0', true);
        }

        echo "$before_widget";
        echo "{$before_title}<a href='" . esc_url( "http://twitter.com/{$account}" ) . "'>" . esc_html($title) . "</a>{$after_title}";

        $tweets = $this->get_tweets($account, $show, $hidereplies);

        if ( 'error' != $tweets ) {

            if (isset($instance['beforetweet']) && !empty($instance['beforetweet'])) {
                $before_tweet = stripslashes(wp_filter_post_kses($instance['beforetweet']));
            }
            else {
                $before_tweet = '';
            }

			echo "<ul class=\"tweets\">\n";

			$tweets_out = 0;

			foreach ( (array) $tweets as $tweet ) {
				if ( $tweets_out >= $show )
					break;

				if ( empty( $tweet['text'] ) )
					continue;

				// Add LINKS from entities
                $text = $this->get_text_with_links_from_entities($tweet);

				if ( isset( $tweet['id_str'] ) ) $tweet_id = urlencode( $tweet['id_str'] );
				else $tweet_id = urlencode( $tweet['id'] );

                $created_at = str_replace( '+0000', '', $tweet['created_at'] ) . ' UTC'; // Twitter's datetime format is strange, refactor for the sake of PHP4

                echo "<li>";

                echo $before_tweet;
                echo $text;
                echo "<span class=\"meta\"><a href=\"" . esc_url( "http://twitter.com/{$account}/statuses/{$tweet_id}" ) . '" title="'. $created_at .'" class="timesince">' . str_replace( ' ', '&nbsp;', wpcom_time_since( strtotime( $created_at ) ) ) ."&nbsp;ago</a>";

                if ( 'true' == $settings->showIntents ) {
                    echo '<span class="intent-meta">';
                    echo "<a href=\"http://twitter.com/intent/favorite?tweet_id={$tweet_id}\" title=\"Favourite\" class=\"favorite\">Favourite</a>";
                    echo "<a href=\"http://twitter.com/intent/retweet?tweet_id={$tweet_id}\" title=\"Retweet\" class=\"retweet\">Retweet</a>";
                    echo "<a href=\"http://twitter.com/intent/tweet?in_reply_to={$tweet_id}\" title=\"Reply\" class=\"in-reply-to\">Reply</a>";
                    echo '</span>';
                }
                echo '</span>';



                echo "</li>\n";

                unset( $tweet_id );
				$tweets_out++;
			}

            echo "</ul>\n";

            if ($settings->showFollowButton) {
                echo '<div class="follow-button">';
                echo "<a href=\"http://twitter.com/$account\" class=\"twitter-follow-button\" title=\"Follow $account\" data-lang=\"en\">@{$account}</a>";
                echo '</div>';
            }


        } else  {
            if ( 401 == get_transient( 'widget-twitter-response-code-' . $this->number ) )
         				echo '<p>' . wp_kses( sprintf( __( 'Error: Please make sure the Twitter account is <a href="%s">public</a>.', 'nefertem' ), 'http://support.twitter.com/forums/10711/entries/14016' ), array( 'a' => array( 'href' => true ) ) ) . '</p>';
         			else
         				echo '<p>' . esc_html__( 'Error: Twitter did not respond. Please wait a few minutes and refresh this page.', 'nefertem' ) . '</p>';
        }

		echo $after_widget;
	}

    private function get_text_with_links_from_entities($tweet) {
        if (!isset($tweet['entities'])) return $tweet['text'];

        $text = $tweet['text'];

        $replacements = array();

        foreach ($tweet['entities']['user_mentions'] as $entity) {
            $replacements[$entity['indices'][0]] =
                array(  "len"       => $entity['indices'][1] - $entity['indices'][1],
                        "end"       => $entity['indices'][1],
                        "content" => "<a href=\"http://twitter.com/${entity['screen_name']}\" title=\"${entity['name']}\">@${entity['screen_name']}</a>");
        }
        unset($entity);

        foreach ($tweet['entities']['hashtags'] as $entity) {
            $replacements[$entity['indices'][0]] =
                array(  "len"       => $entity['indices'][1] - $entity['indices'][1],
                        "end"       => $entity['indices'][1],
                        "content" => "<a rel=\"search\" href=\"http://twitter.com/search?q=".urlencode('#'.$entity['text'])."\" title=\"${entity['text']}\">#${entity['text']}</a>");
        }
        unset($entity);

        foreach ($tweet['entities']['urls'] as $entity) {
            $replacements[$entity['indices'][0]] =
                array(  "len"       => $entity['indices'][1] - $entity['indices'][1],
                        "end"       => $entity['indices'][1],
                        "content" => "<a href=\"".(empty($entity['expanded_url'])?$entity['url']:$entity['expanded_url'])."\">".(empty($entity['display_url'])?$entity['url']:$entity['display_url'])."</a>");
        }
        unset($entity);

        if (is_array($tweet['entities']['media'])) {
            foreach ($tweet['entities']['media'] as $entity) {
                $replacements[$entity['indices'][0]] =
                   array(  "len"       => $entity['indices'][1] - $entity['indices'][1],
                           "end"       => $entity['indices'][1],
                           "content" => "<a class=\"media\" data-image=\"${entity['media_url']}\" href=\"".(empty($entity['expanded_url'])?$entity['url']:$entity['expanded_url'])." \">${entity['display_url']}</a>");
            }
            unset($entity);
        }

        $newText = "";
        $lastEntityEnded = 0;

        ksort($replacements);
        foreach ($replacements as $position => $replacement) {
            $newText .= substr($text, $lastEntityEnded, $position - $lastEntityEnded);
            $newText .= $replacement['content'];
            $lastEntityEnded = $replacement['end'];
        }
        unset($replacement);

        $newText .= substr($text,$lastEntityEnded);

        return $newText;
    }

    private function get_tweets($account, $show, $hidereplies)
    {
        if (false === ($tweets = get_transient('widget-twitter-' . $this->number))) {
            $params = array(
                'screen_name' => $account, // Twitter account name
                'trim_user' => true, // only basic user data (slims the result)
                'include_entities' => true,
                'include_rts' => true,
                'count' => $show
            );

            /**
             * The exclude_replies parameter filters out replies on the server. If combined with count it only filters that number of tweets (not all tweets up to the requested count)
             * If we are not filtering out replies then we should specify our requested tweet count
             */
            if ($hidereplies) $params['exclude_replies'] = true;

            $twitter_json_url = esc_url_raw('http://api.twitter.com/1/statuses/user_timeline.json?' . http_build_query($params), array('https', 'http'));
            unset($params);
            $response = wp_remote_get($twitter_json_url, array('User-Agent' => 'WordPress.com Twitter Widget (Nefertem)'));
            $response_code = wp_remote_retrieve_response_code($response);
            if (200 == $response_code) {
                $tweets = wp_remote_retrieve_body($response);
                $tweets = json_decode($tweets, true);
                $expire = 900;
                if (!is_array($tweets) || isset($tweets['error'])) {
                    $tweets = 'error';
                    $expire = 300;
                }
            } else {
                $tweets = 'error';
                $expire = 300;
                set_transient('widget-twitter-response-code-' . $this->number, $response_code, $expire);
            }

            set_transient('widget-twitter-' . $this->number, $tweets, $expire);
            return $tweets;
        }
        return $tweets;
    }

    function update( $new_instance, $old_instance ) {

		delete_transient( 'widget-twitter-' . $this->number );
		delete_transient( 'widget-twitter-response-code-' . $this->number );

		return Nefertem_Twitter_Widget_Settings::update($old_instance, $new_instance);
	}

	function form( $instance ) {
        $settings = new Nefertem_Twitter_Widget_Settings($instance);

		$account = esc_attr( $settings->screen_name );
		$title = esc_attr( $settings->title );
		$show = $settings->MaxCount();
		if ( $show < 1 || $show > 20) $show = 5;
		$hidereplies = (bool) $settings->hideReplies;
		$include_retweets = (bool) $settings->includeRetweets;
        $show_follow_button = (bool) $settings->showFollowButton;

		echo '<p><label for="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::TITLE ) . '">' . esc_html__( 'Title:', 'nefertem' ) . '
		<input class="widefat" id="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::TITLE ) . '" name="' . $this->get_field_name( Nefertem_Twitter_Widget_Settings::TITLE ) . '" type="text" value="' . $title . '" />
		</label></p>
		<p><label for="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::SCREEN_NAME ) . '">' . esc_html__( 'Twitter username:', 'nefertem' ) . ' <a href="http://support.wordpress.com/widgets/twitter-widget/#twitter-username" target="_blank">( ? )</a>
		<input class="widefat" id="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::SCREEN_NAME ) . '" name="' . $this->get_field_name(Nefertem_Twitter_Widget_Settings::SCREEN_NAME ) . '" type="text" value="' . $account . '" />
		</label></p>
		<p><label for="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::MAX_COUNT ) . '">' . esc_html__( 'Maximum number of tweets to show:', 'nefertem' ) . '
			<select id="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::MAX_COUNT ) . '" name="' . $this->get_field_name( Nefertem_Twitter_Widget_Settings::MAX_COUNT ) . '">';

		for ( $i = 1; $i <= 20; ++$i )
			echo "<option value='$i' " . ( $show == $i ? "selected='selected'" : '' ) . ">$i</option>";
		echo '</select>
		</label></p>
		<p><label for="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::HIDEREPLIES ) . '"><input id="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::HIDEREPLIES ) . '" class="checkbox" type="checkbox" name="' . $this->get_field_name( Nefertem_Twitter_Widget_Settings::HIDEREPLIES ) . '"';
		if ( $hidereplies ) echo ' checked="checked"';
		echo ' /> ' . esc_html__( 'Hide replies', 'nefertem' ) . '</label></p>';

		echo '<p><label for="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::INCLUDERETWEETS ) . '"><input id="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::INCLUDERETWEETS ) . '" class="checkbox" type="checkbox" name="' . $this->get_field_name( Nefertem_Twitter_Widget_Settings::INCLUDERETWEETS ) . '"';
		if ( $include_retweets ) echo ' checked="checked"';
		echo ' /> ' . esc_html__( 'Include retweets', 'nefertem' ) . '</label></p>';

        echo '<p><label><input id="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::SHOW_INTENTS) . '" class="checkbox" type="checkbox" name="' . $this->get_field_name( Nefertem_Twitter_Widget_Settings::SHOW_INTENTS ) . '"';
      		if ( $settings->showIntents) echo ' checked="checked"';
      		echo ' /> ' . esc_html__( 'Show intents', 'nefertem' ) . '</label></p>';

        echo '<p><label><input id="' . $this->get_field_id( Nefertem_Twitter_Widget_Settings::SHOW_FOLLOW_BUTTON ) . '" class="checkbox" type="checkbox" name="' . $this->get_field_name( Nefertem_Twitter_Widget_Settings::SHOW_FOLLOW_BUTTON) . '"';
        if ( $show_follow_button ) echo ' checked="checked"';
        echo ' /> ' . esc_html__( 'Show follow button', 'nefertem' ) . '</label></p>';
	}
}

add_action( 'widgets_init', 'nefertem_twitter_widget_init' );
function nefertem_twitter_widget_init() {
	register_widget( 'Nefertem_Twitter_Widget' );
}