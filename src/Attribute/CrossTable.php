<?php

namespace Walnut\Lib\DbDataModel\Attribute;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class CrossTable {
	public function __construct(
		public /*readonly*/ string $tableName,
		public /*readonly*/ string $parentField,
		public /*readonly*/ string $sourceField,
		public /*readonly*/ string $targetField
	) {}
}
