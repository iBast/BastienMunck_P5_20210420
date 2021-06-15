<?php

namespace Core\Http;


/**
 * Paginator, paginate result from query
 * 
 * use 'LIMIT $perPage OFFSET $offset' in Table request
 */
class Paginator
{
    private $error = false;
    protected $currentPage;
    protected $pages;
    protected $perPage;

    public function __construct($request, $flash)
    {
        $this->request = $request;
        $this->flash = $flash;
    }

    /**
     * isError set error
     *
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    public function setOffset($perPage, int $count)
    {
        $page = $this->request->getGetValue('page') ?? 1;

        if (!filter_var($page, FILTER_SANITIZE_NUMBER_INT)) {
            $this->flash->danger('La page demandé n\'existe pas');
            return $this->error = true;
        }

        $this->currentPage = (int)$page;
        if ($this->currentPage <= 0) {
            $this->flash->danger('La page demandé n\'existe pas');
            return $this->error = true;
        }
        $this->pages = ceil($count / $perPage);
        if ($this->currentPage > $this->pages) {
            $this->flash->danger('La page demandé n\'existe pas');
            return $this->error = true;
        }
        return $perPage * ($this->currentPage - 1);
    }

    public function getPage()
    {
        if ($this->request->hasGetValue('page')) {
            return $this->request->getGetValue('page');
        }
        return 1;
    }

    public function printCommands($link)
    {
        $html =  "<div class='paging'>";
        if ($this->currentPage > 1) {
            if ($this->currentPage > 2) {
                $linkprev = '&page=' . ($this->currentPage - 1);
            } else {
                $linkprev = null;
            }
            $html .= "<a href='{$link}{$linkprev}' class='btn btn-main'>&laquo; Page précédente</a>";
        }
        if ($this->currentPage < $this->pages) {
            $linkfor = '&page=' . ($this->currentPage + 1);
            $html .= "<a href='{$link}{$linkfor}' class='btn btn-main ml-auto'>Page suivante &raquo;</a>";
        }
        $html .= "</div>";
        return $html;
    }

    public function setPerPage($number)
    {
        $this->perPage = $number;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }
}
