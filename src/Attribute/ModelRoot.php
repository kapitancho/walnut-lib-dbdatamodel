<?php

namespace Walnut\Lib\DbDataModel\Attribute;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class ModelRoot {
	public function __construct(
		public readonly string $modelRoot
	) {}
}
