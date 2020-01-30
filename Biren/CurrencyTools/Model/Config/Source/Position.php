<?php
namespace Biren\CurrencyTools\Model\Config\Source;

class Position implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * Return array of options as value-label pairs, eg. value => label
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		return [
			'left' => 'Left',
			'right' => 'Right',
		];
	}
}