<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\DbDataModel\Attribute\CrossTable;
use Walnut\Lib\DbDataModel\Attribute\Fields;
use Walnut\Lib\DbDataModel\Attribute\GroupField;
use Walnut\Lib\DbDataModel\Attribute\KeyField;
use Walnut\Lib\DbDataModel\Attribute\ListOf;
use Walnut\Lib\DbDataModel\Attribute\ModelRoot;
use Walnut\Lib\DbDataModel\Attribute\OneOf;
use Walnut\Lib\DbDataModel\Attribute\ParentField;
use Walnut\Lib\DbDataModel\Attribute\SortField;
use Walnut\Lib\DbDataModel\Attribute\Table;
use Walnut\Lib\DbDataModel\DataModel;
use Walnut\Lib\DbDataModel\DataPart;
use Walnut\Lib\DbDataModel\InvalidDataModel;

final class DataModelTest extends TestCase {

	public function testOk(): void {
		$dataModel = new DataModel(
			new ModelRoot('users'),
			['users' => new DataPart(
				new Table("users"),
				new Fields("first_name", "last_name"),
				new KeyField("user_id"),
				new ParentField("customer_id"),
				new CrossTable("customer_users", 'customer_id', 'user_id', 'parent'),
				new SortField("sequence"),
				new GroupField("group_id"),
				[new OneOf("credentials", 'user_credentials')],
				[new ListOf("roles", 'user_roles')],
			)]
		);
		$this->assertNotNull($dataModel->part('users'));
	}

	public function testInvalidDataModel(): void {
		$this->expectException(InvalidDataModel::class);
		(new DataModel(
			new ModelRoot("root"),
			[]
		))->part("any");
	}

}