<?php

namespace App\Core;

class Paginator
{

    /**
     * Holds the result count
     *
     * @var int
     */
    public $count = 0;

    /**
     * Holds the page offset
     *
     * @var int
     */
     public $page = 1;

    /**
     * Holds the page limit
     *
     * @var int
     */
    public $perpage = 10;

    /**
     * Holds the translated label for the first page link
     *
     * @var string
     */
    public $first;

    /**
     * Holds the translated label for the last page link
     *
     * @var string
     */
    public $last;

    /**
     * Holds the translated label for the next page link
     *
     * @var string
     */
    public $next;

    /**
     * Holds the translated label for the previous page link
     *
     * @var string
     */
    public $prev;

    /**
     * Holds the URL to paginate
     *
     * @var string
     */
    protected $url;

    /**
     * @param int    $count   result count
     * @param int    $page    page offset
     * @param int    $perpage page limit
     * @param string $url     base URL
     */
    public function __construct($count, $page, $perpage, $url)
    {
        $this->count   = $count;
        $this->page    = $page;
        $this->perpage = $perpage;
        // $this->url     = rtrim($url, '/');
        $this->url     = '/' . $url;

        $this->first = 'First page';
        $this->last  = 'Last Page';
        $this->next  = 'Next';
        $this->prev  = 'Previous';
    }

  /**
   * Generates the previous page link
   *
   * @param string|null $text       (optional) link text
   * @param string      $default    (optional) fallback if no previous page
   * @param array       $attrs      (optional) attributes for the link element
   *
   * @return string
   */
    public function getPreviousLink($text = null, $default = '', $attrs = [])
    {
        if (is_null($text)) {
            $text = $this->next;
        }

        $pages = ceil($this->count / $this->perpage);

        if ($this->page < $pages) {
            $page = $this->page + 1;

            return $this->link($text, array_merge([
                    'href' => $this->url . '/' . $page
                ], $attrs
            ));
        }

        return $default;
    }

  /**
   * Generates a pagination link
   *
   * @param string $text        link text
   * @param array  $attrs       (optional) attributes for the link element
   *
   * @return string
   */
    protected function link($text, $attrs = [])
    {
        $attr = '';

        if (is_string($attrs)) {
            $attr = 'href="' . $attrs . '"';
        } else {
            foreach ($attrs as $key => $val) {
                $attr .= $key . '="' . $val . '" ';
            }
        }

        return '<a class="page-link"' . trim($attr) . '>' . $text . '</a>';
    }

   /**
    * Generates a next page link
    *
    * @param string|null $text    (optional) link text
    * @param string      $default (optional) fallback if no previous page
    * @param array       $attrs   (optional) attributes for the link element
    *
    * @return string
    */
    public function getNextLink($text = null, $default = '', $attrs = [])
    {
        if (is_null($text)) {
            $text = $this->prev;
        }

        if ($this->page > 1) {
            $page = $this->page - 1;

            return $this->link($text, array_merge(
                ['href' => $this->url . '/' . $page], $attrs
            ));
        }

        return $default;
    }

   /**
    * Generates the pagination links
    *
    * @return string
    */
    public function getPagination()
    {
        $html = '';

        if( ! $this->perpage ) {
          return;
        }

        $pages = ceil($this->count / $this->perpage);
        $range = 4;

        if ($pages > 1) {
            if ($this->page > 1) {
                $page = $this->page - 1;

                $html = '<li class="page-item"><a class="page-link" href="' . $this->url . '">' . $this->first . '</a></li>';
                $html .= '<li class="page-item"><a class="page-link" href="' . $this->url . '/' . $page . '">' . $this->prev . '</a></li>';
            }

            for ($i = $this->page - $range; $i < $this->page + $range; $i++) {
                if ($i < 0) {
                    continue;
                }

                $page = $i + 1;

                if ($page > $pages) {
                    break;
                }

                if ($page == $this->page) {
                    $html .= '<li class="page-item active"><a class="page-link">' . $page . '</a></li> ';
                } else {
                    $html .= '<li class="page-item">' . $this->link($page, $this->url . '/' . $page) . '</li>';
                }
            }

            if ($this->page < $pages) {
                $page = $this->page + 1;

                $html .= '<li class="page-item">' . $this->link($this->next, $this->url . '/' . $page) . '</li>';
                $html .= '<li class="page-item">' . $this->link($this->last, $this->url . '/' . $pages) . '</li>';
            }
        }

        return sprintf('<nav><ul class="pagination justify-content-center">%s</ul></nav>', $html);
    }
}
