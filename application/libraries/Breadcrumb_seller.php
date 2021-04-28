<?php
/**
 * Library for generating breadcrumbs.
 * 
 * @author		agussuwerdo
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Breadcrumb_seller
{
    private $breadcrumbs = array();
    private $tags = array();
    private $title = "";
    private $title_nav = "";
    private $sub_title = "";

    function __construct()
    {
        $this->tags['open'] = '<ol class="breadcrumb float-sm-right">';
        $this->tags['close'] = '</ol>';
        $this->tags['itemOpen'] = '<li class="breadcrumb-item">';
        $this->tags['itemClose'] = '</li>';
    }

    function add($title, $href)
    {
        // if (!$title or !$href) return;
        $this->breadcrumbs[] = array('title' => $title, 'href' => $href);
    }

    function getBreadcrumbCount()
    {
        return count($this->breadcrumbs);
    }

    function openTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['open'];
        } else {
            $this->tags['open'] = $tags;
        }
    }

    function closeTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['close'];
        } else {
            $this->tags['close'] = $tags;
        }
    }

    function itemOpenTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemOpen'];
        } else {
            $this->tags['itemOpen'] = $tags;
        }
    }

    function itemCloseTage($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemClose'];
        } else {
            $this->tags['itemClose'] = $tags;
        }
    }

    function render()
    {
        if (!empty($this->tags['open'])) {
            $output = $this->tags['open'];
        } else {
            $output = '<ol class="breadcrumb float-sm-right">';
        }
        $output .= '
        <li>
            <a href="'.base_url('seller').'">
                <i class="fa fa-home"></i>
            </a>
        </li>';
        $count = count($this->breadcrumbs) - 1;
        foreach ($this->breadcrumbs as $index => $breadcrumb) {
            $breadcrumb_title = '<span>' . $breadcrumb['title'] . '</span>';
            $breadcrumb_href = $breadcrumb['href']?:'javascript:void(0)';
            if ($index == $count) {
                $output .= '<li class="breadcrumb-item active">';
                $output .= ''.$breadcrumb_title.'';
                $output .= '</li>';
            } else {
                $output .= ($this->tags['itemOpen']) ? $this->tags['itemOpen'] : '<li>';
                $output .= '<a href="' . $breadcrumb_href . '">';
                $output .= $breadcrumb_title;
                $output .= '</a>';
                $output .= '</li>';
            }
        }

        if (!empty($this->tags['open'])) {
            $output .= $this->tags['close'];
        } else {
            $output .= "</ol>";
        }

        return $output;
    }

    function set_title($title = '')
    {
        $this->title = $title;
    }

    function set_title_nav($title_nav = '')
    {
        $this->title_nav = $title_nav;
    }

    function set_sub_title($sub_title)
    {
        $this->sub_title = $sub_title;
    }

    function get_title()
    {
        return $this->title;
    }

    function get_title_nav()
    {
        return $this->title_nav;
    }

    function get_sub_title()
    {
        return $this->sub_title;
    }
}
