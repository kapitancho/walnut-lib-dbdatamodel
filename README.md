# Database Data Model
An elegant way to define relational models.

## Examples

### Client Domain Model
```php
#[ModelRoot('clients')]
final class ClientDomainModel {
    public function __construct(
        #[Table("clients")]
        #[KeyField('id'), Fields('name')]
        #[OneOf(fieldName: 'address', targetName: 'addresses', sourceField: 'address_id')]
        #[OneOf(fieldName: 'account', targetName: 'accounts')]
        #[ListOf(fieldName: 'contacts', targetName: 'contacts')]
        public array $clients,

            #[Table('addresses')]
            #[KeyField('id'), ParentField('id'), Fields('city', 'street')]
            public array $addresses,

            #[Table('client_accounts')]
            #[KeyField('id'), ParentField('client_id'), Fields('account_name')]
            public array $accounts,

            #[Table("client_contacts")]
            #[KeyField('id'), ParentField('client_id'), Fields('contact_name', 'position'), SortField('sequence')]
            #[ListOf(fieldName: 'phones', targetName: 'phones')]
            public array $contacts,

            #[Table("client_contact_phones")]
            #[KeyField('id'), ParentField('contact_id'), Fields('phone_number')]
            public array $phones
    ) {}
}
```

### User Domain Model
```php
#[ModelRoot('users')]
class UserDomainModel {
    public function __construct(
        #[Table("org_users")]
        #[KeyField('id'), Fields('first_name', 'org_id')]
        #[ListOf(fieldName: 'credentials', targetName: 'userCredentials')]
        #[ListOf(fieldName: 'roles', targetName: 'roles')]
        #[ListOf(fieldName: 'tags', targetName: 'tags')]
        public array $users,

            #[Table('org_user_roles'), KeyField('id'), ParentField('user_id'), Fields('role_id'), GroupField('code')]
            public array $roles,

            #[Table('org_user_credentials')]
            #[KeyField('id'), ParentField('user_id'), Fields('username', 'password')]
            public array $userCredentials,

            #[Table("org_user_tags"), KeyField('id'), ParentField('user_id'), Fields('tag_id')]
            public array $tags
    ) {}
}
```

### User Query Model
```php
#[ModelRoot('users')]
class UserQueryModel {
    public function __construct(
        #[Table("org_users")]
        #[KeyField('id'), Fields('first_name', 'org_id')]
        #[OneOf(fieldName: 'org', targetName: 'orgs', sourceField: 'org_id')]
        #[ListOf(fieldName: 'credentials', targetName: 'userCredentials')]
        #[ListOf(fieldName: 'roles', targetName: 'roles')]
        #[ListOf(fieldName: 'tags', targetName: 'tags')]
        public array $users,

            #[CrossTable('org_user_roles', parentField: 'user_id', sourceField: 'role_id', targetField: 'id')]
            #[Table('org_roles'), KeyField('id'), Fields('name', 'code'), GroupField('code')]
            public array $roles,

            #[Table('orgs')]
            #[KeyField('id'), Fields('name'), ParentField('id')]
            public array $orgs,

            #[Table('org_user_credentials')]
            #[KeyField('id'), ParentField('user_id'), Fields('username', 'password')]
            public array $userCredentials,

            #[CrossTable('org_user_tags', parentField: 'user_id', sourceField: 'tag_id', targetField: 'id')]
            #[Table("org_tag_user_group_values"), KeyField('id'), Fields('value', 'group_id'), GroupField('id')]
            #[OneOf(fieldName: 'group', targetName: 'tagGroups', sourceField: 'group_id')]
            public array $tags,

                #[Table("org_tag_user_groups"), KeyField('id'), Fields('name'), ParentField('id')]
                public array $tagGroups
    ) {}
}
```

### Tag User Groups Query Model
```php
#[ModelRoot('tagUserGroups')]
class TagUserGroupQueryModel {
    public function __construct(
        #[Table("org_tag_user_groups"), KeyField('id'), Fields('name')]
        #[ListOf(fieldName: 'values', targetName: 'tagUserGroupValues')]
        public array $tagUserGroups,

            #[Table("org_tag_user_group_values"), KeyField('id'),
                ParentField('group_id'), Fields('value'),
                SortField('sequence'), GroupField('id')]
            public array $tagUserGroupValues

    ) {}
}
```