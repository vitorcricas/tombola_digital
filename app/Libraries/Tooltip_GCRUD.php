<?php namespace App\Libraries;


//use App\Libraries\GroceryCrud;

class Tooltip_GCRUD extends GroceryCrud {

	protected $unset_ajax_extension			= false;
	protected $state_code 			= null;
	private $slash_replacement	= "_agsl_";
	protected $relation_dependency		= array();

	function __construct()
	{
		parent::__construct();

		$this->states[101]='ajax_extension';

	}
	/**
	 *
	 * Changes the displaying label of the field
	 * @param $field_name
	 * @param $tooltip
	 * @return void
	 */
	public function tooltip($field_name, $tooltip = null)
	{
		if(is_array($field_name))
		{
			foreach($field_name as $field => $tooltip)
			{
				$this->tooltip[$field] = $tooltip;
			}
		}
		elseif($tooltip !== null)
		{
			$this->tooltip[$field_name] = '<a href="#" id="ttip_'.$field_name. '" 
          data-toggle="tooltip" title="'.$tooltip.'">
          <span class="fa fa-question-circle"></span></a>
            <!--<script>$("#ttip_'.$field_name.'").tooltip();</script>-->';
		}

		return $this;
	}
	protected function get_add_fields()
	{
		$this->add_fields=parent::get_add_fields();
		foreach ($this->add_fields as $campos) {
			if(isset($this->tooltip[$campos->field_name])){
                $campos->tooltip=$this->tooltip[$campos->field_name];
			} else {
                 $campos->tooltip='<span class="fa"></span>';
			}
		}

		return $this->add_fields;
		
	}	

	protected function get_edit_fields()
	{
		$this->edit_fields=parent::get_edit_fields();
		foreach ($this->edit_fields as $campos) {
			if(isset($this->tooltip[$campos->field_name])){
                $campos->tooltip=$this->tooltip[$campos->field_name];
			} else {
                 $campos->tooltip='<span class="fa"></span>';
			}
		}

		return $this->edit_fields;
		
	}

}	