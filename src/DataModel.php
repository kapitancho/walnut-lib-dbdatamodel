<?php

namespace Walnut\Lib\DbDataModel;

use Walnut\Lib\DbDataModel\Attribute\ModelRoot;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
final class DataModel {
	/**
	 * DataModel constructor.
	 * @param ModelRoot $modelRoot
	 * @param array<string, DataPart> $parts
	 */
	public function __construct(
		public /*readonly*/ ModelRoot $modelRoot,
		public /*readonly*/ array $parts
	) {}

	public function part(string $modelName): DataPart {
		return $this->parts[$modelName] ??
			throw new InvalidDataModel("Expected model $modelName is missing");
	}
}