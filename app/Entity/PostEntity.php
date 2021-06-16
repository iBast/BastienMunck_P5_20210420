<?php

namespace App\Entity;

use Core\Entity\Entity;

class PostEntity extends Entity
{
    public function getUrl()
    {
        return 'index.php?p=blog.show&id=' . $this->id;
    }
}
