<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Custom\ToolHelper;

use Auth;
use Session;

use App\User;

class ToolsController extends Controller
{

    /* Public Basic CRUD Functions */
    public function create(Request $data) {
        // Get data and create
    	$tool_helper = new ToolHelper();
    	$tool_data = array(
    		"title" => $data->title,
            "slug" => $data->slug,
            "description" => $data->description,
            "amount" => $data->amount,
    		"featured_image_url" => $data->featured_image_url,
            "plan_id" => $data->plan_id
    	);
    	$tool_helper->create($tool_data);

        // Redirect to admin view
    	return redirect(url('/admin/tools/view'));
    }

    public function read($slug) {
        // Get tool
        $tool_helper = new ToolHelper();
        $tool = $tool_helper->get_with_slug($slug);

        // Dynamic page features
        $page_header = $tool->title;
        $page_title = $tool->title;

        // SEO data
        $seo_data = array(
            "description" => $tool->description,
            "image_url" => $tool->featured_image_url
        );

        // Return view
        return view('pages.view-tool')->with('seo_data', $seo_data)->with('page_title', $page_title)->with('page_header', $page_header)->with('tool', $post);
    }

    public function update(Request $data) {
        // Get data and update
    	$tool_helper = new ToolHelper();
        $tool_data = array(
            "tool_id" => $data->tool_id,
            "title" => $data->title,
            "slug" => $data->slug,
            "description" => $data->description,
            "amount" => $data->amount,
            "featured_image_url" => $data->featured_image_url,
            "plan_id" => $data->plan_id
        );
    	$tool_helper->update($tool_data);

        // Redirect to admin view
    	return redirect(url('/admin/tools/view'));
    }

    public function delete(Request $data) {
        // Get data and delete
    	$tool_helper = new ToolHelper($data->tool_id);
    	$tool_helper->delete();

        // Redirect to admin view
    	return redirect(url('/admin/tools/view'));
    }

    /* Public Admin CRUD Functions */
    public function view_tools() {
        // Dynamic page features
        $page_header = "Tools";

        // Protect admin backend
        $this->protect();

        // Get tools
        $tool_helper = new ToolHelper();
        $tools = $tool_helper->get_all();

        // Return view
        return view('admin.tools.view')->with('page_header', $page_header)->with('tools', $tools);
    }

    public function new_tool() {
        // Dynamic page features
        $page_header = "New Tool";

        // Protect admin backend
        $this->protect();

        // Return view
        return view('admin.tools.new')->with('page_header', $page_header);
    }

    public function edit_tool($tool_id) {
        // Dynamic page features
        $page_header = "Edit Tool";

        // Protect admin backend
        $this->protect();

        // Get tool
        $tool_helper = new ToolHelper($post_id);
        $tool = $tool_helper->read();

        // Return view
        return view('admin.tools.edit')->with('page_header', $page_header)->with('tool', $tool);
    }

    /* Private helper functions */
    private function protect() {
        if (Session::has('admin_login')) {
            if (Session::get('admin_login') == false) {
                return redirect(url('/admin'));
            }
        } else {
            return redirect(url('/admin'));
        }
    }

}
