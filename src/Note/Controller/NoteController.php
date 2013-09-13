<?php

namespace Note\Controller;

use Note\Model\Note;
use Note\Model\Search;

class NoteController extends \PublicController
{
	public function before()
	{}

	public function index()
	{
		$options = array(
		    'total_items'       => Note::count(),
		    'url'               => 'note/index',
		    'items_per_page'    => 2,
		    'uri_segment'		=> 3
		);

		$pagination = \Pagination::create($options);

		$notes = Note::orderBy('created_at', 'desc')
						->skip(\Pagination::offset())
						->take(\Pagination::limit())
						->get();

		// If $notes is not empty, get external fields
		// \Field::getAll('relation', $modelCollection, 'custom key for external field')
		// Default field's key is extended_fields
		// 'fields' is name of set form our NoteModel
		if (!$notes->isEmpty()) {
			$notes = \Field::getAll('note', $notes, 'fields');
		}

		$this->template->title('Note Index')
						->set('notes', $notes)
						->set('pagi', $pagination)
						->setPartial('index');
	}

	public function search()
	{
		$k = \Input::get('q');

		$s = Note::make('notkes')
						->contain('title', $k)
						->asc('id')
						->get();

		foreach ($s as $r) {
			echo 'Search Results :';
			echo $r->title;
			echo '<br>';
		}

		$all = Note::orderBy('title', 'desc')->get();
		foreach ($all as $r) {
			echo 'All Results :';
			echo $r->title;
			echo '<br>';
		}
		exit;
	}

	public function create()
	{
		$note = new Note();

		// Get Field's Form Field UI for this module
		// You can render this view in your form view's anywhere using {{ loop }}
		$fields = \Field::getForm('note');

		if (\Input::isPost()) {
			$note->title = \Input::get('title');
			$note->body = \Input::get('body');
			$note->author_id = 1;
			if($note->save()) {

				// Save External Field ('relation_name', $model)
				if(\Field::save('note', $note)) {
					\Flash::success('Save is OK');
				} else {
					//$note->delete();
					dump('Field save fail');
				}

			}
		}

		$this->template->title('Note Form')
						->set('note', $note)
						->set('external', $fields)
						->set('url', 'create')
						->setPartial('form');
	}

	public function edit($id)
	{
		$note = Note::find($id);

		// Get Field's Form Field UI for this module
		// You can render this view in your form view's anywhere using {{ loop }}
		// OK. this is edit state
		// So we pass our model to Field::getForm()
		$fields = \Field::getForm('note', $note);

		if (\Input::isPost()) {
			$note->name = \Input::get('name');
			$note->note = \Input::get('note');
			if($note->save()) {

				// Update External Field ('relation_name', $model)
				\Field::update('note', $note);

				\Flash::success('Save is OK');

			} else {
				//$note->delete();
				dump('Fail');
			}
		}

		$this->template->title('Note Form')
						->set('note', $note)
						->set('external', $fields)
						->set('url', 'edit/'.$note->id)
						->setPartial('form');
	}

	public function delete($id)
	{
		$note = Note::find($id);

		// First we delete external field
		// Notice:: Field::delete() must be call before NoteModel::delete()
		\Field::delete('note', $note);

		$note->delete();

		return \Response::to('note');
	}

	public function view($id)
	{
		$note = Note::find($id);

		// Get Field data
		// ReAssign our model form Field::get() result
		$note = \Field::get('note', $note, 'fields');

		$this->template->title('Note Single')
						->set('note', $note)
						->setPartial('single');
	}

	public function after($response)
	{
		return parent::after($response);
	}
}
