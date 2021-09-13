<?php

namespace Walnut\Lib\DbDataModel\Attribute;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_PROPERTY)]
final class OneOf {
	public function __construct(
		public /*readonly*/ string $fieldName,
		public /*readonly*/ string $targetName,
		public /*readonly*/ ?string $sourceField = null
	) {}
}
