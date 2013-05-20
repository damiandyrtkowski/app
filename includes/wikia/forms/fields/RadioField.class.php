<?php

class RadioField extends BaseField
{
	const TYPE = 'radio';
	const PROPERTY_CHOICES = 'choices';

	protected function getType() {
		return self::TYPE;
	}
	
	public function __construct($options = []) {
		parent::__construct($options);
		
		if( isset($options['choices']) ) {
			$this->setProperty(self::PROPERTY_CHOICES, $options['choices']);
		}
	}
	
	public function render($attributes = []) {
		$data = [];
		$data['type'] = $this->getType();
		$choices = $this->getChoices();
		$choices = ( empty($choices) ) ? [$this->getValue()] : $this->getChoices();

		$out = '';
		$i = 0;
		$out .= $this->renderLabel(
			isset($attributes['label']) ? $attributes['label'] : [],
			$i
		);
		
		//FIXME: this is hack; we need to think about how to remove it: overwrite renderLabel or other method?
		$this->setProperty(self::PROPERTY_LABEL, null);
		foreach($choices as $choice) {
			if( !empty($choice['label']) ) {
				$out .= $choice['label']->render($this->getId() . '_' . $i);
			}
			
			$data['value'] = $choice['value'];
			$out .= $this->renderInternal(__CLASS__, $attributes, $data);
			$i++;
		}
		
		return $out;
	}
	
	protected function getChoices() {
		return $this->getProperty(self::PROPERTY_CHOICES);
	}
}
