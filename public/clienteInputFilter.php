<?php
error_reporting(-1);

use Zend\InputFilter\InputFilter;

class clienteInputFilter extends InputFilter
{
	echo 'teste';exit;
	function __construnct()
	{

		$this->add(array(
			'name' => 'nome',
			'required' => true,
			'filters' => array(
				array('name' => 'StringTrim'),
				array('name' => 'StripTags')
			),
			'validators' => array(
				array('name' => 'NotEmpty'),
				array(
					'options' => array(
						'messages' => array(
							\Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatorio'
						)
					)
				)
			)

		));
	}

}





$validator = new clienteInputFilter();
$validator->setData(array(
	'nome' => ''
));

if ($validator->isValid()) {
	$teste = $validator->getValues();
} else {
	var_dump($validator->getMessages());
}