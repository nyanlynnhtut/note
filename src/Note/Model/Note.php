<?php

namespace Note\Model;

use Reborn\MVC\Model\Search as Base;

class Note extends Base
{
    protected $table = 'notes';

    // Validation rules
    protected $rules = array(
    		'title' => 'required|maxLength:250',
    		'body' => 'required'
    	);

    protected $per_page = 2;

    // for custom fields
    public $fields;

}
