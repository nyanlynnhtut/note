<?php

namespace Note;

class NoteInfo extends \Reborn\Module\AbstractInfo
{
	protected $name = 'Note';

	protected $version = '1.0';

	protected $displayName = array(
								'en' => 'Note'
								);

	protected $description = array(
							'en' => 'Note Saving'
							);

	protected $author = 'Nyan Lynn Htut';

	protected $authorUrl = 'http://reborncms.com';

	protected $authorEmail = 'lynnhtut87@gmail.com';

	protected $frontendSupport = true;

	protected $backendSupport = true;

	protected $useAsDefaultModule = false;

	protected $uriPrefix = 'note';

	protected $allowToChangeUriPrefix = false;

	protected $allow_customfield = true;

}
