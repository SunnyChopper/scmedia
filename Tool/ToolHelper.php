<?php

namespace App\Custom;

use App\Tool;

class ToolHelper {
	/* Private global variables */
	private $id;

	/* Constructor */
	public function __construct($id = 0) {
		$this->id = $id;
	}

	/* Public functions */
	public function create($data) {
		// Get data and save
		$tool = new Tool;
		$tool->title = $data["title"];
		$tool->slug = $data["slug"];
		$tool->description = $data["description"];
		$tool->amount = $data["amount"];
		$tool->featured_image_url = $data["featured_image_url"];
		$tool->plan_id = $data["plan_id"];
		$tool->save();

		// Return the ID of the tool
		return $tool->id;
	}

	public function read($id = 0) {
		// Check to see if no ID passed in
		if ($id == 0) {
			$id = $this->id;
		}

		// Return the tool object
		return Tool::find($id);
	}

	public function update($data) {
		// Get data and update
		$tool = Tool::find($data["tool_id"]);
		$tool->title = $data["title"];
		$tool->slug = $data["slug"];
		$tool->description = $data["description"];
		$tool->amount = $data["amount"];
		$tool->featured_image_url = $data["featured_image_url"];
		$tool->save();
	}

	public function delete($id = 0) {
		// Check to see if no ID passed in
		if ($id == 0) {
			$id = $this->id;
		}

		// Delete
		$tool = Tool::find($id);
		$tool->is_active = 0;
		$tool->save();
	}

	public function get_all() {
		return Tool::where('is_active', 1)->get();
	}

	public function get_with_slug($slug) {
		return Tool::where('slug', $slug)->where('is_active', 1)->get();
	}

	public function get_all_with_pagination($pagination) {
		return Tool::where('is_active', 1)->paginate($pagination);
	}
}