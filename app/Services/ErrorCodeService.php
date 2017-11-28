<?php namespace App\Services;

class ErrorCodeService
{
	// 0 - null

	// 1.0 - validation
	// 1.1 - validation : input
	// 1.2 - validation : expired
	// 1.3 - validation : password
	// 1.4 - validation : token

	// 2.0 - authentication

	// 100.0 - db : account
	// 101.0 - db : account_email
	// 102.0 - db : account_password
	// 103.0 - db : checklists
	// 104.0 - db : checklist_items
	// 105.0 - db : checklist_roles
	// ***.1 - get
	// ***.2 - create
	// ***.3 - update
	// ***.4 - delete

	public static $null = "0";

	public static $validation = "1.0";
	public static $validation_input = "1.1";
	public static $validation_expired = "1.2";
	public static $validation_password = "1.3";
	public static $validation_token = "1.4";

	public static $authentication = "2.0";

	public static $db_accounts = "100.0";
	public static $db_accounts_get = "100.1";
	public static $db_accounts_create = "100.2";
	public static $db_accounts_update = "100.3";
	public static $db_accounts_delete = "100.4";

	public static $db_account_emails = "101.0";
	public static $db_account_emails_get = "101.1";
	public static $db_account_emails_create = "101.2";
	public static $db_account_emails_update = "101.3";
	public static $db_account_emails_delete = "101.4";

	public static $db_account_passwords = "102.0";
	public static $db_account_passwords_get = "102.1";
	public static $db_account_passwords_create = "102.2";
	public static $db_account_passwords_update = "102.3";
	public static $db_account_passwords_delete = "102.4";

	public static $db_checklists = "103.0";
	public static $db_checklists_get = "103.1";
	public static $db_checklists_create = "103.2";
	public static $db_checklists_update = "103.3";
	public static $db_checklists_delete = "103.4";

	public static $db_checklist_items = "104.0";
	public static $db_checklist_items_get = "104.1";
	public static $db_checklist_items_create = "104.2";
	public static $db_checklist_items_update = "104.3";
	public static $db_checklist_items_delete = "104.4";
	
	public static $db_checklist_roles = "105.0";
	public static $db_checklist_roles_get = "105.1";
	public static $db_checklist_roles_create = "105.2";
	public static $db_checklist_roles_update = "105.3";
	public static $db_checklist_roles_delete = "105.4";
	
	public static $db_checklist_discussions = "106.0";
	public static $db_checklist_discussions_get = "106.1";
	public static $db_checklist_discussions_create = "106.2";
	public static $db_checklist_discussions_update = "106.3";
	public static $db_checklist_discussions_delete = "106.4";
}
