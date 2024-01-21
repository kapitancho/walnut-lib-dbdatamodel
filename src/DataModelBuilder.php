<?php

namespace Walnut\Lib\DbDataModel;

/**
 * @package Walnut\Lib\Persistence\Orm
 */
interface DataModelBuilder {
	/**
	 * @param class-string $modelClass
	 * @return DataModel
	 * @throws InvalidDataModel
	 */
	public function build(string $modelClass): DataModel;
}