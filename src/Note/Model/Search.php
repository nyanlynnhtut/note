<?php

namespace Note\Model;

use Reborn\MVC\Model\Search as Base;

class Search extends Base
{

	protected $table = 'notes';

	protected $limit = 4;
}
