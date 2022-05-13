<?php

namespace Walnut\Lib\DbDataModel\Attribute;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Fields {
	/**
	 * @var string[]
	 */
	public readonly array $fieldNames;

	public function __construct(string ...$fieldNames) {
		$this->fieldNames = $fieldNames;
	}
}
