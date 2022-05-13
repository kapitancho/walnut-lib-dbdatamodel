<?php

namespace Walnut\Lib\DbDataModel\Attribute;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Table {
	public function __construct(
		public readonly string $tableName
	) {}
}
