<?php
/*
Plugin Name: Nefertem Goodreads API
Plugin URI: https://github.com/mfloryan/nefertem/tree/master/wordpress/plugins/
Description: Allows to pull books from goodreads shelfs
Version: 1.0
Author: Marcin Floryan
Author URI: http://marcin.floryan.pl/
License: GPLv2

    Copyright 2011 Marcin Floryan (email : mfloryan@mm.waw.pl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function goodreads_shortcode_handler( $attributes, $content = null ) {
    $goodreads = new Nefertem_Goodreads($attributes);
    return $goodreads->getContent();
}

class Nefertem_Goodreads {

    const goodreadsApi = 'http://www.goodreads.com/review/list/';

    private $apiKey = 'imjnFTUP1wilIH0idWffMw'; //TODO: From Settings
    private $goodReadsUserid = "2924969"; //TODO: From Settings
    private $shelfName;
    private $perPage = 5;
    private $sort;

    function __construct($attributes) {
        $shelf = $attributes['shelf'];
        switch ($shelf) {
            case "currently-reading":
                $this->shelfName = 'currently-reading';
                $this->perPage = 10;
                $this->sort = 'position';
                break;
            case "to-read";
                $this->shelfName = 'to-read';
                $this->perPage = 5;
                $this->sort = 'position';
                break;
            default:
                $this->shelfName = 'read';
                $this->perPage = 10;
                $this->sort = 'date_read';
                break;
        }
    }

    public function getContent()
    {
        $books = $this->getBooks();
        $html = "";
        $html .= '<ul class="goodreads">';
        foreach ($books->reviews->review as $review) {
            $html .= '<li class="book">';
            // $html .= '<img class="cover" src="'.$review->book->small_image_url . '" />';
            $html .= '<strong>'.$review->book->title.'</strong>';
            if ($review->book->isbn13 != '') {
                $html .= '('. $review->book->isbn13 .')';
            } else if ($review->book->isbn != '') $html .= '('. $review->book->isbn .')';

            $authors = array();
            foreach ($review->book->authors->author as $author) {
                array_push($authors,$author->name);
            }
            unset($author);
            $html .= ' <em>by '.implode(", ",$authors)."</em>";

            if ($review->rating != 0) {
                $html .= ' - gave '.$review->rating.' out of 5';
            }

            $html .= ' <a href="'.$review->link.'"> &raquo; more...</a>';
            $html .= '</li>';
        }


        $html .= '</ul>';
        //$html .= '<pre>'.print_r($review,true).'</pre>';
        unset($review);
        return $html;
    }

    private function getBooks() {
        return new SimpleXMLElement($this->getBookXml());
    }

    private function getBookXml()
    {
        $booksXml = $this->getBooksXmlFromCache();
        if (is_null($booksXml)) {
            $booksXml = $this->getBooksXmlFromWeb();
        }
        return $booksXml;
    }

    private function getBooksXmlFromWeb()
    {
        $webResponse = wp_remote_get($this->getUrl());
        if ($webResponse['response']['code'] == 200) {

            $content = $webResponse['body'];
            $this->setBooksXmlToCache($content);
            return $content;
        }
    }

    private function getBooksXmlFromCache()
    {
        if (false === ($content = get_transient($this->getTransientName()))) {
            return null;
        }
        return $content;
    }

    private function setBooksXmlToCache($content)
    {
        $cacheTimeToLive = 60 * 60 * 12; //12h
        set_transient($this->getTransientName(),$content, $cacheTimeToLive);
    }

    private function getTransientName()
    {
        return 'nefertem-goodreads-' . get_the_ID() . '-' . strtolower($this->shelfName);
    }

    private function getUrl()
    {
        $url = Nefertem_Goodreads::goodreadsApi;
        $url .= $this->goodReadsUserid;
        $url .= "xml?";
        $url .= http_build_query(
            array(  'key' => $this->apiKey,
                    'v' => 2,
                    'page' => 1,
                    'shelf' => $this->shelfName,
                    'per_page' => $this->perPage,
                    'sort' => $this->sort
                )
        );
        return $url;
    }
}

add_shortcode( 'goodreads', 'goodreads_shortcode_handler' );
?>