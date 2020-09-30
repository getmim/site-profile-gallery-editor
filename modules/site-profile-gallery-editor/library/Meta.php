<?php
/**
 * Meta
 * @package site-profile-gallery-editor
 * @version 0.0.1
 */

namespace SiteProfileGalleryEditor\Library;


class Meta
{
    static function single(){
        $result = [
            'head' => [],
            'foot' => []
        ];
        
        $page = (object)[
            'title'         => 'Gallery Editor',
            'description'   => 'Gallery Editor',
            'schema'        => 'WebSite',
            'keyword'       => '',
            'page'          => \Mim::$app->req->url
        ];

        $result['head'] = [
            'description'       => $page->description,
            'schema.org'        => [],
            'type'              => 'article',
            'title'             => $page->title,
            'url'               => $page->page,
            'metas'             => []
        ];

        return $result;
    }
}