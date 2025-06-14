<?php

namespace PHPFramework;

class Pagination
{

    public int $count_pages = 1;
    public int $current_page = 1;
    public string $uri = '';
    public int $mid_size = 2;
    public int $max_pages = 7;

    public function __construct(
        public int $page = 1,
        public int $per_page = 1,
        public int $total = 1
    )
    {
        $this->count_pages = $this->getCountPages();
        $this->current_page = $this->getCurrentPage();
        $this->uri = $this->getParams();
        $this->mid_size = $this->getMidSize();
    }

    protected function getCountPages(): int
    {
        return (int)ceil($this->total / $this->per_page) ?: 1;
    }

    protected function getCurrentPage(): int
    {
        if (($this->page < 1) || ($this->page > $this->count_pages)) {
            abort();
        }
        return $this->page;
    }

    protected function getParams(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = base_url($url[0]);
        if (isset($url[1]) && !in_array($url[1], ['', '&'])) {
            $uri .= '?';
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!str_contains($param, 'page=')) {
                    $uri .= "{$param}&";
                }
            }
        }
        return $uri;
    }

    protected function getMidSize(): int
    {
        return ($this->count_pages <= $this->max_pages) ? $this->count_pages : $this->mid_size;
    }

    public function getStart(): int
    {
        return ($this->current_page - 1) * $this->per_page;
    }

    public function getHtml(): string
    {
        $back = '';
        $forward = '';
        $start_page = '';
        $end_page = '';
        $pages_left = '';
        $pages_right = '';

        if ($this->current_page > 1) {
            $back = "<li class='page-item'><a href='" . $this->getLink($this->current_page - 1) . "' class='page-link'>&lt;</a></li>";
        }

        if ($this->current_page < $this->count_pages) {
            $forward = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->current_page + 1) . "'>&gt;</a></li>";
        }

        if ($this->current_page > $this->mid_size + 1) {
            $start_page = "<li class='page-item'><a class='page-link' href='" . $this->getLink(1) . "'>&laquo;</a></li>";
        }

        if ($this->current_page < ($this->count_pages - $this->mid_size)) {
            $end_page = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->count_pages) . "'>&raquo;</a></li>";
        }

        for ($i = $this->mid_size; $i > 0; $i--) {
            if ($this->current_page - $i > 0) {
                $pages_left .= "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->current_page - $i) . "'>" . ($this->current_page - $i) . "</a></li>";
            }
        }

        for ($i = 1; $i <= $this->mid_size; $i++) {
            if ($this->current_page + $i <= $this->count_pages) {
                $pages_right .= "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->current_page + $i) . "'>" . ($this->current_page + $i) . "</a></li>";
            }
        }

        return '<nav aria-label="Page navigation example"><ul class="pagination">' . $start_page . $back . $pages_left . '<li class="page-item active"><a class="page-link">' . $this->current_page . '</a></li>' . $pages_right . $forward . $end_page . '</ul></nav>';
    }

    protected function getLink($page): string
    {
        if ($page == 1) {
            return rtrim($this->uri, '?&');
        }

        if (str_contains($this->uri, '&') || str_contains($this->uri, '?')) {
            return "{$this->uri}page={$page}";
        } else {
            return "{$this->uri}?page={$page}";
        }
    }

    public function __toString(): string
    {
        return $this->getHtml();
    }

}